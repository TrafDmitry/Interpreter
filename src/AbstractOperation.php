<?php
declare(strict_types=1);

namespace App;

abstract class AbstractOperation
{
    public $priority = null;
    public $operator = null;

    abstract public function action(float $left, float $right): float;

    /**
     * @return null
     */
    public function getOperator()
    {
        return $this->operator;
    }
}