<?php

namespace Support\Containers\Exceptions;

use Exception;
use Support\Shell;
use Symfony\Component\Console\Command\Command;

class DockerSwarmServiceMissingException extends Exception
{
    public function __construct(string $service)
    {
        parent::__construct("Docker swarm service {$service} not found.");
    }

    public function render($request = null): void
    {
        $console = app(Command::class);
        $shell = app(Shell::class);

        $console->line('');
        $console->line($shell->formatErrorMessage($this->getMessage()));
    }
}
