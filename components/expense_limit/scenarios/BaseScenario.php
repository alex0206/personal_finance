<?php

namespace app\components\expense_limit\scenarios;


use yii\base\Object;

abstract class BaseScenario extends Object
{
    /**
     * Execution scenario after excess expense limit
     * @return mixed
     */
    abstract public function execute();

    /**
     * Message to inform the user
     * @return mixed
     */
    abstract public function alert();
}