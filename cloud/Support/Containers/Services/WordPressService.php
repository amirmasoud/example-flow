<?php

namespace Support\Containers\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Support\Certificates\SelfSigned;
use Support\Containers\Enums\ImageEnum;
use Support\Containers\Exceptions\CommandExecutionFailed;
use Support\Containers\Shell\DockerCompose;
use Support\Containers\Shell\DockerNetworking;
use Support\Containers\Shell\DockerSwarm;
use Touhidurabir\StubGenerator\Facades\StubGenerator;

class WordPressService
{
    /**
     * @throws \Support\Certificates\Exceptions\MkcertMissingException
     */
    public static function install(string $host, ImageEnum $image = ImageEnum::WORDPRESS_NGINX_MARIADB, bool $force = false): bool
    {
        $sites = Storage::disk(config('cloud.disks.sites'));
        $dir = underscore_slug($host);

        // Create docker-compose.yml
        if (! File::exists($sites->path($dir.'/docker-compose.yml'))) {
            StubGenerator::from($image->path('docker-compose.yml.stub'), asFullPath: true)
                ->to($sites->path($dir), createIfNotExist: true, asFullPath: true)
                ->as('docker-compose')->ext('yml')
                ->save();
        }

        // Create .env
        if (! File::exists($sites->path($dir.'/.env'))) {
            StubGenerator::from($image->path('env.stub'), asFullPath: true)
                ->to($sites->path($dir), createIfNotExist: true, asFullPath: true)
                ->as('.env')->noExt()
                ->withReplacers([
                    'name' => underscore_slug($host),
                    'site_url' => 'https://'.$host,
                    'host' => $host,
                ])
                ->save();
        }

        // Copy config directory
        if (! File::isDirectory($sites->path($dir.'/config'))) {
            File::copyDirectory($image->path('/config'), $sites->path("$dir/config"));
        }

        // Generate SSL certificate
        app(SelfSigned::class)->generate($dir);

        return true;
    }

    /**
     * @throws \Support\Containers\Exceptions\DockerComposePathNotDirectoryException
     * @throws \Support\Containers\Exceptions\DockerComposeMissingException
     */
    public static function deploySwarm(string $host): bool
    {
        app(DockerNetworking::class)->ensureNetworkCreated();

        return DockerSwarm::for($host, Storage::disk(config('cloud.disks.sites'))->path(underscore_slug($host)))->deploy();
    }

    /**
     * @throws \Support\Containers\Exceptions\DockerComposePathNotDirectoryException
     * @throws \Support\Containers\Exceptions\DockerComposeMissingException
     * @throws \Support\Containers\Exceptions\DockerSwarmServiceMissingException
     * @throws CommandExecutionFailed
     */
    public static function execSwarm(string $host, string $command, string $service = 'wordpress-cli'): bool
    {
        if (! DockerSwarm::for($host)->command(underscore_slug($host)."_$service", $command)->isSuccessful()) {
            throw new CommandExecutionFailed($command);
        }

        return true;
    }

    /**
     * @throws \Support\Containers\Exceptions\DockerComposePathNotDirectoryException
     * @throws \Support\Containers\Exceptions\DockerComposeMissingException
     */
    public static function removeSwarm(string $host): bool
    {
        DockerSwarm::for(underscore_slug($host))->removeStack();

        return true;
    }

    /**
     * @throws \Support\Containers\Exceptions\DockerComposePathNotDirectoryException
     * @throws \Support\Containers\Exceptions\DockerComposeMissingException
     * @throws \Support\Containers\Exceptions\DockerSwarmServiceMissingException
     */
    public static function noReplicaSwarm(string $host): bool
    {
        DockerSwarm::for(underscore_slug($host))->updateReplicas(underscore_slug($host).'_database', 0);
        DockerSwarm::for(underscore_slug($host))->updateReplicas(underscore_slug($host).'_wordpress', 0);
        DockerSwarm::for(underscore_slug($host))->updateReplicas(underscore_slug($host).'_proxy', 0);
        DockerSwarm::for(underscore_slug($host))->updateReplicas(underscore_slug($host).'_wordpress-cli', 0);

        return true;
    }

    /**
     * @throws \Support\Containers\Exceptions\DockerComposePathNotDirectoryException
     * @throws \Support\Containers\Exceptions\DockerComposeMissingException
     * @throws \Support\Containers\Exceptions\DockerSwarmServiceMissingException
     */
    public static function oneReplicaSwarm(string $host): bool
    {
        // Order matters
        DockerSwarm::for(underscore_slug($host))->updateReplicas(underscore_slug($host).'_database', 1);
        DockerSwarm::for(underscore_slug($host))->updateReplicas(underscore_slug($host).'_wordpress', 1);
        DockerSwarm::for(underscore_slug($host))->updateReplicas(underscore_slug($host).'_proxy', 1);
        DockerSwarm::for(underscore_slug($host))->updateReplicas(underscore_slug($host).'_wordpress-cli', 1);

        return true;
    }

    /**
     * @throws \Support\Containers\Exceptions\DockerComposePathNotDirectoryException
     * @throws \Support\Containers\Exceptions\DockerComposeMissingException
     * @throws \Support\Containers\Exceptions\DockerComposeFailedException
     */
    public static function deployCompose(string $host): bool
    {
        app(DockerNetworking::class)->ensureNetworkCreated('proxy', 'bridge');

        return DockerCompose::for($host)->up();
    }

    /**
     * @throws \Support\Containers\Exceptions\DockerComposePathNotDirectoryException
     * @throws \Support\Containers\Exceptions\DockerComposeMissingException
     * @throws CommandExecutionFailed
     */
    public static function execCompose(string $host, string $command, string $service = 'wordpress-cli'): bool
    {
        $command = line($command);

        if (! DockerCompose::for($host)->command("$service $command")) {
            throw new CommandExecutionFailed("docker-compose exec -T $service $command");
        }

        return true;
    }

    /**
     * @throws \Support\Containers\Exceptions\DockerComposePathNotDirectoryException
     * @throws \Support\Containers\Exceptions\DockerComposeMissingException
     * @throws \Support\Containers\Exceptions\DockerComposeFailedException
     */
    public static function stopCompose(string $host): bool
    {
        return DockerCompose::for($host)->stop();
    }

    /**
     * @throws \Support\Containers\Exceptions\DockerComposePathNotDirectoryException
     * @throws \Support\Containers\Exceptions\DockerComposeMissingException
     * @throws \Support\Containers\Exceptions\DockerComposeFailedException
     */
    public static function startCompose(string $host): bool
    {
        return DockerCompose::for($host)->up();
    }

    /**
     * @throws \Support\Containers\Exceptions\DockerComposePathNotDirectoryException
     * @throws \Support\Containers\Exceptions\DockerComposeMissingException
     */
    public static function restartCompose(string $host): bool
    {
        return DockerCompose::for($host)->restart();
    }

    /**
     * @throws \Support\Containers\Exceptions\DockerComposePathNotDirectoryException
     * @throws \Support\Containers\Exceptions\DockerComposeMissingException
     */
    public static function removeCompose(string $host): bool
    {
        DockerCompose::for($host)->down();

        File::deleteDirectory(Storage::disk(config('cloud.disks.sites'))->path(underscore_slug($host))); // This should not be here :/

        return true;
    }
}
