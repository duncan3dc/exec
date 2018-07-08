<?php

namespace duncan3dc\ExecTests\Output;

use duncan3dc\Exec\Output\Symfony;
use Mockery;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\OutputInterface;

class SymfonyTest extends TestCase
{
    /**
     * @var Symfony $symfony The instance we are testing.
     */
    private $symfony;

    /**
     * @var OutputInterface|Mock $output A symfony output interface for testing.
     */
    private $output;


    public function tearDown()
    {
        Mockery::close();
    }


    private function setOutputVerbosity($verbosity)
    {
        $this->output = Mockery::mock(OutputInterface::class);
        $this->output->shouldReceive("getVerbosity")->andReturn($verbosity);

        $this->symfony = new Symfony($this->output);
    }


    public function testCommandNormal()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_NORMAL);
        $this->symfony->command("ls", "");
        $this->assertTrue(true);
    }

    public function testCommandVerbose()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_VERBOSE);
        $this->symfony->command("ls", "");
        $this->assertTrue(true);
    }

    public function testCommandVeryVerbose()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_VERY_VERBOSE);
        $this->output->shouldReceive("write")->once()->with("<options=bold;>ls</>");
        $this->symfony->command("ls", "");
        $this->assertTrue(true);
    }

    public function testCommandDebug()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_DEBUG);
        $this->output->shouldReceive("write")->once()->with("<options=bold;>ls</>");
        $this->symfony->command("ls", "");
        $this->assertTrue(true);
    }

    public function testCommandQuiet()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_QUIET);
        $this->symfony->command("ls", "");
        $this->assertTrue(true);
    }

    public function testCommandColor()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_DEBUG);

        $this->output->shouldReceive("write")->once()->with("<fg=orange;options=bold;>ls</>");

        $this->symfony->command("ls", "orange");
        $this->assertTrue(true);
    }


    public function testEnvNormal()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_NORMAL);
        $this->symfony->env("TEST", "yep", "");
        $this->assertTrue(true);
    }

    public function testEnvVerbose()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_VERBOSE);
        $this->symfony->env("TEST", "yep", "");
        $this->assertTrue(true);
    }

    public function testEnvVeryVerbose()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_VERY_VERBOSE);
        $this->symfony->env("TEST", "yep", "");
        $this->assertTrue(true);
    }

    public function testEnvDebug()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_DEBUG);
        $this->output->shouldReceive("writeln")->once()->with("\t[TEST = yep]");
        $this->symfony->env("TEST", "yep", "");
        $this->assertTrue(true);
    }

    public function testEnvQuiet()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_QUIET);
        $this->symfony->env("TEST", "yep", "");
        $this->assertTrue(true);
    }


    public function testOutputNormal()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_NORMAL);
        $this->symfony->output("line1", "");
        $this->assertTrue(true);
    }

    public function testOutputVerbose()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_VERBOSE);
        $this->symfony->output("line2", "");
        $this->assertTrue(true);
    }

    public function testOutputVeryVerbose()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_VERY_VERBOSE);
        $this->symfony->output("line3", "");
        $this->assertTrue(true);
    }

    public function testOutputDebug()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_DEBUG);
        $this->output->shouldReceive("write")->once()->with("<>\tline4</>");
        $this->symfony->output("line4", "");
        $this->assertTrue(true);
    }

    public function testOutputQuiet()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_QUIET);
        $this->symfony->output("line5", "");
        $this->assertTrue(true);
    }

    public function testOutputColor()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_DEBUG);

        $this->output->shouldReceive("write")->once()->with("<fg=orange;>\tline1</>");

        $this->symfony->output("line1", "orange");
        $this->assertTrue(true);
    }


    public function testBreakNormal()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_NORMAL);
        $this->symfony->break("");
        $this->assertTrue(true);
    }

    public function testBreakVerbose()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_VERBOSE);
        $this->symfony->break("");
        $this->assertTrue(true);
    }

    public function testBreakVeryVerbose()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_VERY_VERBOSE);
        $this->symfony->break("");
        $this->assertTrue(true);
    }

    public function testBreakDebug()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_DEBUG);
        $this->output->shouldReceive("writeln")->once()->with("");
        $this->symfony->break("");
        $this->assertTrue(true);
    }

    public function testBreakQuiet()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_QUIET);
        $this->symfony->break("");
        $this->assertTrue(true);
    }


    public function testEndNormal()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_NORMAL);
        $this->symfony->end("");
        $this->assertTrue(true);
    }

    public function testEndVerbose()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_VERBOSE);
        $this->symfony->end("");
        $this->assertTrue(true);
    }

    public function testEndVeryVerbose()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_VERY_VERBOSE);

        $this->output->shouldReceive("writeln")->once()->with("");
        $this->output->shouldReceive("writeln")->once()->with(Mockery::on(function (string $argument) {
            return substr($argument, 0, 17) === "<options=bold;>--" && substr($argument, -5) === "--</>";
        }));

        $this->symfony->end("");
        $this->assertTrue(true);
    }

    public function testEndDebug()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_DEBUG);

        $this->output->shouldReceive("writeln")->once()->with("");
        $this->output->shouldReceive("writeln")->once()->with(Mockery::on(function (string $argument) {
            return substr($argument, 0, 17) === "<options=bold;>--" && substr($argument, -5) === "--</>";
        }));

        $this->symfony->end("");
        $this->assertTrue(true);
    }

    public function testEndQuiet()
    {
        $this->setOutputVerbosity(OutputInterface::VERBOSITY_QUIET);
        $this->symfony->end("");
        $this->assertTrue(true);
    }

    public function testEndColor()
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
