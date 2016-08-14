<?php

namespace app\components;


use yii\base\Object;

class Money extends Object
{
    /**
     * @var int Max digit of money
     */
    public $maxDigit = 2;

    /**
     * Convert value to min value of money
     * @param float $value Value for convert
     * @return integer
     */
    public function valueToMin($value)
    {
        return app()->formatter->asInteger($value * pow(10, $this->maxDigit));
    }

    /**
     * Convert value to max value of money
     * @param int $value Value for convert
     * @param bool $format The value will be formated to currency format
     * @return float
     */
    public function valueToMax($value, $format = false)
    {
        $convertedSum = $value / pow(10, $this->maxDigit);

        return $format ? app()->formatter->asCurrency($convertedSum) : $convertedSum;
    }
}