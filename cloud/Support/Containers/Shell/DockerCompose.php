<?php

namespace Support\Containers\Shell;

use Support\Containers\DataTransferObjects\ContainersData;

class DockerCompose extends DockerShell
{
    public static function isInstalled(): bool
    {
        return static::$shell->execQuietly('docker-compose --version 2>&1')->isSuccessful();
    }

    public function up(): bool
    {
        return static::$shell->exec('cd '.static::$path.' && docker-compose up -d')->isSuccessful();
    }

    /**
     * @param  string  $rmi options: all, local
     * @param  bool  $volumes
     * @return bool
     */
    public function down(string $rmi = 'all', bool $volumes = true): bool
    {
        $rmi = "--rmi=$rmi";
        $v = $volumes ? '--volumes' : '';

        return static::$shell->exec('cd '.static::$path." && docker-compose down $rmi $v")->isSuccessful();
    }

    public function stop(): bool
    {
        return static::$shell->exec('cd '.static::$path.' && docker-compose stop')->isSuccessful();
    }

    public function restart(): bool
    {
        return static::$shell->exec('cd '.static::$path.' && docker-compose restart')->isSuccessful();
    }

    public function command(string $command): bool
    {
        return static::$shell->exec('cd '.static::$path.' && docker-compose exec -T '.$command)->isSuccessful();
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function status()
    {
        $output = static::$shell->execQuietly('cd '.static::$path.' && docker compose ps --format json')->getOutput();

        return new ContainersData(collect(['containers' => json_decode($output)])->toArray());
    }

    public function isRunning(): bool
    {
        return static::$shell->execQuietly('cd '.static::$path.' && docker-compose ps')->isSuccessful();
    }
}
