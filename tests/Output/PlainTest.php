<?php

namespace duncan3dc\ExecTests\Output;

use duncan3dc\Exec\Output\Plain;
use PHPUnit\Framework\TestCase;

class PlainTest extends TestCase
{
    /**
     * @var Plain $output The instance we are testing.
     */
    private $output;


    public function setUp()
    {
        $this->output = new Plain();
    }


    public function testCommand()
    {
        $this->expectOutputString("ls");
        $this->output->command("ls", "blue");
    }


    public function testEnv()
    {
        $this->expectOutputString("\t[TEST = yep]\n");
        $this->output->env("TEST", "yep", "blue");
    }


    public function testOutput()
    {
        $this->expectOutputString("\tline1");
        $this->output->output("line1", "blue");
    }


    public function testBreak()
    {
        $this->expectOutputString("\n");
        $this->output->break("");
    }


    public function testEnd()
    {
        $this->expectOutputRegex("/^\n-+\n$/");
        $this->output->end("");
    }
}
