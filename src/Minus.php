<?php
declare(strict_types=1);

namespace App;

class Minus extends AbstractOperation
{
    public $priority = 1;
    public $operator = '-';

    public function action(float $left, float $right): float
    {
        return $left - $right;
    }
}