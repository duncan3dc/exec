<?php

namespace duncan3dc\ExecTests\Output;

use duncan3dc\Exec\Output\File;
use PHPUnit\Framework\TestCase;

use function file_get_contents;
use function sys_get_temp_dir;
use function tempnam;
use function unlink;

class FileTest extends TestCase
{
    /**
     * @var File $output The instance we are testing.
     */
    private $output;

    /**
     * @var string $path A temporary file to use for testing.
     */
    private $path;


    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        $this->path = (string) tempnam(sys_get_temp_dir(), "duncan3dc_exec_phpunit_");

        $file = new \SplFileObject($this->path, "w+");
        $this->output = new File($file);
    }


    /**
     * @inheritdoc
     */
    protected function tearDown(): void
    {
        unlink($this->path);
    }


    private function assertFileContains(string $expected): void
    {
        $result = file_get_contents($this->path);
        $this->assertSame($expected, $result);
    }


    public function testCommand(): void
    {
        $this->output->command("ls", "blue");
        $this->assertFileContains("ls");
    }


    public function testEnv(): void
    {
        $this->output->env("TEST", "yep", "blue");
        $this->assertFileContains("\t[TEST = yep]\n");
    }


    public function testOutput(): void
    {
        $this->output->output("line1", "blue");
        $this->assertFileContains("\tline1");
    }


    public function testBreak(): void
    {
        $this->output->break("");
        $this->assertFileContains("\n");
    }


    public function testEnd(): void
    {
        $this->output->end("");
        $result = (string) file_get_contents($this->path);
        $this->assertMatchesRegularExpression("/^\n-+\n$/", $result);
    }
}
