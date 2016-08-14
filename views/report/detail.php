<?php

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ArrayDataProvider */
/* @var $searchModel \app\models\TotalReportSearch */
/* @var $month string */
/* @var $year string */

use yii\grid\GridView;

$this->title = 'Детальный отчет за месяц: ' . app()->formatter->asDate('01.' . $month . '.' . $year, 'LLLL');
$this->params['breadcrumbs'][] = ['label' => 'Сводный отчет по месяцам', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expense-index">

    <h1><?= $this->title ?></h1>

    <?
    $reportData = $dataProvider->getModels();
    $cntReportData = $dataProvider->getCount();
    $columns[] = [
        'attribute' => 'day',
        'value'     => function ($model, $key, $index, $column) use ($cntReportData) {
            return $index == $cntReportData - 1 ? 'Сумма' : $key;
        },
        'label'     => 'День\Категория',
    ];

    $arCategory = current($reportData)['category'];

    foreach ($arCategory as $categoryId => $value) {
        $columns[] = [
            'attribute' => 'category.' . $categoryId . '.categorySum',
            'label'     => $value['name'],
            'format'    => 'currency',
        ];
    }

    $columns[] = [
        'attribute' => 'sum',
        'label'     => 'Cумма',
        'format'    => 'currency',
    ];
    ?>

    <?= GridView::widget([
        'tableOptions' => [
            'class' => 'table table-striped',
        ],
        'layout'       => '{items}',
        'dataProvider' => $dataProvider,
        'columns'      => $columns,
    ]); ?>
</div>