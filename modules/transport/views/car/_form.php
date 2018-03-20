<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\transport\TransportCar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transport-car-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'vehicle_brand')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vehicle_id_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vehicle_color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_id')->label('Компания')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\Company::find()->select(['id','companyname'])-> where(['=', 'id', Yii::$app->user->identity->company_id])->all(), 'id', 'companyname'),['class'=>'form-control inline-block']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
