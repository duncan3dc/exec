<?php

namespace duncan3dc\ExecTests\Programs;

use duncan3dc\Exec\Exceptions\RubyGemException;
use duncan3dc\Exec\Output\OutputInterface;
use duncan3dc\Exec\Output\Silent;
use duncan3dc\Exec\ProgramInterface;
use duncan3dc\Exec\Programs\RubyGem;
use duncan3dc\Exec\ResultInterface;
use duncan3dc\ObjectIntruder\Intruder;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class RubyGemTest extends TestCase
{
    /**
     * @var RubyGem $gem The instance we are testing.
     */
    private $gem;

    /**
     * @var ProgramInterface|MockInterface $program An program instance to test with.
     */
    private $program;


    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        $output = Mockery::mock(OutputInterface::class);
        $this->gem = new RubyGem("super-gem", $output);

        $this->program = Mockery::mock(ProgramInterface::class);
        $gem = new Intruder($this->gem);
        $gem->program = $this->program;
    }


    /**
     * @inheritdoc
     */
    protected function tearDown(): void
    {
        Mockery::close();
    }


    public function testWithoutOutput(): void
    {
        $gem = RubyGem::withoutOutput("silent-gem");
        $gem = new Intruder($gem);
        $program = new Intruder($gem->program);
        $this->assertInstanceOf(Silent::class, $program->output);
    }


    public function testWithColor(): void
    {
        $this->program->shouldReceive("withColor")->with("green");

        $result = $this->gem->withColor("green");

        $this->assertInstanceOf(RubyGem::class, $result);
        $this->assertNotSame($this->gem, $result);
    }


    public function testWithPath(): void
    {
        $this->program->shouldReceive("withPath")->with("/tmp");

        $result = $this->gem->withPath("/tmp");

        $this->assertInstanceOf(RubyGem::class, $result);
        $this->assertNotSame($this->gem, $result);
    }


    public function testWithEnv(): void
    {
        $this->program->shouldReceive("withEnv")->with("cono", "HH");

        $result = $this->gem->withEnv("cono", "HH");

        $this->assertInstanceOf(RubyGem::class, $result);
        $this->assertNotSame($this->gem, $result);
    }


    public function testWithPrivateEnv(): void
    {
        $this->program->shouldReceive("withPrivateEnv")->with("cono", "HH");

        $result = $this->gem->withPrivateEnv("cono", "HH");

        $this->assertInstanceOf(RubyGem::class, $result);
        $this->assertNotSame($this->gem, $result);
    }


    public function testExec(): void
    {
        $this->program->shouldReceive("isInstalled")->with()->andReturn(true);

        $expected = Mockery::mock(ResultInterface::class);
        $expected->shouldReceive("getStatus")->with()->andReturn(0);
        $this->program->shouldReceive("getResult")->andReturn($expected);

        $result = $this->gem->exec();
        $this->assertSame($expected, $result);
    }


    public function testExecThrowsException(): void
    {
        $this->program->shouldReceive("isInstalled")->with()->andReturn(true);

        $result = Mockery::mock(ResultInterface::class);
        $result->shouldReceive("getStatus")->with()->andReturn(99);
        $this->program->shouldReceive("getResult")->andReturn($result);

        $this->expectException(RubyGemException::class);
        $this->expectExceptionMessage("The super-gem command failed");
        $this->gem->exec();
    }


    public function testExecChecksInstalled(): void
    {
        $this->program->shouldReceive("isInstalled")->with()->andReturn(false);

        $this->expectException(RubyGemException::class);
        $this->expectExceptionMessage("This ruby gem does not appear to be installed: super-gem");
        $this->gem->exec();
    }


    public function testIsInstalled(): void
    {
        $this->program->shouldReceive("isInstalled")->with()->andReturn(true);

        $result = $this->gem->isInstalled();

        $this->assertSame(true, $result);
    }
}
