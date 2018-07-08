<?php

namespace duncan3dc\ExecTests\Output;

use duncan3dc\Exec\Output\CLImate;
use Mockery;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;

class CLImateTest extends TestCase
{
    /**
     * @var CLImate $output The instance we are testing.
     */
    private $output;

    /**
     * @var \League\CLImate\CLImate|Mock $climate An upstream instance to test using.
     */
    private $climate;


    public function setUp()
    {
        $this->climate = Mockery::mock(\League\CLImate\CLImate::class);
        $this->output = new CLImate($this->climate);
    }


    public function tearDown()
    {
        Mockery::close();
    }


    public function testCommand()
    {
        $this->climate->shouldReceive("bold")->once()->with();
        $this->climate->shouldReceive("inline")->once()->with("ls");

        $this->output->command("ls", "");
        $this->assertTrue(true);
    }


    public function testCommandColor()
    {
        $this->climate->shouldReceive("bold")->once()->with();
        $this->climate->shouldReceive("orange")->once()->with("ls");

        $this->output->command("ls", "orange");
        $this->assertTrue(true);
    }


    public function testEnv()
    {
        $this->climate->shouldReceive("tab")->once()->with()->andReturn($this->climate);
        $this->climate->shouldReceive("out")->once()->with("[TEST = yep]");
        $this->output->env("TEST", "yep", "");
        $this->assertTrue(true);
    }


    public function testOutput()
    {
        $this->climate->shouldReceive("tab")->once()->with()->andReturn($this->climate);
        $this->climate->shouldReceive("inline")->once()->with("line1");
        $this->output->output("line1", "");
        $this->assertTrue(true);
    }


    public function testOutputColor()
    {
        $this->climate->shouldReceive("tab")->once()->with();
        $this->climate->shouldReceive("orange")->once()->with("line1");

        $this->output->output("line1", "orange");
        $this->assertTrue(true);
    }


    public function testBreak()
    {
        $this->climate->shouldReceive("br")->once()->with();

        $this->output->break("");
        $this->assertTrue(true);
    }


    public function testEnd()
    {
        $this->climate->shouldReceive("border")->once()->with();

        $this->output->end("");
        $this->assertTrue(true);
    }


    public function testEndColor()
    {
        $this->climate->shouldReceive("orange")->once()->with();
        $this->climate->shouldReceive("border")->once()->with();

        $this->output->end("orange");
        $this->assertTrue(true);
    }
}
