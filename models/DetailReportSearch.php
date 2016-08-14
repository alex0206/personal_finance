<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;


class DetailReportSearch extends Model
{
    public $month;
    public $year;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['month'], 'date', 'format' => 'm'],
            [['year'], 'date', 'format' => 'Y'],
        ];
    }

    /**
     * Creates data provider instance
     * @param array $params
     * @return ArrayDataProvider
     */
    public function search($params)
    {
        $this->load($params, '');
        $data = [];

        if ($this->validate()) {
            $data = $this->getData();

            if (!empty($data)) {
                $data = $this->createDataMap($data);
            }
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);

        return $dataProvider;
    }

    /**
     * Getting report data
     * @return array
     */
    private function getData()
    {
        return Expense::find()
            ->select([
                'strftime("%d", date) as dayMonth',
                'c.category_id',
                'sum(value) as categorySum',
            ])
            ->where("strftime('%Y', date)=:yearParam and strftime('%m', date)=:monthParam",
                [':yearParam' => $this->year, ':monthParam' => $this->month])
            ->joinWith('category c')
            ->groupBy(['dayMonth', 'c.category_id'])
            ->asArray()
            ->all();
    }

    private function createDataMap(array $data)
    {
        $dataMap = [];
        $arCategorySum = [];
        $categoryMap = $this->getCategoryMap();

        foreach ($data as $item) {
            //Day category init
            if (!isset($dataMap[$item['dayMonth']]['category'])) {
                foreach ($categoryMap as $categoryId => $categoryName) {
                    $dataMap[$item['dayMonth']]['category'][$categoryId] = [
                        'name'        => $categoryName,
                        'categorySum' => 0,
                    ];
                }
            }

            $item['categorySum'] = app()->money->valueToMax($item['categorySum']);
            $dataMap[$item['dayMonth']]['category'][$item['category_id']] = [
                'name'        => $item['category']['name'],
                'categorySum' => $item['categorySum'],
            ];

            if (!isset($dataMap[$item['dayMonth']]['sum'])) {
                $dataMap[$item['dayMonth']]['sum'] = 0;
            }
            $dataMap[$item['dayMonth']]['sum'] += $item['categorySum'];

            //Calculate total sum by category
            if (!isset($arCategorySum['total']['category'])) {
                $arCategorySum['total']['category'] = array_fill_keys(array_keys($categoryMap), ['categorySum' => 0]);
            }

            $arCategorySum['total']['category'][$item['category_id']]['categorySum'] += $item['categorySum'];

            if (!isset($arCategorySum['total']['sum'])) {
                $arCategorySum['total']['sum'] = 0;
            }

            $arCategorySum['total']['sum'] += $item['categorySum'];
        }

        return ArrayHelper::merge($dataMap, $arCategorySum);
    }

    private function getCategoryMap()
    {
        return app()->category->getCategoryMap();
    }
}
