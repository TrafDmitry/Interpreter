<?php
declare(strict_types=1);

namespace App;


class Multiplication extends AbstractOperation
{
    public $priority = 2;
    public $operator = '*';

    public function action(float $left, float $right): float
    {
        return $left * $right;
    }
}