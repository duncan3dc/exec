<?php

namespace duncan3dc\Exec\Output;

use function mb_strlen;
use function str_repeat;

final class Line
{
    /**
     * @var string $character The character to use for the line.
     */
    private $character = "-";

    /**
     * @var int $length The length of the line to produce.
     */
    private $length = 80;


    /**
     * Create a new instance.
     *
     * @param string $character The character to use for the line
     * @param int $length The length of the line to produce
     */
    public function __construct(string $character = null, int $length = null)
    {
        if ($character !== null) {
            if (mb_strlen($character) !== 1) {
                throw new \InvalidArgumentException("Invalid character [{$character}], must be a single character");
            }
            $this->character = $character;
        }

        if ($length === null) {
            $this->length = 80;
        } else {
            $this->length = $length;
        }
    }


    /**
     * Generate the line.
     *
     * @return string
     */
    public function __toString(): string
    {
        return str_repeat($this->character, $this->length);
    }
}
