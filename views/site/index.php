<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $categoryMap array */

use yii\grid\GridView;

$this->title = app()->name . ' - Главная';
?>
<h1 class="page-header">Главная</h1>

<h2 class="sub-header">Последние расходы</h2>
<div class="table-responsive">
    <?= GridView::widget([
        'tableOptions' => [
            'class' => 'table table-striped',
        ],
        'layout' => '{items}',
        'dataProvider' => $dataProvider,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'category_id',
                'value' => function($model, $key, $index, $column) use($categoryMap) {
                    return $categoryMap[$model->category_id];
                }
            ],
            'value:currency',
            'comment',
            'date',
        ],
    ]); ?>
</div>
