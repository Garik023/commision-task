<?php

declare(strict_types=1);

namespace CommissionTask\Service;

use CommissionTask\Instance\Config as ConfigFactory;

class Math
{
    private $scale;

    public function __construct()
    {
        $this->scale = ConfigFactory::getInstance()->get('app.scale');
    }

    public function add($a, $b)
    {
        return bcadd(strval($a), strval($b), $this->scale);
    }

    public function sub($a,  $b)
    {
        return bcsub(strval($a), strval($b));
    }

    public function mul( $a,  $b)
    {
        return bcmul(strval($a), strval($b), $this->scale);
    }

    public function div( $a,  $b)
    {
        return bcdiv(strval($a), strval($b), $this->scale);
    }

    public function percentage($number, $percent)
    {
        return $this->div($this->mul($number, $percent), 100);
    }

    public function max($a, $b)
    {
        return max($this->sub($a, $b), 0);
    }

}
