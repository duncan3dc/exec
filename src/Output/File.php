<?php

namespace duncan3dc\Exec\Output;

final class File implements OutputInterface
{
    /**
     * @var \SplFileObject The file to write to.
     */
    private $file;

    /**
     * Create a new instance.
     *
     * @param \SplFileObject $file The file to write to
     */
    public function __construct(\SplFileObject $file)
    {
        $this->file = $file;
    }


    /**
     * @inheritDoc
     */
    public function command(string $command, string $color): void
    {
        $this->file->fwrite($command);
    }


    /**
     * @inheritDoc
     */
    public function env(string $key, string $value, string $color): void
    {
        $this->file->fwrite("\t[{$key} = {$value}]\n");
    }


    /**
     * @inheritDoc
     */
    public function output(string $line, string $color): void
    {
        $this->file->fwrite("\t{$line}");
    }


    /**
     * @inheritDoc
     */
    public function break(string $color): void
    {
        $this->file->fwrite("\n");
    }


    /**
     * @inheritDoc
     */
    public function end(string $color): void
    {
        $this->break("");
        $this->file->fwrite(new Line);
        $this->break("");
    }
}
