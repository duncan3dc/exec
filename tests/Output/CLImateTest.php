<?php

namespace duncan3dc\ExecTests\Output;

use duncan3dc\Exec\Output\CLImate;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class CLImateTest extends TestCase
{
    /** @var CLImate */
    private $output;

    /** @var \League\CLImate\CLImate|MockInterface */
    private $climate;


    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        $this->climate = Mockery::mock(\League\CLImate\CLImate::class);
        $this->output = new CLImate($this->climate);
    }


    /**
     * @inheritdoc
     */
    protected function tearDown(): void
    {
        Mockery::close();
    }


    public function testCommand(): void
    {
        $this->climate->shouldReceive("bold")->once()->with();
        $this->climate->shouldReceive("inline")->once()->with("ls");

        $this->output->command("ls", "");
        $this->assertTrue(true);
    }


    public function testCommandColor(): void
    {
        $this->climate->shouldReceive("bold")->once()->with();
        $this->climate->shouldReceive("orange")->once()->with("ls");

        $this->output->command("ls", "orange");
        $this->assertTrue(true);
    }


    public function testEnv(): void
    {
        $this->climate->shouldReceive("tab")->once()->with()->andReturn($this->climate);
        $this->climate->shouldReceive("out")->once()->with("[TEST = yep]");
        $this->output->env("TEST", "yep", "");
        $this->assertTrue(true);
    }


    public function testOutput(): void
    {
        $this->climate->shouldReceive("tab")->once()->with()->andReturn($this->climate);
        $this->climate->shouldReceive("inline")->once()->with("line1");
        $this->output->output("line1", "");
        $this->assertTrue(true);
    }


    public function testOutputColor(): void
    {
        $this->climate->shouldReceive("tab")->once()->with();
        $this->climate->shouldReceive("orange")->once()->with("line1");

        $this->output->output("line1", "orange");
        $this->assertTrue(true);
    }


    public function testBreak(): void
    {
        $this->climate->shouldReceive("br")->once()->with();

        $this->output->break("");
        $this->assertTrue(true);
    }


    public function testEnd(): void
    {
        $this->climate->shouldReceive("border")->once()->with();

        $this->output->end("");
        $this->assertTrue(true);
    }


    public function testEndColor(): void
    {
        $this->climate->shouldReceive("orange")->once()->with();
        $this->climate->shouldReceive("border")->once()->with();

        $this->output->end("orange");
        $this->assertTrue(true);
    }
}
