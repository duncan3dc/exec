<?php

namespace duncan3dc\ExecTests\Programs;

use duncan3dc\Exec\Exceptions\NodeJsException;
use duncan3dc\Exec\Output\OutputInterface;
use duncan3dc\Exec\Output\Silent;
use duncan3dc\Exec\ProgramInterface;
use duncan3dc\Exec\Programs\NodeJs;
use duncan3dc\Exec\ResultInterface;
use duncan3dc\ExecTests\Handlers;
use duncan3dc\ObjectIntruder\Intruder;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class NodeJsTest extends TestCase
{
    /**
     * @var NodeJs $node The instance we are testing.
     */
    private $node;

    /**
     * @var ProgramInterface|MockInterface $program An program instance to test with.
     */
    private $program;


    public function setUp()
    {
        $output = Mockery::mock(OutputInterface::class);
        $this->node = new NodeJs("super-module", $output);

        $this->program = Mockery::mock(ProgramInterface::class);
        $node = new Intruder($this->node);
        $node->program = $this->program;
    }


    public function tearDown()
    {
        Mockery::close();
    }


    public function testWithoutOutput(): void
    {
        $node = NodeJs::withoutOutput("silent-module");
        $node = new Intruder($node);
        $program = new Intruder($node->program);
        $this->assertInstanceOf(Silent::class, $program->output);
    }


    public function testWithColor()
    {
        $this->program->shouldReceive("withColor")->with("green");

        $result = $this->node->withColor("green");

        $this->assertInstanceOf(NodeJs::class, $result);
        $this->assertNotSame($this->node, $result);
    }


    public function testWithPath()
    {
        $this->program->shouldReceive("withPath")->with("/tmp");

        $result = $this->node->withPath("/tmp");

        $this->assertInstanceOf(NodeJs::class, $result);
        $this->assertNotSame($this->node, $result);
    }


    public function testWithEnv()
    {
        $this->program->shouldReceive("withEnv")->with("cono", "CH");

        $result = $this->node->withEnv("cono", "CH");

        $this->assertInstanceOf(NodeJs::class, $result);
        $this->assertNotSame($this->node, $result);
    }


    public function testExec()
    {
        $this->program->shouldReceive("isInstalled")->with()->andReturn(true);

        $expected = Mockery::mock(ResultInterface::class);
        $expected->shouldReceive("getStatus")->with()->andReturn(0);
        $this->program->shouldReceive("getResult")->andReturn($expected);

        $result = $this->node->exec();
        $this->assertSame($expected, $result);
    }


    public function testExecThrowsException()
    {
        $this->program->shouldReceive("isInstalled")->with()->andReturn(true);

        $result = Mockery::mock(ResultInterface::class);
        $result->shouldReceive("getStatus")->with()->andReturn(99);
        $this->program->shouldReceive("getResult")->andReturn($result);

        $this->expectException(NodeJsException::class);
        $this->expectExceptionMessage("The super-module command failed");
        $this->node->exec("arg1", "arg2");
    }


    public function testExecChecksInstalled()
    {
        $this->program->shouldReceive("isInstalled")->with()->andReturn(false);

        $this->expectException(NodeJsException::class);
        $this->expectExceptionMessage("This npm module does not appear to be installed: super-module");
        $this->node->exec();
    }


    public function testIsInstalled()
    {
        $this->program->shouldReceive("isInstalled")->with()->andReturn(true);

        $result = $this->node->isInstalled();

        $this->assertSame(true, $result);
    }
}
