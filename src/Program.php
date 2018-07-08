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
    public function getResult(string ...$arguments): ResultInterface
    {
        $command = $this->program;
        foreach ($arguments as $argument) {
            $command .= " " . escapeshellarg($argument);
        }

        $this->output->command($command, $this->color);
        $this->output->break($this->color);

        $exec = trim($command);
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
}
