<?php
declare(strict_types=1);

namespace App;

use App\Services\OperationBuffer;
use App\Services\Parser;

class Context
{
    /** @var Parser */
    private $parser;
    /** @var OperationBuffer */
    private $operationBuffer;

    public function __construct(OperationBuffer $buffer)
    {
        $this->parser = new Parser();
        $this->operationBuffer = $buffer;
    }

    public function evaluate(string $expressionString)
    {
        $expressionArray = $this->parser->parse($expressionString);
        $result = $this->operationLoop($expressionArray);
        return $result[0];
    }

    private function operationLoop(array $expressionArray)
    {
        $operators = $this->operationBuffer->getOperationWithHighPriority();
        if (!count($operators)) {
            return $expressionArray;
        }

        $newExpressionArray = $this->expressionLoop($expressionArray, $operators);

        $this->operationBuffer->deleteOperationWithHighPriority();

        return $this->operationLoop($newExpressionArray);

    }

    private function expressionLoop(array $expressionArray, array $operations)
    {
        $newExpressionArray = [];
        $size = count($expressionArray);

        for ($i = 1; $i < $size; $i += 2) {

            $operator = $expressionArray[$i];

            if (isset($operations[$operator])) {

                /** @var $operation AbstractOperation*/
                $operation = $operations[$operator];

                $left = $expressionArray[$i - 1];
                $right = $expressionArray[$i + 1];

                $newValue = $operation->action((float)$left, (float)$right);

                $newExpressionArray[] = $newValue;

                $residue = (($i + 2) < $size) ? array_slice($expressionArray, $i + 2) : [];

                return $this->expressionLoop(array_merge($newExpressionArray, $residue), $operations);

            } else {

                $newExpressionArray[] = $expressionArray[$i - 1];
                $newExpressionArray[] = $expressionArray[$i];

            }
        }

        return $expressionArray;
    }


}