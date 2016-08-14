<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "expense".
 *
 * @property integer $expense_id
 * @property integer $category_id
 * @property integer $value
 * @property string $comment
 * @property string $date
 */
class Expense extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'expense';
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->value = app()->money->valueToMax($this->value);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'value'], 'required'],
            ['value', 'number'],
            [
                'value',
                'filter',
                'filter' => function ($value) {
                    return app()->money->valueToMin($value);
                },
            ],
            [['category_id'], 'integer'],
            [
                ['category_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Category::className(),
                'targetAttribute' => ['category_id' => 'category_id'],
            ],
            [['comment'], 'string'],
            [['date'], 'default', 'value' => date('Y-m-d')],
            [['date'], 'date', 'format' => 'yyyy-MM-dd'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'expense_id'  => 'ID',
            'category_id' => 'Категория',
            'value'       => 'Сумма',
            'comment'     => 'Комментарий',
            'date'        => 'Дата',
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['category_id' => 'category_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if (app()->expenseLimit->checkExcess()) {
            app()->expenseLimit->executeScenario();
        }
    }


}
