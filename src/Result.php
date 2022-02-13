<?php

namespace duncan3dc\Exec;

use function count;
use function current;
use function end;
use function implode;
use function key;
use function next;
use function reset;

final class Result implements ResultInterface
{
    /**
     * @var int The exit code of the command.
     */
    private $status;

    /**
     * @var array<string> All of the output from the command.
     */
    private $lines;


    /**
     * Create a new instance.
     *
     * @param int $status The exit code of the command
     * @param string[] $lines All of the output from the command
     */
    public function __construct(int $status, array $lines)
    {
        $this->status = $status;
        $this->lines = $lines;
    }


    /**
     * Get the exit code of the command.
     *
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }


    /**
     * Get all the lines of the output.
     *
     * @return string[]
     */
    public function getLines(): array
    {
        return $this->lines;
    }


    /**
     * Get the first line of the output.
     *
     * @return string
     */
    public function getFirstLine(): string
    {
        return (string) reset($this->lines);
    }


    /**
     * Get the last line of the output.
     *
     * @return string
     */
    public function getLastLine(): string
    {
        return (string) end($this->lines);
    }


    /**
     * Get all the output as a string
     *
     * @return string
     */
    public function __toString(): string
    {
        return implode("\n", $this->lines);
    }


    /**
     * Get the number of lines in the output.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->lines);
    }


    /**
     * @inheritDoc
     */
    public function current(): string
    {
        return (string) current($this->lines);
    }


    /**
     * @inheritDoc
     */
    public function next(): void
    {
        next($this->lines);
    }


    /**
     * @inheritDoc
     */
    public function key(): int
    {
        return (int) key($this->lines);
    }


    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        $valid = key($this->lines);
        return ($valid !== null);
    }


    /**
     * @inheritDoc
     */
    public function rewind(): void
    {
        reset($this->lines);
    }
}
