<?php

namespace duncan3dc\Exec;

use duncan3dc\Exec\Output\OutputInterface;

final class Factory
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
     * Get a new instance that outputs in a different colour.
     *
     * @param string $color One of the colour descriptions accepted by the output instance
     *
     * @return self
     */
    public function withColor(string $color): self
    {
        $factory = clone $this;
        $factory->color = $color;
        return $factory;
    }


    /**
     * Get a new instance that will run under the specified path.
     *
     * @param string $path The path to use
     *
     * @return self
     */
    public function withPath(string $path): self
    {
        $factory = clone $this;
        $factory->path = $path;
        return $factory;
    }


    /**
     * Get a new instance with an environment variable set.
     *
     * @param string $key The environmment variable to set
     * @param string $value The value to set
     *
     * @return self
     */
    public function withEnv(string $key, string $value): self
    {
        $factory = clone $this;
        $factory->env[$key] = $value;
        return $factory;
    }


    /**
     * Create a new program instance.
     *
     * @return ProgramInterface
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
