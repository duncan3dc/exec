<?php

namespace duncan3dc\Exec\Programs;

use duncan3dc\Exec\Exceptions\ComposerException;
use duncan3dc\Exec\Output\OutputInterface;
use duncan3dc\Exec\Output\Silent;
use duncan3dc\Exec\Program;
use duncan3dc\Exec\ProgramInterface;
use duncan3dc\Exec\ResultInterface;

use function array_unshift;

final class Composer implements ProgramInterface
{
    /**
     * @var ProgramInterface $program The program instance to run our commands.
     */
    private $program;


    /**
     * Create a new instance that doesn't output anything.
     *
     * @return self
     */
    public static function withoutOutput(): self
    {
        return new self(new Silent());
    }


    /**
     * Create a new instance.
     *
     * @param OutputInterface $output The output instance to log to
     */
    public function __construct(OutputInterface $output)
    {
        $program = new Program("composer", $output);
        $this->program = $program->withColor("cyan");
    }


    /**
     * @inheritDoc
     */
    public function withColor(string $color): ProgramInterface
    {
        $composer = clone $this;
        $composer->program = $this->program->withColor($color);
        return $composer;
    }


    /**
     * @inheritDoc
     */
    public function withPath(string $path): ProgramInterface
    {
        $composer = clone $this;
        $composer->program = $this->program->withPath($path);
        return $composer;
    }


    /**
     * @inheritDoc
     */
    public function withEnv(string $key, string $value): ProgramInterface
    {
        $composer = clone $this;
        $composer->program = $this->program->withEnv($key, $value);
        return $composer;
    }


    /**
     * @inheritDoc
     */
    public function getResult(string ...$arguments): ResultInterface
    {
        array_unshift($arguments, "--no-interaction");

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
            throw new ComposerException("The composer command failed", $status);
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


    /**
     * Issue an update with sensible production defaults.
     *
     * @return ResultInterface
     * @throws ComposerException
     */
    public function update(): ResultInterface
    {
        return $this->exec("update", "--no-dev", "--prefer-dist", "--classmap-authoritative");
    }
}
