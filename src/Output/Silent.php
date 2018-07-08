<?php

namespace duncan3dc\Exec\Output;

final class Silent implements OutputInterface
{

    /**
     * @inheritDoc
     */
    public function command(string $command, string $color): void
    {
    }


    /**
     * @inheritDoc
     */
    public function output(string $line, string $color): void
    {
    }


    /**
     * @inheritDoc
     */
    public function break(string $color): void
    {
    }


    /**
     * @inheritDoc
     */
    public function end(string $color): void
    {
    }
}
