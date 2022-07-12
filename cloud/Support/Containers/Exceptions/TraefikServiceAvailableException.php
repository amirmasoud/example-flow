<?php

namespace Support\Containers\Exceptions;

use Exception;
use Support\Shell;

class TraefikServiceAvailableException extends Exception
{
    public function render($request = null): void
    {
        $console = app('console');
        $shell = app(Shell::class);

        $console->line('');
        $console->line($shell->formatErrorMessage('Traefik is already installed.'));
    }
}
