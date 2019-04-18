<?php

namespace duncan3dc\Exec;

use duncan3dc\Exec\Exceptions\Exception;

interface ProgramInterface
{

    /**
     * Get a new instance that outputs in a different colour.
     *
     * @param string $color One of the colour descriptions accepted by the output instance
     *
     * @return ProgramInterface
     */
    public function withColor(string $color): ProgramInterface;


    /**
     * Get a new instance that will run under the specified path.
     *
     * @param string $path The path to use
     *
     * @return ProgramInterface
     */
    public function withPath(string $path): ProgramInterface;


    /**
     * Get a new instance with an environment variable set.
     *
     * @param string $key The environmment variable to set
     * @param string $value The value to set
     *
     * @return ProgramInterface
     */
    public function withEnv(string $key, string $value): ProgramInterface;


    /**
     * Get a new instance with a private environment variable set.
     *
     * @param string $key The environment variable to set
     * @param string $value The value to set
     *
     * @return ProgramInterface
     */
    public function withPrivateEnv(string $key, string $value): ProgramInterface;


    /**
     * Execute a command and return its output (ignoring any errors).
     *
     * @param string ...$arguments Any additional arguments to pass to the command
     *
     * @return ResultInterface
     */
    public function getResult(string ...$arguments): ResultInterface;


    /**
     * Execute a command and return its output.
     *
     * @param string ...$arguments Any additional arguments to pass to the command
     *
     * @return ResultInterface
     * @throws Exception
     */
    public function exec(string ...$arguments): ResultInterface;


    /**
     * Check if the program is installed.
     *
     * @return bool
     */
    public function isInstalled(): bool;
}
