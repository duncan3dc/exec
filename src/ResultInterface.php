<?php

namespace duncan3dc\Exec;

/**
 * @extends \Iterator<int, string>
 */
interface ResultInterface extends \Iterator, \Countable
{
    /**
     * Get the exit code of the command.
     *
     * @return int
     */
    public function getStatus(): int;

    /**
     * Get all the lines of the output.
     *
     * @return string[]
     */
    public function getLines(): array;

    /**
     * Get the first line of the output.
     *
     * @return string
     */
    public function getFirstLine(): string;

    /**
     * Get the last line of the output.
     *
     * @return string
     */
    public function getLastLine(): string;

    /**
     * Get all the output as a string
     *
     * @return string
     */
    public function __toString(): string;
}
