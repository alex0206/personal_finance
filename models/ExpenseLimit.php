<?php

namespace app\models;


class ExpenseLimit extends ExpenseLimitBase
{
    public function afterFind()
    {
        parent::afterFind();
        $this->sum = app()->money->valueToMax($this->sum);
    }

    public function beforeSave($insert)
    {
        $this->sum = app()->money->valueToMin($this->sum);
        return parent::beforeSave($insert);
    }
}