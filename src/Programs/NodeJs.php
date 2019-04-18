<?php

namespace duncan3dc\Exec\Programs;

use duncan3dc\Exec\Exceptions\NodeJsException;
use duncan3dc\Exec\Output\OutputInterface;
use duncan3dc\Exec\Output\Silent;
use duncan3dc\Exec\Program;
use duncan3dc\Exec\ProgramInterface;
use duncan3dc\Exec\ResultInterface;

final class NodeJs implements ProgramInterface
{
    /**
     * @var ProgramInterface $program The program instance to run our commands.
     */
    private $program;

    /**
     * @var string $module The name of the npm module to run.
     */
    private $module;


    /**
     * Create a new instance that doesn't output anything.
     *
     * @param string $module The name of the npm module to run
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
     * @param string $module The name of the npm module to run
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
        $node = clone $this;
        $node->program = $this->program->withColor($color);
        return $node;
    }


    /**
     * @inheritDoc
     */
    public function withPath(string $path): ProgramInterface
    {
        $node = clone $this;
        $node->program = $this->program->withPath($path);
        return $node;
    }


    /**
     * @inheritDoc
     */
    public function withEnv(string $key, string $value): ProgramInterface
    {
        $node = clone $this;
        $node->program = $this->program->withEnv($key, $value);
        return $node;
    }


    /**
     * @inheritDoc
     */
    public function withPrivateEnv(string $key, string $value): ProgramInterface
    {
        $node = clone $this;
        $node->program = $this->program->withPrivateEnv($key, $value);
        return $node;
    }


    /**
     * @inheritDoc
     */
    public function getResult(string ...$arguments): ResultInterface
    {
        if (!$this->isInstalled()) {
            throw new NodeJsException("This npm module does not appear to be installed: {$this->module}");
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
            throw new NodeJsException("The {$this->module} command failed", $status);
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
