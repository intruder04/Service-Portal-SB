<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \mdm\admin\models\form\Login */

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login animated zoomIn">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, заполните следующие поля для входа:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username')->label('Логин') ?>
                <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
                <?= $form->field($model, 'rememberMe')->checkbox()->label('Запомнить меня') ?>
<!--                <div style="color:#999;margin:1em 0">-->
<!--                    Если вы забыли свой пароль, вы можете --><?//= Html::a('сбросить его', ['user/request-password-reset']) ?><!--.-->
<!--                    For new user you can --><?//= Html::a('signup', ['user/signup']) ?><!--.-->
<!--                </div>-->
                <div class="form-group">
                    <?= Html::submitButton('Вход', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>


            <?php ActiveForm::end(); ?>


        </div>
    </div>
</div>
