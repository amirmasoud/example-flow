<?php

namespace Support\Containers\Exceptions;

use Support\Shell;

class DockerComposeFailedException extends \Exception
{
    public function __construct(string $command, string $path)
    {
        parent::__construct("Docker compose {$command} command failed for the {$path} compose file.");
    }

    public function render($request = null): void
    {
        $console = app('console');
        $shell = app(Shell::class);

        $console->line('');
        $console->line($shell->formatErrorMessage($this->getMessage()));
    }
}
