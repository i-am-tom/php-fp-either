<?php

namespace PhpFp\Either\Test;

use PhpFp\Either\Either;
use PhpFp\Either\{Left, Right};

class ApTest extends \PHPUnit_Framework_TestCase
{
    public function testApParameterCount()
    {
        $count = (new \ReflectionMethod('PhpFp\Either\Left::ap'))
            ->getNumberOfParameters();

        $this->assertEquals($count,
            1,
            'Left::ap takes one parameter.'
        );

        $count = (new \ReflectionMethod('PhpFp\Either\Right::ap'))
            ->getNumberOfParameters();

        $this->assertEquals($count,
            1,
            'Right::ap takes one parameter.'
        );
    }

    public function testAp()
    {
        $addTwo = Right::of(
            function ($x)
            {
                return $x + 2;
            }
        );

        $id = function ($x)
        {
            return $x;
        };

        $a = Right::of(5);
        $b = Left::of(4);

        $this->assertEquals(
            $addTwo
                ->ap($a)
                ->either($id, $id),
            7,
            'Applies to a Right.'
        );

        $this->assertEquals(
            $addTwo->ap($b)->either($id, $id),
            4,
            'Applies to a Left.'
        );

        $subOne = new Left(
            function ($x) {
                return $x - 1;
            }
        );

        $this->assertEquals(
            $subOne->ap($a)->either($id, $id),
            5,
            'Does not apply to a Right.'
        );

        $this->assertEquals(
            $subOne->ap($b)->either($id, $id),
            4,
            'Does not apply to a Left.'
        );
    }
}
