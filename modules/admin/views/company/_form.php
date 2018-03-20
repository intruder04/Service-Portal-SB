<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\ServiceTypes;

/* @var $this yii\web\View */
/* @var $model app\models\Company */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="companies-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'companyname')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'contact')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'coordinator')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'assignee_sber')->textInput(['maxlength' => true]) ?>
<!--    --><?//= $form->field($model, 'service_type')->textInput(['maxlength' => true]) ?>
    <?php
    echo $form->field($model, 'service_type')->dropDownList(ArrayHelper::map(ServiceTypes::find()->select(['id','service_name'])->all(), 'id', 'service_name'),['class'=>'form-control inline-block'])
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
