<?php

namespace app\components\expense_limit;


use app\components\expense_limit\scenarios\AdaptScenario;
use app\components\expense_limit\scenarios\Increase;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;
use yii\base\Object;

class ExpenseLimit extends Object
{
    const ADAPT_SCENARIO = 1;
    const INCREASE_SCENARIO = 2;

    /**
     * @var array
     * Ex.:
     * [
     *    'class' => 'Model class',
     *    'sumValueField' => 'value',
     *    'dateField' => 'date'
     * ]
     */
    public $model;

    /**
     * @var array
     * Ex.:
     * [
     *    'class' => 'Setting class',
     *    'settingSumName' => 'SUM_LIMIT',
     *    'settingScenarioName' => 'SCENARIO',
     *    'settingNameField' => 'name',
     *    'valueField' => 'value'
     * ]
     */
    public $settingModel;
    private $currentExpenseSum = null;
    private $currentLimitSum = null;
    private $expenseLimitModel;

    public function init()
    {
        parent::init();

        if (!isset($this->model['class'], $this->model['sumValueField'], $this->model['dateField'])) {
            throw new InvalidConfigException('Wrong configurated the "model" field');
        }

        if (!isset($this->settingModel['class'], $this->settingModel['settingSumName'], $this->settingModel['settingScenarioName'],
            $this->settingModel['settingNameField'], $this->settingModel['valueField'])
        ) {
            throw new InvalidConfigException('Wrong configurated the "model" field');
        }
    }

    public function getScenarioMap()
    {
        return [
            self::ADAPT_SCENARIO    => 'Адаптивый предел',
            self::INCREASE_SCENARIO => 'Увеличение предела',
        ];
    }

    /**
     * Checking excess of expense limit
     * @return bool
     */
    public function checkExcess()
    {
        $currentExpenseSum = $this->getCurrentExpenseSum();
        $currentLimitSum = $this->getCurrentLimitSum();

        return $currentExpenseSum > $currentLimitSum;
    }

    public function executeScenario()
    {
        $scenarioSetting = $this->getScenarioSetting();

        switch ($scenarioSetting) {
            case self::ADAPT_SCENARIO:
                $scenario = new AdaptScenario([
                    'currentExpenseSum' => $this->getCurrentExpenseSum(),
                    'currentLimitSum'   => $this->getCurrentLimitSum(),
                ]);
                break;
            case self::INCREASE_SCENARIO:
                $scenario = new Increase([
                    'expenseLimitModelId' => $this->expenseLimitModel->limit_id,
                ]);
                break;
            default:
                throw new NotSupportedException('Not supported scenario');
        }

        return $scenario->execute();
    }

    private function getCurrentExpenseSum()
    {
        if (is_null($this->currentExpenseSum)) {
            $modelClass = $this->model['class'];

            $this->currentExpenseSum = $modelClass::find()
                ->select([
                    'sum(' . $this->model['sumValueField'] . ')',
                ])
                ->where("strftime('%Y', " . $this->model['dateField'] . ")=:yearParam 
                and strftime('%m', " . $this->model['dateField'] . ")=:monthParam",
                    [':yearParam' => date('Y'), ':monthParam' => date('m')])
                ->groupBy(["strftime('%m', " . $this->model['dateField'] . ")"])
                ->scalar();
        }

        return $this->currentExpenseSum;
    }

    /**
     * @return mixed
     */
    public function getSettingLimitSum()
    {
        $limitSum = $this->getSettingValue($this->settingModel['settingSumName']);

        return app()->money->valueToMin($limitSum);
    }

    /**
     * @return integer
     */
    public function getCurrentLimitSum()
    {
        if (is_null($this->currentLimitSum)) {
            $expenseLiminService = new ExpenseLimitService();
            $this->expenseLimitModel = $expenseLiminService->getModel();

            if (empty($this->expenseLimitModel)) {
                $settingLimitSum = $this->getSettingLimitSum();
                $this->expenseLimitModel = $expenseLiminService->setModel($settingLimitSum, date('Y-m-d'));
            }

            $this->currentLimitSum = $this->expenseLimitModel->sum;
        }

        return $this->currentLimitSum;
    }

    /**
     * @return string
     */
    public function getScenarioSetting()
    {
        return $this->getSettingValue($this->settingModel['settingScenarioName']);
    }

    /**
     * Getting value from setting table
     * @param string $settingName Setting name
     * @return string
     */
    private function getSettingValue($settingName)
    {
        $settingClass = $this->settingModel['class'];

        return $settingClass::find()
            ->where([$this->settingModel['settingNameField'] => $settingName])
            ->select($this->settingModel['valueField'])
            ->scalar();
    }
}