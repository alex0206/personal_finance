<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ExpenseLimitBase */

$this->title = 'Предельная сумма: ' . app()->formatter->asDate($model->created_date, 'LLLL');
$this->params['breadcrumbs'][] = ['label' => 'Предельные суммы', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="expense-limit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
