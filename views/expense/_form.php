<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Expense */
/* @var $form yii\widgets\ActiveForm */
/* @var $categoryMap array */
?>

<div class="expense-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList($categoryMap) ?>

    <?= $form->field($model, 'value')->textInput() ?>

    <?= $form->field($model, 'comment')->textarea() ?>

    <?= $form->field($model, 'date')->widget(DatePicker::className(), [
        'language'   => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
        'inline' => true,
        'clientOptions' => [
            'maxDate' => 0
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
