<?php

use app\models\Setting;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Setting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="setting-form">

    <?php $form = ActiveForm::begin(); ?>

    <? if ($model->name == Setting::SCENARIO_SETTING): ?>
        <?= $form->field($model, 'value')->dropDownList($model->getScenarioMap()) ?>
    <? else: ?>
        <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>
    <? endif ?>

    <div class="form-group">
        <?= Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
