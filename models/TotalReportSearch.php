<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;


class TotalReportSearch extends Model
{
    public $year;

    public function init()
    {
        parent::init();
        $this->year = $this->year ?: $this->getDefaultYear();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year'], 'date', 'format' => 'Y'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return SqlDataProvider
     */
    public function search($params)
    {
        $this->load($params);

        if (!$this->validate()) {
            $this->year = $this->getDefaultYear();
        }

        $dataProvider = new SqlDataProvider([
            'sql'    => $this->getSqlReportData(),
            'params' => [':yearParam' => $this->year],
        ]);

        return $dataProvider;
    }

    private function getSqlReportData()
    {
        return "select strftime('%m', date) as monthYear, sum(value) as total 
                from expense 
                where strftime('%Y', date)=:yearParam group by monthYear";
    }

    private function getDefaultYear()
    {
        return date('Y');
    }
}
