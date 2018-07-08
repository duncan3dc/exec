<?php

namespace duncan3dc\Exec\Output;

final class Plain implements OutputInterface
{

    /**
     * @inheritDoc
     */
    public function command(string $command, string $color): void
    {
        echo $command;
    }


    /**
     * @inheritDoc
     */
    public function output(string $line, string $color): void
    {
        echo "\t{$line}";
    }


    /**
     * @inheritDoc
     */
    public function break(string $color): void
    {
        echo "\n";
    }


    /**
     * @inheritDoc
     */
    public function end(string $color): void
    {
        $this->break($color);
        echo new Line;
        $this->break($color);
    }
}
