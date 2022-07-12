<?php

namespace Support\Containers\Exceptions;

use Support\Shell;

class DockerComposePathNotDirectoryException extends \Exception
{
    public function __construct(string $path)
    {
        parent::__construct("Docker compose path ({$path}) is not a directory.");
    }

    public function render($request = null): void
    {
        $console = app('console');
        $shell = app(Shell::class);

        $console->line('');
        $console->line($shell->formatErrorMessage($this->getMessage()));
    }
}
