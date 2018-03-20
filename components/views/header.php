<?php


use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\widgets\ActiveForm;

?>
<?php
// На случай размножения сервисов

if ($serviceType == 1) {
    $currentGlSearch = 'reqexpl/globalsearch';
}
elseif ($serviceType == 2) {
    $currentGlSearch = 'reqtr/globalsearch';
}
else {
    $currentGlSearch = 'reqtr/globalsearch';
}

?>

<div class="header" >
        <div class="leftPart">
            <i id="iconMenu" class="fa fa-bars fa-2x" aria-hidden="true"></i>
            <a id="logoText" href="/">Service portal</a>
        </div>
    <div class="rightPart">
        <?php
        echo Nav::widget([
            'items' => [
                Yii::$app->user->isGuest ? (
                [
                    'label' => '',
                    'url' => ['/site/login'],
                    'linkOptions' =>['class'=>'']]
                ) : (
                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Выйти (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link logout', 'id' => 'outHref']
                    )
                    . Html::endForm()
                    . '</li>'
                )
            ],
        ]);
        ?>
    </div>
    <?php if (!Yii::$app->user->isGuest) { ?>
        <div id="searchBlock" class="rightPart">
            <?php $form = ActiveForm::begin(['action' => [$currentGlSearch],'method' => 'get','options' => ['class'=>'form-inline my-2 my-lg-0 mr-lg-2',]])?>
            <?= $form->field($model, 'query')->textInput(['class'=>'form-control','placeholder' => 'Поиск по заявкам'])->label(false)?>
            <?= Html::submitButton('<i class="fa fa-search"></i>',['class'=>'btn btn-primary']) ?>
            <?php ActiveForm::end() ?>
        </div>
    <?php } else {} ?>
</div>
<?php if (!Yii::$app->user->isGuest) { ?>
    <div id="searchBlockMobile">
        <?php $form = ActiveForm::begin(['action' => [$currentGlSearch],'method' => 'get','options' => ['class'=>'form-inline my-2 my-lg-0 mr-lg-2',]])?>
        <?= Html::activeInput('text',$model,'query',['placeholder' => 'Поиск по заявкам']) ?>
        <?= Html::submitButton('<i class="fa fa-search"></i>',['class'=>'btn btn-primary','id'=>'btnMobile']) ?>
        <?php ActiveForm::end() ?>
    </div>
<?php } else {} ?>