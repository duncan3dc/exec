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


    public function setUp()
    {
        $this->output = new Silent;
    }


    public function testCommand()
    {
        $this->expectOutputString("");
        $this->output->command("ls", "blue");
    }


    public function testEnv()
    {
        $this->expectOutputString("");
        $this->output->env("TEST", "yep", "blue");
    }


    public function testOutput()
    {
        $this->expectOutputString("");
        $this->output->output("line1", "blue");
    }


    public function testBreak()
    {
        $this->expectOutputString("");
        $this->output->break("");
    }


    public function testEnd()
    {
        $this->expectOutputString("");
        $this->output->end("");
    }
}
