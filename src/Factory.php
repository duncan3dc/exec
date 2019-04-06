<?php

namespace duncan3dc\Exec;

use duncan3dc\Exec\Output\OutputInterface;

final class Factory implements FactoryInterface
{
    /**
     * @var OutputInterface $output The output instance to log to.
     */
    private $output;

    /**
     * @var string|null $color The colour to display the output for this program in.
     */
    private $color;

    /**
     * @var string|null $path The working directory to run this program in.
     */
    private $path;

    /**
     * @var array $env The environment variables to set for the program.
     */
    private $env = [];


    /**
     * Create a new instance.
     *
     * @param OutputInterface $output The output instance to log to
     */
    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }


    /**
     * @inheritdoc
     */
    public function getOutput(): OutputInterface
    {
        return $this->output;
    }


    /**
     * @inheritdoc
     */
    public function withColor(string $color): FactoryInterface
    {
        $factory = clone $this;
        $factory->color = $color;
        return $factory;
    }


    /**
     * @inheritdoc
     */
    public function withPath(string $path): FactoryInterface
    {
        $factory = clone $this;
        $factory->path = $path;
        return $factory;
    }


    /**
     * @inheritdoc
     */
    public function withEnv(string $key, string $value): FactoryInterface
    {
        $factory = clone $this;
        $factory->env[$key] = $value;
        return $factory;
    }


    /**
     * @inheritdoc
     */
    public function make(string $name, string $class = Program::class): ProgramInterface
    {
        $program = new $class($name, $this->output);
        if (!$program instanceof ProgramInterface) {
            throw new \InvalidArgumentException("Custom class passed to " . self::class . "::make() must implement " . ProgramInterface::class);
        }

        if ($this->color !== null) {
            $program = $program->withColor($this->color);
        }

        if ($this->path !== null) {
            $program = $program->withPath($this->path);
        }

        foreach ($this->env as $key => $value) {
            $program = $program->withEnv($key, $value);
        }

        return $program;
    }
}
