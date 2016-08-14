<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Expense */
/* @var $categoryMap array */

$this->title = 'Редактировать расход: ' . $model->expense_id;
$this->params['breadcrumbs'][] = ['label' => 'Расходы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->expense_id, 'url' => ['view', 'id' => $model->expense_id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="expense-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'       => $model,
        'categoryMap' => $categoryMap,
    ]) ?>

</div>
