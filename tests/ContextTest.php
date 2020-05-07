<?php
declare(strict_types=1);

namespace Test;

use PHPUnit\Framework\TestCase;
use App\Services\OperationBuffer;
use App\Minus;
use App\Plus;
use App\Multiplication;
use App\Division;
use App\Power;
use App\Context;

class ContextTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     *
     * @param $expression
     * @param $expectedResult
     */
    public function testEvaluate($expression, $expectedResult)
    {
        $buffer = new OperationBuffer();

        $buffer->add([(new Minus()), (new Plus()), (new Multiplication()), (new Division()), (new Power())]);

        $context = new Context($buffer);

        $result = $context->evaluate($expression);

        $this->assertEquals($expectedResult, $result);

    }

    public function dataProvider()
    {
        return [
            ['2 + 2 * 2', 6],
            ['2 + 2 * 2 + 2 / 2', 7],
            ['100 + 2 - 2 ^ 16', -65434],
            ['2 + 2 * 2 ^ 3', 18],
        ];
    }
}