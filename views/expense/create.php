<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Expense */
/* @var $categoryMap array */

$this->title = 'Добавить расход';
$this->params['breadcrumbs'][] = ['label' => 'Расходы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expense-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'       => $model,
        'categoryMap' => $categoryMap,
    ]) ?>

</div>
