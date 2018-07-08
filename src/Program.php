<?php

namespace duncan3dc\Exec;

use duncan3dc\Exec\Exceptions\ProgramException;
use duncan3dc\Exec\Output\OutputInterface;
use function escapeshellarg;
use function exec;
use function trim;

final class Program implements ProgramInterface
{
    /**
     * @var string $program The name of the program to run.
     */
    private $program;

    /**
     * @var OutputInterface The output instance to log to.
     */
    private $output;

    /**
     * @var string $color The colour to display the output for this program in.
     */
    private $color = "blue";

    /**
     * @var string|null $path The working directory to run this program in.
     */
    private $path;

    /**
     * @var array $env The environment variables to set for the program.
     */
    private $env = [];

    /**
     * @var bool|null $installed Whether this program is installed or not.
     */
    private $installed;


    /**
     * Create a new instance.
     *
     * @param string $program The name of the program to run
     * @param OutputInterface $output The output instance to log to
     */
    public function __construct(string $program, OutputInterface $output)
    {
        $this->program = trim($program);
        $this->output = $output;
    }


    /**
     * @inheritDoc
     */
    public function withColor(string $color): ProgramInterface
    {
        $program = clone $this;
        $program->color = $color;
        return $program;
    }


    /**
     * @inheritDoc
     */
    public function withPath(string $path): ProgramInterface
    {
        $program = clone $this;
        $program->path = $path;
        return $program;
    }


    /**
     * @inheritDoc
     */
    public function withEnv(string $key, string $value): ProgramInterface
    {
        $program = clone $this;
        $program->env[$key] = $value;
        return $program;
    }


    /**
     * @inheritDoc
     */
    public function getResult(string ...$arguments): ResultInterface
    {
        if ($this->path !== null) {
            $path = getcwd();
            chdir($this->path);
        }

        $command = $this->program;
        foreach ($arguments as $argument) {
            $command .= " " . escapeshellarg($argument);
        }

        $this->output->command($command, $this->color);
        $this->output->break($this->color);

        $env = "";
        foreach ($this->env as $key => $value) {
            $env .= "{$key}={$value} ";
            $this->output->env($key, $value, $this->color);
        }

        $exec = trim(trim($env) . " {$command}");
        exec("{$exec} 2>&1", $lines, $status);

        $first = true;
        foreach ($lines as $line) {
            if ($first) {
                $first = false;
            } else {
                $this->output->break($this->color);
            }
            $this->output->output($line, $this->color);
        }
        $this->output->end($this->color);

        if ($this->path !== null && isset($path)) {
            chdir($path);
        }

        return new Result($status, $lines);
    }


    /**
     * @inheritDoc
     */
    public function exec(string ...$arguments): ResultInterface
    {
        $result = $this->getResult(...$arguments);

        $status = $result->getStatus();
        if ($status > 0) {
            throw new ProgramException("The {$this->program} command failed (exit code: {$status})");
        }

        return $result;
    }


    /**
     * @inheritDoc
     */
    public function isInstalled(): bool
    {
        if ($this->installed !== null) {
            return $this->installed;
        }

        try {
            $which = new Program("which", $this->output);
            $which->exec($this->program);
        } catch (ProgramException $e) {
            $this->installed = false;
            return $this->installed;
        }

        $this->installed = true;
        return $this->installed;
    }
}
