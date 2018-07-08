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
}
