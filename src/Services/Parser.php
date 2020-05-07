<?php
declare(strict_types=1);

namespace App\Services;


class Parser
{
    public function parse(string $s): array
    {
        $result = [];
        $expectedNumber = '';
        for ( $i = 0; $i < strlen($s); $i++) {
            $sumbol = $s[$i];
             if (is_numeric($sumbol)) {
                 $expectedNumber .= $sumbol;
             } elseif($sumbol != ' ') {
                 $result[] = $expectedNumber;
                 $result[] = $sumbol;
                 $expectedNumber = '';
             }
        }
        $result[] = $expectedNumber;
        return $result;
    }
}