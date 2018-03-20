<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Usertowg */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usertowg-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username_id')->dropDownList(ArrayHelper::map(\app\models\User::find()->select(['id','displayname'])->all(), 'id', 'displayname'),['class'=>'form-control inline-block']) ?>

    <?= $form->field($model, 'wg_id')->dropDownList(ArrayHelper::map(\app\models\Workgroups::find()->select(['id','wg_name'])->all(), 'id', 'wg_name'),['class'=>'form-control inline-block']) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
