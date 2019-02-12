<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StackTest extends TestCase
{

    public function testEmpty()
    {
        $stack = [];
        $this->assertEmpty($stack);

        return $stack;
    }
    //Example 2.2 Using the @depends annotation to express dependencies
    /**
     * @depends testEmpty
     */
    public function testPush(array $stack)
    {
        array_push($stack, 'foo');
        $this->assertSame('foo', $stack[count($stack)-1]);
        $this->assertNotEmpty($stack);

        return $stack;
    }
    /**
     * @depends testPush
     */
    public function testPop(array $stack)
    {
        $this->assertSame('foo', array_pop($stack));
        $this->assertEmpty($stack);
    }
    public function testProducerFirst()
    {
        $this->assertTrue(true);
        return 'first';
    }

    public function testProducerSecond()
    {
        $this->assertTrue(true);
        return 'second';
    }
//Example 2.4 Test with multiple dependencies
    /**
     * @depends testProducerFirst
     * @depends testProducerSecond
     */
    public function testConsumer($a, $b)
    {
        $this->assertSame('first', $a);
        $this->assertSame('second', $b);
    }

    //Example 2.6 Using a data provider with named datasets
    /**
    * @dataProvider additionProvider
    */
    public function testAdd($a, $b, $expected)
    {
        $this->assertSame($expected, $a + $b);
    }
  
    public function additionProvider()
    {
        return [
            '0 mais 0'=>[0, 0, 0],
            '0 mais 1'=>[0, 1, 1],
            '1 mais 0'=>[1, 0, 1],
            '1 mais 1'=>[1, 1, 3]
        ];
    }
}
