<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RequestsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="requests-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'sb_id') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'descr') ?>

    <?= $form->field($model, 'full_descr') ?>

    <?php // echo $form->field($model, 'solution') ?>

    <?php // echo $form->field($model, 'date_created') ?>

    <?php // echo $form->field($model, 'date_updated') ?>

    <?php // echo $form->field($model, 'date_done') ?>

    <?php // echo $form->field($model, 'work_group') ?>

    <?php // echo $form->field($model, 'assignee') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
