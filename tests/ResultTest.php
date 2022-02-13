<?php

namespace duncan3dc\ExecTests;

use duncan3dc\Exec\Result;
use PHPUnit\Framework\TestCase;

use function count;
use function iterator_to_array;

class ResultTest extends TestCase
{
    public function testGetStatus1()
    {
        $result = new Result(0, []);
        $this->assertSame(0, $result->getStatus());
    }

    public function testGetStatus2()
    {
        $result = new Result(254, []);
        $this->assertSame(254, $result->getStatus());
    }


    public function testGetLines1()
    {
        $result = new Result(0, ["one", "two", "three"]);
        $this->assertSame(["one", "two", "three"], $result->getLines());
    }

    public function testGetLines2()
    {
        $result = new Result(0, []);
        $this->assertSame([], $result->getLines());
    }

    public function testGetLines3()
    {
        $result = new Result(0, ["one", "two", "three"]);
        $result->getFirstLine();
        $result->getLastLine();
        $result->getLines();
        $this->assertSame(["one", "two", "three"], $result->getLines());
    }


    public function testGetFirstLine1()
    {
        $result = new Result(0, ["one", "two", "three"]);
        $this->assertSame("one", $result->getFirstLine());
    }

    public function testGetFirstLine2()
    {
        $result = new Result(0, []);
        $this->assertSame("", $result->getFirstLine());
    }

    public function testGetFirstLine3()
    {
        $result = new Result(0, ["one", "two", "three"]);
        $this->assertSame("one", $result->getFirstLine());
        $this->assertSame("one", $result->getFirstLine());
    }


    public function testGetLastLine1()
    {
        $result = new Result(0, ["one", "two", "three"]);
        $this->assertSame("three", $result->getLastLine());
    }

    public function testGetLastLine2()
    {
        $result = new Result(0, []);
        $this->assertSame("", $result->getLastLine());
    }

    public function testGetLastLine3()
    {
        $result = new Result(0, ["one", "two", "three"]);
        $this->assertSame("three", $result->getLastLine());
        $this->assertSame("three", $result->getLastLine());
    }


    public function testToString1()
    {
        $result = new Result(0, ["one", "two", "three"]);
        $this->assertSame("one\ntwo\nthree", (string) $result);
    }

    public function testToString2()
    {
        $result = new Result(0, []);
        $this->assertSame("", (string) $result);
    }


    public function testCount1()
    {
        $result = new Result(0, ["one", "two", "three"]);
        $this->assertSame(3, count($result));
    }

    public function testCount2()
    {
        $result = new Result(0, []);
        $this->assertSame(0, count($result));
    }


    public function testIterable1()
    {
        $result = new Result(0, ["one", "two", "three"]);
        $data = [];
        foreach ($result as $key => $line) {
            $data[] = $line;
        }
        $this->assertSame(["one", "two", "three"], $data);
    }

    public function testIterable2()
    {
        $result = new Result(0, []);
        $data = [];
        foreach ($result as $key => $line) {
            $data[] = $line;
        }
        $this->assertSame([], $data);
    }


    /**
     * Enrure we can iterate over it multiple times.
     */
    public function testIterable3(): void
    {
        $result = new Result(0, ["one", "two"]);

        $this->assertSame(["one", "two"], iterator_to_array($result));
        $this->assertSame(["one", "two"], iterator_to_array($result));
    }
}
