<?php

namespace duncan3dc\ExecTests\Programs;

use duncan3dc\Exec\Exceptions\ComposerException;
use duncan3dc\Exec\Output\OutputInterface;
use duncan3dc\Exec\Output\Silent;
use duncan3dc\Exec\ProgramInterface;
use duncan3dc\Exec\Programs\Composer;
use duncan3dc\Exec\ResultInterface;
use duncan3dc\ObjectIntruder\Intruder;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class ComposerTest extends TestCase
{
    /**
     * @var Composer $composer The instance we are testing.
     */
    private $composer;

    /**
     * @var ProgramInterface|MockInterface $program An program instance to test with.
     */
    private $program;

    public function setUp()
    {
        $output = Mockery::mock(OutputInterface::class);
        $this->composer = new Composer($output);

        $this->program = Mockery::mock(ProgramInterface::class);
        $composer = new Intruder($this->composer);
        $composer->program = $this->program;
    }


    public function tearDown()
    {
        Mockery::close();
    }


    public function testWithoutOutput(): void
    {
        $composer = Composer::withoutOutput();
        $composer = new Intruder($composer);
        $program = new Intruder($composer->program);
        $this->assertInstanceOf(Silent::class, $program->output);
    }


    public function testWithColor()
    {
        $this->program->shouldReceive("withColor")->with("green");

        $result = $this->composer->withColor("green");

        $this->assertInstanceOf(Composer::class, $result);
        $this->assertNotSame($this->composer, $result);
    }


    public function testWithPath()
    {
        $this->program->shouldReceive("withPath")->with("/tmp");

        $result = $this->composer->withPath("/tmp");

        $this->assertInstanceOf(Composer::class, $result);
        $this->assertNotSame($this->composer, $result);
    }


    public function testWithEnv()
    {
        $this->program->shouldReceive("withEnv")->with("cono", "RP");

        $result = $this->composer->withEnv("cono", "RP");

        $this->assertInstanceOf(Composer::class, $result);
        $this->assertNotSame($this->composer, $result);
    }


    public function testExecUsesNoInteraction()
    {
        $expected = Mockery::mock(ResultInterface::class);
        $expected->shouldReceive("getStatus")->with()->andReturn(0);
        $this->program->shouldReceive("getResult")->with("--no-interaction", "install")->andReturn($expected);

        $result = $this->composer->exec("install");

        $this->assertSame($expected, $result);
    }


    public function testExecThrowsException()
    {
        $result = Mockery::mock(ResultInterface::class);
        $result->shouldReceive("getStatus")->with()->andReturn(99);
        $this->program->shouldReceive("getResult")->andReturn($result);

        $this->expectException(ComposerException::class);
        $this->expectExceptionMessage("The composer command failed");
        $this->composer->exec();
    }


    public function testIsInstalled()
    {
        $this->program->shouldReceive("isInstalled")->with()->andReturn(true);

        $result = $this->composer->isInstalled();

        $this->assertSame(true, $result);
    }


    public function testUpdate()
    {
        $expected = Mockery::mock(ResultInterface::class);
        $expected->shouldReceive("getStatus")->with()->andReturn(0);

        $arguments = [
            "--no-interaction",
            "update",
            "--no-dev",
            "--prefer-dist",
            "--classmap-authoritative",
        ];
        $this->program->shouldReceive("getResult")->once()->with(...$arguments)->andReturn($expected);

        $result = $this->composer->update();

        $this->assertSame($expected, $result);
    }
}
