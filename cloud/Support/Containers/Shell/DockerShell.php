<?php

namespace Support\Containers\Shell;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Support\Containers\Exceptions\DockerComposeMissingException;
use Support\Containers\Exceptions\DockerComposePathNotDirectoryException;
use Support\Shell;
use Symfony\Component\Console\Output\ConsoleOutput;

class DockerShell extends Shell
{
    protected static string $name;

    protected static Shell $shell;

    protected static DockerFormatter $formatter;

    protected static DockerNetworking $networking;

    protected static Environment $environment;

    protected static string $path;

    /**
     * @throws DockerComposePathNotDirectoryException
     * @throws DockerComposeMissingException
     */
    public static function for(string $name, ?string $path = null): static
    {
        static::$name = $name;
        static::$shell = new Shell(new ConsoleOutput());
        static::$formatter = new DockerFormatter();
        static::$networking = new DockerNetworking(static::$shell, self::$formatter);
        static::$environment = new Environment(static::$shell);

        static::$path = static::getDockerComposePath($path);

        return new static(new ConsoleOutput());
    }

    /**
     * @throws DockerComposePathNotDirectoryException
     * @throws DockerComposeMissingException
     */
    protected static function getDockerComposePath(?string $path = null): string
    {
        $path = $path ?? Storage::disk(config('cloud.disks.sites'))->path(underscore_slug(static::$name));

        if (! File::isDirectory($path)) {
            throw new DockerComposePathNotDirectoryException($path ?? 'NULL');
        }

        if (! File::exists($path.'/docker-compose.yml')) {
            throw new DockerComposeMissingException($path.'/docker-compose.yml');
        }

        return $path;
    }
}
