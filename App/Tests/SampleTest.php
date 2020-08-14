<?php
/**
 *
 */

namespace App\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Class SampleTest
 *
 * @package App\Tests
 */
class SampleTest extends TestCase
{
    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function testPushAndPop()
    {
        $stack = [];
        $this->assertSame(0, count($stack));

        array_push($stack, 'foo');
        $this->assertSame('foo', $stack[count($stack)-1]);
        $this->assertSame(1, count($stack));

        $this->assertSame('foo', array_pop($stack));
        $this->assertSame(0, count($stack));
    }
}
