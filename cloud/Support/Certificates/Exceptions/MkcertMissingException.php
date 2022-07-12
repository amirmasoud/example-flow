<?php

namespace Support\Certificates\Exceptions;

use Exception;
use Support\Shell;

class MkcertMissingException extends Exception
{
    public function __construct()
    {
        parent::__construct('Mkcert command not found.');
    }

    public function render($request = null): void
    {
        $console = app('console');
        $shell = app(Shell::class);

        $console->line('');
        $console->line($shell->formatErrorMessage('Docker is not installed.'));
        $console->line('');
        $console->line($shell->formatErrorMessage('Please visit https://github.com/FiloSottile/mkcert'));
        $console->line($shell->formatErrorMessage('for information on how to install mkcert for your machine.'));
    }
}
