<?php

namespace duncan3dc\ExecTests;

use duncan3dc\Exec\Factory;
use duncan3dc\Exec\Output\OutputInterface;
use duncan3dc\Exec\Program;
use duncan3dc\Exec\ProgramInterface;
use duncan3dc\ExecTests\Programs\Example;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    /**
     * @var ProgramInterface|MockInterface $program A program instance to test with.
     */
    private $program;


    public function setUp()
    {
        $this->program = Mockery::mock(ProgramInterface::class);
    }


    public function tearDown()
    {
        Mockery::close();
    }


    public function testConstructor()
    {
        $output = Mockery::mock(OutputInterface::class);
        $factory = new Factory($output);

        /** @var Example $program */
        $program = $factory->make("ls", Example::class);

        $this->assertInstanceOf(Example::class, $program);
        $this->assertSame("ls", $program->getProgram());
        $this->assertSame($output, $program->getOutput());
        $this->assertSame("default", $program->getColor());
        $this->assertSame("default", $program->getPath());
        $this->assertSame([], $program->getEnv());
    }


    public function testWithColor()
    {
        $output = Mockery::mock(OutputInterface::class);
        $factory = new Factory($output);
        $factory = $factory->withColor("orange");

        /** @var Example $program */
        $program = $factory->make("ls", Example::class);

        $this->assertInstanceOf(Example::class, $program);
        $this->assertSame("ls", $program->getProgram());
        $this->assertSame($output, $program->getOutput());
        $this->assertSame("orange", $program->getColor());
        $this->assertSame("default", $program->getPath());
        $this->assertSame([], $program->getEnv());
    }


    public function testWithPath()
    {
        $output = Mockery::mock(OutputInterface::class);
        $factory = new Factory($output);
        $factory = $factory->withPath("/tmp/stash");

        /** @var Example $program */
        $program = $factory->make("ls", Example::class);

        $this->assertInstanceOf(Example::class, $program);
        $this->assertSame("ls", $program->getProgram());
        $this->assertSame($output, $program->getOutput());
        $this->assertSame("default", $program->getColor());
        $this->assertSame("/tmp/stash", $program->getPath());
        $this->assertSame([], $program->getEnv());
    }


    public function testWithEnv()
    {
        $output = Mockery::mock(OutputInterface::class);
        $factory = new Factory($output);
        $factory = $factory->withEnv("one", "1")->withEnv("two", "2");

        /** @var Example $program */
        $program = $factory->make("ls", Example::class);

        $this->assertInstanceOf(Example::class, $program);
        $this->assertSame("ls", $program->getProgram());
        $this->assertSame($output, $program->getOutput());
        $this->assertSame("default", $program->getColor());
        $this->assertSame("default", $program->getPath());
        $this->assertSame(["one" => "1", "two" => "2"], $program->getEnv());
    }


    public function testMake()
    {
        $output = Mockery::mock(OutputInterface::class);
        $factory = new Factory($output);

        $program = $factory->make("pstorm");

        $this->assertInstanceOf(Program::class, $program);
    }


    public function testMakeInvalid()
    {
        $output = Mockery::mock(OutputInterface::class);
        $factory = new Factory($output);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Custom class passed to duncan3dc\Exec\Factory::make() must implement duncan3dc\Exec\ProgramInterface");
        $factory->make("spl", "SplDoublyLinkedList");
    }
}