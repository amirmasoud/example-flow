<?php

namespace Support\Containers\Shell;

use Illuminate\Support\Collection;
use Support\Containers\Exceptions\DockerSwarmServiceMissingException;

class DockerSwarm extends DockerShell
{
    public function deploy(): bool
    {
        return static::$shell->exec(
            'cd '.static::$path
            // Print docker-compose output and fix quotation marks in the output and deploy the site
            .' && docker-compose config | sed -E "s/cpus: ([0-9\\.]+)/cpus: \'\\1\'/" | docker stack deploy --compose-file - '.underscore_slug(static::$name)
        )->isSuccessful();
    }

    /**
     * @throws DockerSwarmServiceMissingException
     */
    public function updateReplicas(string $service, int $replicas = 1): bool
    {
        if (! $this->services()->contains(function ($runningService) use ($service) {
            return $runningService['name'] === $service;
        })) {
            throw new DockerSwarmServiceMissingException($service);
        }

        return static::$shell->exec(
            'cd '.static::$path
            .' && docker service update --replicas='.$replicas.' '.$service
        )->isSuccessful();
    }

    public function services(): Collection
    {
        return $this->runAndParseTable(
            'cd '.static::$path
            .' && docker stack services '.underscore_slug(static::$name).' --format "table {{.ID}}|{{.Name}}|{{.Mode}}|{{.Replicas}}|{{.Image}}|{{.Ports}}"'
        );
    }

    public function removeStack(): bool
    {
        return static::$shell->exec(
            'cd '.static::$path
            .' && docker stack rm '.underscore_slug(static::$name)
        )->isSuccessful();
    }

    /**
     * @throws DockerSwarmServiceMissingException
     */
    public function command(string $service, string $command): \Symfony\Component\Process\Process
    {
        if (! $this->services()->contains(function ($runningService) use ($service) {
            return $runningService['name'] === $service;
        })) {
            throw new DockerSwarmServiceMissingException($service);
        }

        $serviceId = static::$shell->exec(line("docker service ps -f name={$service}.1 -f desired-state=running {$service} -q --no-trunc | head -n1"))->getOutput();

        return static::$shell->exec(line("docker exec --tty=false {$service}.1.{$serviceId} {$command}"));
    }
}
