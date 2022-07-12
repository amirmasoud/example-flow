<?php

namespace Support\Containers\Exceptions;

use Exception;
use Support\Shell;

class InvalidServiceShortnameException extends Exception
{
    public function render($request = null)
    {
        $console = app('console');
        $shell = app(Shell::class);

        $console->line('');
        $console->line($shell->formatErrorMessage($this->getMessage()));
    }
}
