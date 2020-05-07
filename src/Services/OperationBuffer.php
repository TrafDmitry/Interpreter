<?php
declare(strict_types=1);

namespace App\Services;

use App\AbstractOperation;

class OperationBuffer
{
    /** @var AbstractOperation [] */
    public $buffer = [];

    /** @param AbstractOperation [] $operations */
    public function add(array $operations)
    {
        foreach ($operations as $operation) {
            $this->buffer[$operation->getOperator()] = $operation;
        }
    }

    /**
     * @return array
     */
    public function getOperationWithHighPriority(): array
    {
        $this->sort();

        $result = [];
        foreach ($this->buffer as $operation) {
            $currentPriority = $operation->priority;

            if (isset($previousPriority) && ($currentPriority < $previousPriority)) {
                break;
            }
            $result[$operation->getOperator()] = $operation;
            $previousPriority = $operation->priority;
        }

        return $result;
    }

    public function deleteOperationWithHighPriority(): void
    {
        $this->sort();

        foreach ($this->buffer as $operator => $operation) {
            $currentPriority = $operation->priority;

            if (isset($previousPriority) && ($currentPriority < $previousPriority)) {
                break;
            }
            unset($this->buffer[$operator]);
            $previousPriority = $operation->priority;
        }
    }

    private function sort()
    {
        if (count($this->buffer) > 1) {
            uasort($this->buffer, function ($operation1, $operation2){

                /**
                 * @var $operation1 AbstractOperation
                 * @var $operation2 AbstractOperation
                 */
                return ($operation1->priority < $operation2->priority) ? 1 : -1;
            });
        }

        return $this->buffer;
    }

}