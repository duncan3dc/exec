<?php

namespace duncan3dc\ExecTests\Output;

use duncan3dc\Exec\Output\Silent;
use PHPUnit\Framework\TestCase;

class SilentTest extends TestCase
{
    /**
     * @var Silent The instance we are testing.
     */
    private $output;


    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        $this->output = new Silent();
    }


    public function testCommand(): void
    {
        $this->expectOutputString("");
        $this->output->command("ls", "blue");
    }


    public function testEnv(): void
    {
        $this->expectOutputString("");
        $this->output->env("TEST", "yep", "blue");
    }


    public function testOutput(): void
    {
        $this->expectOutputString("");
        $this->output->output("line1", "blue");
    }


    public function testBreak(): void
    {
        $this->expectOutputString("");
        $this->output->break("");
    }


    public function testEnd(): void
    {
        $this->expectOutputString("");
        $this->output->end("");
    }
}
