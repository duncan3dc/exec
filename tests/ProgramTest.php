<?php

namespace duncan3dc\ExecTests;

use duncan3dc\Exec\Exceptions\ProgramException;
use duncan3dc\Exec\Program;
use duncan3dc\Mock\CoreFunction;
use PHPUnit\Framework\TestCase;

class ProgramTest extends TestCase
{
    /**
     * @var Program $program The instance we are testing.
     */
    private $program;


    public function setUp()
    {
        $this->program = new Program("ls");
    }


    public function tearDown()
    {
        CoreFunction::close();
    }


    private function mock($result): \Mockery\Matcher\Closure
    {
        return \Mockery::on(function (&$param) use ($result) {
            $param = $result;
            return true;
        });
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
        CoreFunction::mock("exec")
            ->with("ls {$expected} 2>&1", $this->mock([]), $this->mock(0));

        $this->program->exec(...$args);

        # All the tests are handled by the mocked expectations above
        $this->assertTrue(true);
    }


    public function testExecReturnsOutput()
    {
        CoreFunction::mock("exec")
            ->with("ls 2>&1", $this->mock(["line1", "line2"]), $this->mock(0));

        $result = $this->program->exec()->getLines();
        $this->assertSame(["line1", "line2"], $result);
    }


    public function testExecThrowsException()
    {
        CoreFunction::mock("exec")
            ->with("ls 2>&1", $this->mock([]), $this->mock(14));

        $this->expectException(ProgramException::class);
        $this->expectExceptionMessage("The ls command failed (exit code: 14)");
        $this->program->exec();
    }
}
