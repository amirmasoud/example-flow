<?php

namespace Support;

use Illuminate\Support\Collection;
use Support\Containers\Shell\DockerFormatter;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Process\Process;

class Shell
{
    protected $output;

    public function __construct(ConsoleOutput $output)
    {
        $this->output = $output;
    }

    public function formatErrorMessage(string $buffer)
    {
        return $this->formatMessage($buffer, true);
    }

    public function formatMessage(string $buffer, $isError = false): string
    {
        $pre = $isError ? '%s' : '%s'; // '<bg=red;fg=white> ERR </> %s' : '<bg=green;fg=white> OUT </> %s'

        return rtrim(collect(explode("\n", trim($buffer)))->reduce(function ($carry, $line) use ($pre) {
            return $carry .= trim(sprintf($pre, $line))."\n";
        }, ''));
    }

    protected function runAndParseTable(string $command): Collection
    {
        return app(DockerFormatter::class)->rawTableOutputToCollection(
            app(Shell::class)->execQuietly($command)->getOutput()
        );
    }

    public function execQuietly(string $command, array $parameters = []): Process
    {
        return $this->exec($command, $parameters, $quiet = true);
    }

    public function exec(string $command, array $parameters = [], bool $quiet = false): Process
    {
        $didAnything = false;

        $process = $this->buildProcess($command);
        $process->run(function ($type, $buffer) use ($quiet, $didAnything) {
            if (empty($buffer) || $buffer === PHP_EOL || $quiet) {
                return;
            }

            $this->output->writeLn($this->formatMessage($buffer, $type === process::ERR));
            $didAnything = true;
        }, $parameters);

        if ($didAnything) {
            $this->output->writeLn("\n");
        }

        return $process;
    }

    public function buildProcess(string $command): Process
    {
        $process = Process::fromShellCommandline($command);
        $process->setTimeout(null);

        return $process;
    }
}
