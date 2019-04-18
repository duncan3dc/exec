<?php

namespace duncan3dc\Exec\Programs;

use duncan3dc\Exec\Exceptions\RubyGemException;
use duncan3dc\Exec\Output\OutputInterface;
use duncan3dc\Exec\Output\Silent;
use duncan3dc\Exec\Program;
use duncan3dc\Exec\ProgramInterface;
use duncan3dc\Exec\ResultInterface;

final class RubyGem implements ProgramInterface
{
    /**
     * @var ProgramInterface $program The program instance to run our commands.
     */
    private $program;

    /**
     * @var string $module The name of the gem to run.
     */
    private $module;


    /**
     * Create a new instance that doesn't output anything.
     *
     * @param string $module The name of the gem to run
     *
     * @return self
     */
    public static function withoutOutput(string $module): self
    {
        return new self($module, new Silent());
    }


    /**
     * Create a new instance.
     *
     * @param string $module The name of the gem to run
     * @param OutputInterface $output The output instance to log to
     */
    public function __construct($module, OutputInterface $output)
    {
        $this->program = new Program($module, $output);

        $this->module = $module;
    }


    /**
     * @inheritDoc
     */
    public function withColor(string $color): ProgramInterface
    {
        $gem = clone $this;
        $gem->program = $this->program->withColor($color);
        return $gem;
    }


    /**
     * @inheritDoc
     */
    public function withPath(string $path): ProgramInterface
    {
        $gem = clone $this;
        $gem->program = $this->program->withPath($path);
        return $gem;
    }


    /**
     * @inheritDoc
     */
    public function withEnv(string $key, string $value): ProgramInterface
    {
        $gem = clone $this;
        $gem->program = $this->program->withEnv($key, $value);
        return $gem;
    }


    /**
     * @inheritDoc
     */
    public function withPrivateEnv(string $key, string $value): ProgramInterface
    {
        $gem = clone $this;
        $gem->program = $this->program->withPrivateEnv($key, $value);
        return $gem;
    }


    /**
     * @inheritDoc
     */
    public function getResult(string ...$arguments): ResultInterface
    {
        if (!$this->isInstalled()) {
            throw new RubyGemException("This ruby gem does not appear to be installed: {$this->module}");
        }

        return $this->program->getResult(...$arguments);
    }


    /**
     * @inheritDoc
     */
    public function exec(string ...$arguments): ResultInterface
    {
        $result = $this->getResult(...$arguments);

        $status = $result->getStatus();
        if ($status > 0) {
            throw new RubyGemException("The {$this->module} command failed", $status);
        }

        return $result;
    }


    /**
     * Check if the program is installed.
     *
     * @return bool
     */
    public function isInstalled(): bool
    {
        return $this->program->isInstalled();
    }
}
