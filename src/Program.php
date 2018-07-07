<?php

namespace duncan3dc\Exec;

use duncan3dc\Exec\Exceptions\ProgramException;
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
     * Create a new instance.
     *
     * @param string $program The name of the program to run
     */
    public function __construct(string $program)
    {
        $this->program = trim($program);
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

        $exec = trim($command);
        exec("{$exec} 2>&1", $lines, $status);

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
