<?php

namespace duncan3dc\Exec;

use duncan3dc\Exec\Exceptions\Exception;

interface ProgramInterface
{

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
