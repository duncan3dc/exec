<?php

namespace duncan3dc\Exec\Output;

final class CLImate implements OutputInterface
{
    /**
     * @var \League\CLImate\CLImate $climate The CLImate instance we are wrapping.
     */
    private $climate;

    /**
     * Create a new instance.
     *
     * @param \League\CLImate\CLImate $climate The CLImate instance to wrap
     */
    public function __construct(\League\CLImate\CLImate $climate)
    {
        $this->climate = $climate;
    }


    /**
     * @inheritDoc
     */
    public function command(string $command, string $color): void
    {
        $method = $this->getMethod($color);
        $this->climate->bold();
        $this->climate->$method($command);
    }


    /**
     * @inheritDoc
     */
    public function env(string $key, string $value, string $color): void
    {
        $this->climate->tab()->out("[{$key} = {$value}]");
    }


    /**
     * @inheritDoc
     */
    public function output(string $line, string $color): void
    {
        $method = $this->getMethod($color);
        $this->climate->tab();
        $this->climate->$method($line);
    }


    /**
     * @inheritDoc
     */
    public function break(string $color): void
    {
        $this->climate->br();
    }


    /**
     * @inheritDoc
     */
    public function end(string $color): void
    {
        if ($color) {
            $this->climate->$color();
        }
        $this->climate->border();
    }


    /**
     * Get the CLImate method name to call for the specified colour
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
