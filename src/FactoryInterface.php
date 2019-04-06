<?php

namespace duncan3dc\Exec;

use duncan3dc\Exec\Output\OutputInterface;

interface FactoryInterface
{
    /**
     * Get the output interface this factory is using.
     *
     * @return OutputInterface
     */
    public function getOutput(): OutputInterface;


    /**
     * Get a new instance that outputs in a different colour.
     *
     * @param string $color One of the colour descriptions accepted by the output instance
     *
     * @return self
     */
    public function withColor(string $color): self;


    /**
     * Get a new instance that will run under the specified path.
     *
     * @param string $path The path to use
     *
     * @return self
     */
    public function withPath(string $path): self;


    /**
     * Get a new instance with an environment variable set.
     *
     * @param string $key The environment variable to set
     * @param string $value The value to set
     *
     * @return self
     */
    public function withEnv(string $key, string $value): self;


    /**
     * Create a new program instance.
     *
     * @param string $name The name of the program to run
     * @param string $class A specific class instance to create
     *
     * @return ProgramInterface
     */
    public function make(string $name, string $class = Program::class): ProgramInterface;
}
