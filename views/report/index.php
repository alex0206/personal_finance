<?php

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\SqlDataProvider */
/* @var $searchModel \app\models\TotalReportSearch */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Сводный отчет по месяцам';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expense-index">

    <h1><?= $this->title ?></h1>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'tableOptions' => [
            'class' => 'table table-striped',
        ],
        'layout'       => '{items}',
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            [
                'attribute' => 'year',
                'content'     => function ($model, $key, $index, $column) use($searchModel) {
                    return Html::a($model['monthYear'], ['detail', 'month' => $model['monthYear'], 'year' => $searchModel->year]);
                },
                'label'     => 'Месяц года',
            ],
            [
                'attribute' => 'total',
                'value'     => function ($model, $key, $index, $column) {
                    return app()->money->valueToMax($model['total'], true);
                },
                'label'     => 'Итого',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>