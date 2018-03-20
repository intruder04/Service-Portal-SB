<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Company;
use app\models\Bankwg;
use app\models\Workgroups;

/* @var $this yii\web\View */
/* @var $model app\models\Companytowg */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="companytowg-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    echo $form->field($model, 'company_id')->dropDownList(ArrayHelper::map(Company::find()->select(['id','companyname'])->all(), 'id', 'companyname'),['class'=>'form-control inline-block'])
    ?>

    <?php
    echo $form->field($model, 'bank_wg_id')->dropDownList(ArrayHelper::map(Bankwg::find()->select(['id','wg_name'])->all(), 'id', 'wg_name'),['class'=>'form-control inline-block'])
    ?>

    <?php
    echo $form->field($model, 'wg_id')->dropDownList(ArrayHelper::map(Workgroups::find()->select(['id','wg_name'])->all(), 'id', 'wg_name'),['class'=>'form-control inline-block'])
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
