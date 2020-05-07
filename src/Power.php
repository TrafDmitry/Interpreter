<?php
declare(strict_types=1);

namespace App;


class Power extends AbstractOperation
{

    public $priority = 3;
    public $operator = '^';

    public function action(float $left, float $right): float
    {
        return pow($left, $right);
    }
}