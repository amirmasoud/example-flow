<?php

namespace Support\Containers\Exceptions;

use Exception;
use Support\Shell;
use Symfony\Component\Console\Command\Command;

class CommandExecutionFailed extends Exception
{
    public function __construct(string $command)
    {
        parent::__construct("Command ($command) execution failed.");
    }

    public function render($request = null): void
    {
        $console = app(Command::class);
        $shell = app(Shell::class);

        $console->line('');
        $console->line($shell->formatErrorMessage($this->getMessage()));
    }
}
