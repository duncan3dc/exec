<?php

namespace duncan3dc\Exec\Output;

use League\CLImate\CLImate as CLImateInterface;

final class CLImate implements OutputInterface
{
    /** @var CLImateInterface */
    private $climate;


    /**
     * Create a new instance.
     *
     * @param CLImateInterface $climate The CLImate instance to wrap
     */
    public function __construct(CLImateInterface $climate)
    {
        $this->climate = $climate;
    }


    /**
     * @inheritdoc
     */
    public function command(string $command, string $color): void
    {
        $method = $this->getMethod($color);
        $this->climate->bold();
        $this->climate->$method($command);
    }


    /**
     * @inheritdoc
     */
    public function env(string $key, string $value, string $color): void
    {
        $this->climate->tab()->out("[{$key} = {$value}]");
    }


    /**
     * @inheritdoc
     */
    public function output(string $line, string $color): void
    {
        $method = $this->getMethod($color);
        $this->climate->tab();
        $this->climate->$method($line);
    }


    /**
     * @inheritdoc
     */
    public function break(string $color): void
    {
        $this->climate->br();
    }


    /**
     * @inheritdoc
     */
    public function end(string $color): void
    {
        if ($color) {
            $this->climate->$color();
        }
        $this->climate->border();
    }


    /**
     * Get the CLImate method name to call for the specified colour.
     *
     * @param string $color The colour to get the method for
     *
     * @return string
     */
    private function getMethod(string $color): string
    {
        if (!$color) {
            return "inline";
        }

        return $color;
    }
}
