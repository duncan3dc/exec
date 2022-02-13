<?php

namespace duncan3dc\ExecTests\Output;

use duncan3dc\Exec\Output\Line;
use PHPUnit\Framework\TestCase;

class LineTest extends TestCase
{
    public function testWorks(): void
    {
        $line = new Line("X", 10);
        $this->assertSame("XXXXXXXXXX", (string) $line);
    }


    public function testNoCharacter(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid character [], must be a single character");
        new Line("", 10);
    }


    public function testTooManyCharacter(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid character [AB], must be a single character");
        new Line("AB", 10);
    }
}
