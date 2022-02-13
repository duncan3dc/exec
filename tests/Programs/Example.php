<?php

namespace duncan3dc\ExecTests\Programs;

use duncan3dc\Exec\Output\OutputInterface;
use duncan3dc\Exec\ProgramInterface;
use duncan3dc\Exec\Result;
use duncan3dc\Exec\ResultInterface;

final class Example implements ProgramInterface
{
    /**
     * @var string $program The name of the program to run.
     */
    private $program;

    /**
     * @var OutputInterface $output The output instance to log to.
     */
    private $output;

    /**
     * @var string $color The colour to display the output for this program in.
     */
    private $color = "default";

    /**
     * @var string $path The working directory to run this program in.
     */
    private $path = "default";

    /**
     * @var array<string, string> $env The environment variables to set for the program.
     */
    private $env = [];

    /**
     * @var string[] A list of environment variables that are private.
     */
    private $private = [];


    /**
     * Create a new instance.
     *
     * @param string $program The name of the program to run
     * @param OutputInterface $output The output instance to log to
     */
    public function __construct($program, OutputInterface $output)
    {
        $this->program = $program;
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
    public function withPrivateEnv(string $key, string $value): ProgramInterface
    {
        $program = clone $this;
        $program->env[$key] = $value;
        $program->private[] = $key;
        return $program;
    }


    /**
     * @inheritDoc
     */
    public function getResult(string ...$arguments): ResultInterface
    {
        return new Result(0, []);
    }


    /**
     * @inheritDoc
     */
    public function exec(string ...$arguments): ResultInterface
    {
        return $this->getResult(...$arguments);
    }


    /**
     * @inheritDoc
     */
    public function isInstalled(): bool
    {
        return false;
    }


    public function getProgram(): string
    {
        return $this->program;
    }


    public function getOutput(): OutputInterface
    {
        return $this->output;
    }


    public function getColor(): string
    {
        return $this->color;
    }


    public function getPath(): string
    {
        return $this->path;
    }


    /**
     * @return array<string, string>
     */
    public function getEnv(): array
    {
        return $this->env;
    }


    /**
     * @return string[]
     */
    public function getPrivateEnv(): array
    {
        return $this->private;
    }
}
