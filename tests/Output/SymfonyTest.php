<?php

namespace duncan3dc\ExecTests\Output;

use duncan3dc\Exec\Output\Symfony;
use Mockery;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\OutputInterface;
use Mockery\MockInterface;

class SymfonyTest extends TestCase
{
    /** @var Symfony */
    private $symfony;

    /** @var OutputInterface|MockInterface */
    private $output;


    /**
     * @inheritdoc
     */
    protected function tearDown(): void
    {
        Mockery::close();
    }


    private function setOutputVerbosity($verbosity): void
    {
        $this->output = Mockery::mock(OutputInterface::class);
        $this->output->shouldReceive("getVerbosity")->andReturn($verbosity);

        $this->symfony = new Symfony($this->output);
    }


    public function testCommandNormal(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_NORMAL);
        $this->symfony->command("ls", "");
        $this->assertTrue(true);
    }


    public function testCommandVerbose(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_VERBOSE);
        $this->symfony->command("ls", "");
        $this->assertTrue(true);
    }


    public function testCommandVeryVerbose(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_VERY_VERBOSE);
        $this->output->shouldReceive("write")->once()->with("<options=bold;>ls</>");
        $this->symfony->command("ls", "");
        $this->assertTrue(true);
    }


    public function testCommandDebug(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_DEBUG);
        $this->output->shouldReceive("write")->once()->with("<options=bold;>ls</>");
        $this->symfony->command("ls", "");
        $this->assertTrue(true);
    }


    public function testCommandQuiet(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_QUIET);
        $this->symfony->command("ls", "");
        $this->assertTrue(true);
    }


    public function testCommandColor(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_DEBUG);

        $this->output->shouldReceive("write")->once()->with("<fg=orange;options=bold;>ls</>");

        $this->symfony->command("ls", "orange");
        $this->assertTrue(true);
    }


    public function testEnvNormal(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_NORMAL);
        $this->symfony->env("TEST", "yep", "");
        $this->assertTrue(true);
    }


    public function testEnvVerbose(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_VERBOSE);
        $this->symfony->env("TEST", "yep", "");
        $this->assertTrue(true);
    }


    public function testEnvVeryVerbose(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_VERY_VERBOSE);
        $this->symfony->env("TEST", "yep", "");
        $this->assertTrue(true);
    }


    public function testEnvDebug(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_DEBUG);
        $this->output->shouldReceive("writeln")->once()->with("\t[TEST = yep]");
        $this->symfony->env("TEST", "yep", "");
        $this->assertTrue(true);
    }


    public function testEnvQuiet(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_QUIET);
        $this->symfony->env("TEST", "yep", "");
        $this->assertTrue(true);
    }


    public function testOutputNormal(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_NORMAL);
        $this->symfony->output("line1", "");
        $this->assertTrue(true);
    }


    public function testOutputVerbose(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_VERBOSE);
        $this->symfony->output("line2", "");
        $this->assertTrue(true);
    }


    public function testOutputVeryVerbose(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_VERY_VERBOSE);
        $this->symfony->output("line3", "");
        $this->assertTrue(true);
    }


    public function testOutputDebug(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_DEBUG);
        $this->output->shouldReceive("write")->once()->with("<>\tline4</>");
        $this->symfony->output("line4", "");
        $this->assertTrue(true);
    }


    public function testOutputQuiet(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_QUIET);
        $this->symfony->output("line5", "");
        $this->assertTrue(true);
    }


    public function testOutputColor(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_DEBUG);

        $this->output->shouldReceive("write")->once()->with("<fg=orange;>\tline1</>");

        $this->symfony->output("line1", "orange");
        $this->assertTrue(true);
    }


    public function testBreakNormal(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_NORMAL);
        $this->symfony->break("");
        $this->assertTrue(true);
    }


    public function testBreakVerbose(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_VERBOSE);
        $this->symfony->break("");
        $this->assertTrue(true);
    }


    public function testBreakVeryVerbose(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_VERY_VERBOSE);
        $this->symfony->break("");
        $this->assertTrue(true);
    }


    public function testBreakDebug(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_DEBUG);
        $this->output->shouldReceive("writeln")->once()->with("");
        $this->symfony->break("");
        $this->assertTrue(true);
    }


    public function testBreakQuiet(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_QUIET);
        $this->symfony->break("");
        $this->assertTrue(true);
    }


    public function testEndNormal(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_NORMAL);
        $this->symfony->end("");
        $this->assertTrue(true);
    }


    public function testEndVerbose(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_VERBOSE);
        $this->symfony->end("");
        $this->assertTrue(true);
    }


    public function testEndVeryVerbose(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_VERY_VERBOSE);

        $this->output->shouldReceive("writeln")->once()->with("");
        $this->output->shouldReceive("writeln")->once()->with(Mockery::on(function (string $argument) {
            return substr($argument, 0, 17) === "<options=bold;>--" && substr($argument, -5) === "--</>";
        }));

        $this->symfony->end("");
        $this->assertTrue(true);
    }


    public function testEndDebug(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_DEBUG);

        $this->output->shouldReceive("writeln")->once()->with("");
        $this->output->shouldReceive("writeln")->once()->with(Mockery::on(function (string $argument) {
            return substr($argument, 0, 17) === "<options=bold;>--" && substr($argument, -5) === "--</>";
        }));

        $this->symfony->end("");
        $this->assertTrue(true);
    }


    public function testEndQuiet(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_QUIET);
        $this->symfony->end("");
        $this->assertTrue(true);
    }


    public function testEndColor(): void
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_DEBUG);

        $this->output->shouldReceive("writeln")->once()->with("");
        $this->output->shouldReceive("writeln")->once()->with(Mockery::on(function (string $argument) {
            return substr($argument, 0, 27) === "<fg=orange;options=bold;>--" && substr($argument, -5) === "--</>";
        }));

        $this->symfony->end("orange");
        $this->assertTrue(true);
    }
}
