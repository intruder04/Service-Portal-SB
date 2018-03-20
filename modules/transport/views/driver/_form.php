<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\transport\TransportDriver */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transport-driver-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'driver_fullname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'driver_phone')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '+9 999 999 9999',
        'clientOptions' => [
            'removeMaskOnSubmit' => true,
        ]
    ]) ?>

    <?= $form->field($model, 'status')->DropDownList(['1' => 'Работает', '0' => 'Уволен']) ?>

    <?= $form->field($model, 'car_id')->label('Номер авто')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\transport\TransportCar::find()->select(['id','vehicle_id_number'])->all(), 'id', 'vehicle_id_number'),['class'=>'form-control inline-block',  'prompt' => '']) ?>

    <?= $form->field($model, 'company_id')->label('Компания')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\Company::find()->select(['id','companyname'])->where(['=', 'id', Yii::$app->user->identity->company_id])->all(), 'id', 'companyname'),['class'=>'form-control inline-block']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
