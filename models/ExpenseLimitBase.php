<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "expense_limit".
 *
 * @property integer $limit_id
 * @property integer $sum
 * @property string $created_date
 */
class ExpenseLimitBase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'expense_limit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sum'], 'required'],
            [['sum'], 'integer'],
            [['created_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'limit_id'     => 'ID',
            'sum'          => 'Сумма',
            'created_date' => 'Дата',
        ];
    }
}
