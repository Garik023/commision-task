<?php

declare(strict_types=1);

namespace CommissionTask\Service;

class Math
{
    private $scale;

    public function __construct(int $scale)
    {
        $this->scale = $scale;
    }

    public function add(string $leftOperand, string $rightOperand): string
    {
        return bcadd($leftOperand, $rightOperand, $this->scale);
    }

    public function percentage($number, $percent)
    {
        $value =  $number*$percent/100;
        return number_format($value, $this->scale, '.', "");
    }

}
