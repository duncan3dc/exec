<?php

namespace duncan3dc\Exec\Output;

use Symfony\Component\Console\Output\OutputInterface as SymfonyInterface;

final class Symfony implements OutputInterface
{
    /**
     * @var SymfonyInterface $output The Symfony instance we are wrapping.
     */
    private $output;

    /**
     * Create a new instance.
     *
     * @param SymfonyInterface $output The Symfony instance to wrap
     */
    public function __construct(SymfonyInterface $output)
    {
        $this->output = $output;
    }


    /**
     * @inheritDoc
     */
    public function command(string $command, string $color): void
    {
        if ($this->output->getVerbosity() < SymfonyInterface::VERBOSITY_VERY_VERBOSE) {
            return;
        }

        $format = $this->getFormat($color, "bold");
        $this->output->write("<{$format}>{$command}</>");
    }


    /**
     * @inheritDoc
     */
    public function env(string $key, string $value, string $color): void
    {
        if ($this->output->getVerbosity() < SymfonyInterface::VERBOSITY_DEBUG) {
            return;
        }

        $this->output->writeln("\t[{$key} = {$value}]");
    }


    /**
     * @inheritDoc
     */
    public function output(string $line, string $color): void
    {
        if ($this->output->getVerbosity() < SymfonyInterface::VERBOSITY_DEBUG) {
            return;
        }

        $format = $this->getFormat($color);
        $this->output->write("<{$format}>\t{$line}</>");
    }


    /**
     * @inheritDoc
     */
    public function break(string $color): void
    {
        if ($this->output->getVerbosity() < SymfonyInterface::VERBOSITY_DEBUG) {
            return;
        }

        $this->output->writeln("");
    }


    /**
     * @inheritDoc
     */
    public function end(string $color): void
    {
        if ($this->output->getVerbosity() < SymfonyInterface::VERBOSITY_VERY_VERBOSE) {
            return;
        }

        $format = $this->getFormat($color, "bold");
        $this->output->writeln("");
        $this->output->writeln("<{$format}>" . (new Line) . "</>");
    }


    private function getFormat(string $color, string $options = ""): string
    {
        $format = "";

        if ($color) {
            $format .= "fg={$color};";
        }

        if ($options) {
            $format .= "options={$options};";
        }

        return $format;
    }
}
