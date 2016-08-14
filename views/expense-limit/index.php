<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Предельные суммы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expense-limit-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            'sum:currency',
            [
                'attribute' => 'created_date',
                'format'    => ['date', 'LLLL Y'],
                'label'     => 'Активность',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
