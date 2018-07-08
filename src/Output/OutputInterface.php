<?php

namespace duncan3dc\Exec\Output;

interface OutputInterface
{
    /**
     * Output a command that is being run.
     *
     * @param string $command The command to output
     * @param string $color The name of the colour to output the command in
     *
     * @return void
     */
    public function command(string $command, string $color): void;

    /**
     * Output a line of the command's output.
     *
     * @param string $line The line to output
     * @param string $color The name of the colour to output the line in
     *
     * @return void
     */
    public function output(string $line, string $color): void;

    /**
     * Output a line break.
     *
     * @param string $color The name of the colour to output the break in
     *
     * @return void
     */
    public function break(string $color): void;

    /**
     * Output a marker to indicate the end the command's output.
     *
     * @param string $color The name of the colour to output the marker in
     *
     * @return void
     */
    public function end(string $color): void;
}
