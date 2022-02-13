<?php

namespace duncan3dc\Exec\Output;

use function str_repeat;

final class Html implements OutputInterface
{
    /**
     * @inheritDoc
     */
    public function command(string $command, string $color): void
    {
        $style = $this->getStyle($color);
        echo "<b style='{$style}'>{$command}</b>";
    }


    /**
     * @inheritDoc
     */
    public function env(string $key, string $value, string $color): void
    {
        echo "<i>" . $this->tab() . "[{$key} = {$value}]</i>";
        $this->break("");
    }


    /**
     * @inheritDoc
     */
    public function output(string $line, string $color): void
    {
        $style = $this->getStyle($color);
        echo "<span style='{$style}'>" . $this->tab() . "{$line}</span>";
    }


    /**
     * @inheritDoc
     */
    public function break(string $color): void
    {
        echo "<br>";
    }


    /**
     * @inheritDoc
     */
    public function end(string $color): void
    {
        echo "<hr>";
    }


    /**
     * Get the css style rules for the specified colour.
     *
     * @param string $color The name of the colour to use
     *
     * @return string
     */
    private function getStyle(string $color): string
    {
        if (!$color) {
            return "";
        }

        return "color:{$color};";
    }


    private function tab(): string
    {
        return str_repeat("&nbsp;", 4);
    }
}
