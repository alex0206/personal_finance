<?php


namespace app\components\expense_limit\scenarios;


use yii\helpers\Html;

class Increase extends BaseScenario
{
    public $expenseLimitModelId;

    public function execute()
    {
        $this->alert();
    }

    public function alert()
    {
        app()->session->setFlash('error',
            'Превышена предельная сумма расходов за текущий месяц. Отредактируйте текущий месячный ' . Html::a('предел',
                ['/expense-limit/update', 'id' => $this->expenseLimitModelId]));
    }
}