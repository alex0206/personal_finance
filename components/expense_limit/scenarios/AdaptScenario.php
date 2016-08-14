<?php

namespace app\components\expense_limit\scenarios;

use app\components\expense_limit\ExpenseLimitService;

class AdaptScenario extends BaseScenario
{
    public $currentExpenseSum;
    public $currentLimitSum;

    public function execute()
    {
        $excessValue = $this->currentExpenseSum - $this->currentLimitSum;
        $nextMonthLimitSum = $this->currentLimitSum - $excessValue;
        $this->setLimitSum($nextMonthLimitSum);
        $this->alert();
    }

    public function alert()
    {
        app()->session->setFlash('error',
            'Превышена предельная сумма расходов за текущий месяц. Предельная сумма следующего месяца скорректирована.');
    }

    /**
     * @param int $limitSum
     * @return bool
     */
    private function setLimitSum($limitSum)
    {
        $expenseLiminService = new ExpenseLimitService();
        $expenseLiminService->updateModel($limitSum, $expenseLiminService->getNextMonthDate());

        return true;
    }
}