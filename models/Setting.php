<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property integer $setting_id
 * @property string $name
 * @property string $value
 */
class Setting extends \yii\db\ActiveRecord
{
    const SUM_LIMIT_SETTING = 'SUM_LIMIT';
    const SCENARIO_SETTING = 'SCENARIO';

    private $nameFormated;
    private $valueFormated;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'value'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'setting_id'    => 'ID',
            'name'          => 'Название',
            'nameFormated'  => 'Название',
            'value'         => 'Значение',
            'valueFormated' => 'Значение',
        ];
    }

    public function getSettingMap()
    {
        return [
            self::SUM_LIMIT_SETTING => 'Предельная сумма',
            self::SCENARIO_SETTING  => 'Сценарий',
        ];
    }

    public function getNameFormated()
    {
        $settingMap = $this->getSettingMap();

        return $settingMap[$this->name] ?: $this->name;
    }

    public function getValueFormated()
    {
        $scenarioMap = $this->getScenarioMap();

        return $this->name === self::SCENARIO_SETTING ? $scenarioMap[$this->value] : $this->value;
    }

    public function getScenarioMap()
    {
        return app()->expenseLimit->getScenarioMap();
    }
}
