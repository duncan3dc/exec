<?php

namespace duncan3dc\ExecTests\Output;

use duncan3dc\Exec\Output\Html;
use PHPUnit\Framework\TestCase;

class HtmlTest extends TestCase
{
    /**
     * @var Html $output The instance we are testing.
     */
    private $output;


    public function setUp()
    {
        $this->output = new Html();
    }


    public function testCommand()
    {
        $this->expectOutputString("<b style=''>ls</b>");
        $this->output->command("ls", "");
    }

    public function testCommandColor()
    {
        $this->expectOutputString("<b style='color:purple;'>ls</b>");
        $this->output->command("ls", "purple");
    }


    public function testEnv()
    {
        $this->expectOutputString("<i>&nbsp;&nbsp;&nbsp;&nbsp;[TEST = yep]</i><br>");
        $this->output->env("TEST", "yep", "blue");
    }


    public function testOutput()
    {
        $this->expectOutputString("<span style=''>&nbsp;&nbsp;&nbsp;&nbsp;line1</span>");
        $this->output->output("line1", "");
    }

    public function testOutputColor()
    {
        $this->expectOutputString("<span style='color:blue;'>&nbsp;&nbsp;&nbsp;&nbsp;line1</span>");
        $this->output->output("line1", "blue");
    }


    public function testBreak()
    {
        $this->expectOutputString("<br>");
        $this->output->break("");
    }


    public function testEnd()
    {
        $this->expectOutputString("<hr>");
        $this->output->end("");
    }
}
