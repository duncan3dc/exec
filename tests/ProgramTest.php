<?php

namespace duncan3dc\ExecTests;

use duncan3dc\Exec\Exceptions\ProgramException;
use duncan3dc\Exec\Output\OutputInterface;
use duncan3dc\Exec\Program;
use duncan3dc\Mock\CoreFunction;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class ProgramTest extends TestCase
{
    /**
     * @var Program $program The instance we are testing.
     */
    private $program;

    /**
     * @var OutputInterface|MockInterface $output An output instance to test with.
     */
    private $output;

    public function setUp()
    {
        $this->output = Mockery::mock(OutputInterface::class);
        $this->program = new Program("ls", $this->output);
    }


    public function tearDown()
    {
        CoreFunction::close();
        Mockery::close();
    }


    private function mock($result): \Mockery\Matcher\Closure
    {
        return \Mockery::on(function (&$param) use ($result) {
            $param = $result;
            return true;
        });
    }


    public function ignoreOutput(): void
    {
        $this->output->shouldReceive("command");
        $this->output->shouldReceive("break");
        $this->output->shouldReceive("output");
        $this->output->shouldReceive("end");
    }


    private function setupDefaultMock()
    {
        CoreFunction::mock("exec")
            ->with("ls 2>&1", $this->mock(["line1"]), $this->mock(0));
    }


    public function testDefaultOutputLevels1()
    {
        $this->setupDefaultMock();

        $this->output->shouldReceive("command")->once()->with("ls", "blue");
        $this->output->shouldReceive("break")->once()->with("blue");
        $this->output->shouldReceive("output")->once()->with("line1", "blue");
        $this->output->shouldReceive("end")->once()->with("blue");

        $result = $this->program->exec();
        $this->assertSame(["line1"], $result->getLines());
    }


    public function testWithColor()
    {
        $this->setupDefaultMock();

        $this->output->shouldReceive("command")->once()->with("ls", "orange");
        $this->output->shouldReceive("break")->once()->with("orange");
        $this->output->shouldReceive("output")->once()->with("line1", "orange");
        $this->output->shouldReceive("end")->once()->with("orange");

        $program = $this->program->withColor("orange");
        $this->assertNotSame($this->program, $program);
        $program->exec();
    }


    public function argumentProvider()
    {
        $arguments = [
            "'just one arg'" => ["just one arg"],
            "'\$test'" => ["\$test"],
        ];
        foreach ($arguments as $expected => $args) {
            yield [$expected, $args];
        }
    }
    /**
     * @dataProvider argumentProvider
     */
    public function testArguments($expected, array $args)
    {
        $this->ignoreOutput();

        CoreFunction::mock("exec")
            ->with("ls {$expected} 2>&1", $this->mock([]), $this->mock(0));

        $this->program->exec(...$args);

        # All the tests are handled by the mocked expectations above
        $this->assertTrue(true);
    }


    public function testExecReturnsOutput()
    {
        $this->ignoreOutput();

        CoreFunction::mock("exec")
            ->with("ls 2>&1", $this->mock(["line1", "line2"]), $this->mock(0));

        $result = $this->program->exec()->getLines();
        $this->assertSame(["line1", "line2"], $result);
    }


    public function testExecThrowsException()
    {
        $this->ignoreOutput();

        CoreFunction::mock("exec")
            ->with("ls 2>&1", $this->mock([]), $this->mock(14));

        $this->expectException(ProgramException::class);
        $this->expectExceptionMessage("The ls command failed (exit code: 14)");
        $this->program->exec();
    }
}
