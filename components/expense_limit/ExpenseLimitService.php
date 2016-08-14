<?php


namespace app\components\expense_limit;

use DateInterval;
use DateTime;
use Yii;
use yii\base\ErrorException;
use yii\db\ActiveRecord;

/**
 * Class ExpenseLimitService
 * Service for working with expense limit model
 * @package app\components\expense_limit
 */
class ExpenseLimitService
{
    /**
     * @return string
     */
    private function getModelClassName()
    {
        return 'app\models\ExpenseLimitBase';
    }

    /**
     * @param null|string $month
     * @param null|string $year
     * @return ActiveRecord|null
     */
    public function getModel($month = null, $year = null)
    {
        $model = $this->getModelClassName();
        $monthParam = $month ?: date('m');
        $yearParam = $year ?: date('Y');

        return $model::find()
            ->where("strftime('%Y', created_date)=:yearParam 
                and strftime('%m', created_date)=:monthParam",
                [':yearParam' => $yearParam, ':monthParam' => $monthParam])
            ->one();
    }

    /**
     * @param float $sum
     * @param string $date
     * @return ActiveRecord
     * @throws ErrorException
     */
    public function setModel($sum, $date)
    {
        /** @var ActiveRecord $expenseLimitModel */
        $expenseLimitModel = Yii::createObject([
            'class'        => $this->getModelClassName(),
            'sum'          => $sum,
            'created_date' => $date,
        ]);

        return $this->saveModel($expenseLimitModel);
    }

    /**
     * @param int $sum
     * @param string $date
     * @return ActiveRecord
     */
    public function updateModel($sum, $date)
    {
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));
        $expenseLimitModel = $this->getModel($month, $year);

        if (!empty($expenseLimitModel)) {
            $expenseLimitModel->sum = $sum;

            return $this->saveModel($expenseLimitModel);
        }

        return $this->setModel($sum, $date);
    }

    /**
     * @return string
     */
    public function getNextMonthDate()
    {
        $date = new DateTime(date('Y-m-d', mktime(null, null, null, date('m'), 1)));
        $interval = new DateInterval('P1M');
        $date->add($interval);

        return $date->format('Y-m-d');
    }

    /**
     * @param ActiveRecord $expenseLimitModel
     * @return ActiveRecord
     * @throws ErrorException
     */
    private function saveModel(ActiveRecord $expenseLimitModel)
    {
        if (!$expenseLimitModel->save()) {
            throw new ErrorException('Error of saving the expense limit raw: ' . implode('; ',
                    $expenseLimitModel->getFirstErrors()));
        }

        return $expenseLimitModel;
    }
}