<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Workgroups;
use app\models\ClosureStatuses;
use app\models\Statuses;
use app\models\User;
use kartik\datecontrol\DateControl;

//disable input if not admin
$disable_user_fields = $inputFieldAccess;
//disable status change when done
$disable_done_fields = ($model->status > 3 and $disable_user_fields and !(Yii::$app->session->hasFlash('nosolution'))) ? true : false;
$prevPage = isset($_GET['f']) ? $_GET['f'] : '';
?>

<?php if (Yii::$app->session->hasFlash('nosolution')): ?>
    <div class="alert alert-danger alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4><i class="icon fa fa-exclamation-triangle"></i> Ошибка!</h4>
        <?= Yii::$app->session->getFlash('nosolution') ?>
    </div>
<?php endif; ?>

<div class="requests-form" id="expluotationForm">
    <div class="form-horizontal">

    <?php $form = ActiveForm::begin(); ?>
        <div>
        <?php echo Html::a( 'Назад', '/'. Yii::$app->controller->id . '/' . $prevPage ,['class'=>'btn btn-primary','id'=>'btnBack']); ?>
        <?php if (!$disable_done_fields) { ?>
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id'=>'btnSave']) ?>
        <?php } ?>
        <?php
            if ($model->status < 3 or !$disable_user_fields){
                echo Html::a('Взять в работу',
                    ['/' . Yii::$app->controller->id . '/update?id='.$model->id . '&f=' . $prevPage], [
                        'class' => 'btn btn-warning',
                        'id'=>'btnWarning',
                        'data-method' => 'POST',
                        'data-params' => [
                            'status_change' => 1
                        ],
                    ]);
                }
            if ($model->status == 3 or !$disable_user_fields or ($model->status == 7 and ($model->closure_code == '' or $model->solution == ''))) {
                echo Html::a('Выполнить',
                    ['/' . Yii::$app->controller->id . '/update?id=' . $model->id . '&f=' . 'mydone'], [
                        'class' => 'btn btn-success',
                        'data' => [
//                            'confirm' => 'Внимание! Выполнить заявку можно только один раз! Выполнить заявку?',
                        ],
                        'id' => 'btnSave',
                        'data-method' => 'POST',
                        'data-params' => [
                            'status_change' => 2
                        ],
                    ]);
            }
            ?>

            <div id = 'prevNextButtons'>
            <?= Html::a('', ['update', 'id' => $nextID, 'f' => $prevPage], ['title' => 'Следующая заявка','class' => 'btn btn-default r-align btn-md fa fa-chevron-down '.$disableNext]) ?>
            <?= Html::a('', ['update', 'id' => $prevID, 'f' => $prevPage], ['title' => 'Предыдущая заявка','class' => 'btn btn-default r-align btn-md fa fa-chevron-up '.$disablePrev]) ?>
            </div>
        </div>
        <hr/>
        <br>
        <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                        <div class="container-fluid">
                            <div class="row top-info">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <span>ID обращения</span>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <?= $form->field($model, 'sb_id')->textInput(['maxlength' => true, 'disabled' => $disable_user_fields])->label(false)?>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="row top-info">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <span>Статус</span>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <?= $form->field($model, 'status')->label(false)->dropDownList(ArrayHelper::map(Statuses::find()->select(['id','status'])->all(), 'id', 'status'),['class'=>'form-control inline-block', 'disabled'=>$disable_done_fields]) ?>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="row top-info">
                                <div class="col-lg-6">
                                    <span>Местоположение</span>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group field-requests-sb_id required">

                                        <input type="text" id="requests-sb_id" class="form-control" name="Requests[sb_id]" disabled value="-" maxlength="50" aria-required="true">

                                        <div class="help-block"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="row top-info">
                                <div class="col-lg-6">
                                    <span>Обратился</span>
                                </div>
                                <div class="col-lg-6">
                                    <?= $form->field($model, 'bank_contact')->textInput(['maxlength' => true, 'rel' => 'tooltip', 'readonly' => $disable_user_fields])->label(false)?>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="row top-info">
                                <div class="col-lg-6">
                                    <span>Тел.обратившегося</span>
                                </div>
                                <div class="col-lg-6">
                                    <?= $form->field($model, 'bank_contact_phone')->textInput(['maxlength' => true, 'disabled' => $disable_user_fields, 'rel' => 'tooltip'])->label(false)?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                        <div class="container-fluid">
                            <div class="row top-info">
                                <div class="col-lg-6">
                                    <span>Группа назначения</span>
                                </div>
                                <div class="col-lg-6">
                                    <?= $form->field($model, 'workgroup_id')->
                                    label(false)->
                                    dropDownList(ArrayHelper::map(Workgroups::find()->
                                    select(['workgroups.id','wg_name'])->
                                    leftJoin('companytowg', 'workgroups.id = companytowg.wg_id')->
                                    where(['=', 'companytowg.company_id', Yii::$app->user->identity->company_id])->all(), 'id', 'wg_name'),                             [
                                        'class'=>'form-control col-sm-2 inline-block',
                                        'disabled' => $disable_done_fields,
//                                        'disabled' => $disable_user_fields,
                                        'onchange'=>'
                                        $.post( "'.Yii::$app->urlManager->createUrl('admin/usertowg/userlist?id=').'"+$(this).val(), function( data ) {
                  $( "select#requests-assignee" ).html( data );
                            });'
                                    ])
                                    ?>
                                </div>

                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="row top-info debugBlock">
                                <div class="col-lg-6">
                                    <span>Кому назначено</span>
                                </div>
                                <div class="col-lg-6">
                                    <?= $form->field($model, 'assignee')->
                                    label(false)->
                                    dropDownList(ArrayHelper::map(User::find()->
                                    select(['user.id','displayname'])->
                                    innerJoin('usertowg', 'username_id = user.id')->
                                    where(['=', 'wg_id', $model->workgroup_id])->
                                    all(), 'id', 'displayname'),
                                        [
                                            'class'=>'form-control inline-block',
                                            'prompt' => '---',
                                            'disabled' => $disable_done_fields
//                                            'disabled' => $disable_user_fields
                                        ]) ?>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="row top-info">
                                <div class="col-lg-6">
                                    <span>Создано в Сбербанке</span>
                                </div>
                                <div class="col-lg-6">
                                    <?php echo $form->field($model, 'date_created_sber')->widget(DateControl::classname(), [
                                        'type'=>DateControl::FORMAT_DATETIME,
                                        'widgetOptions' => [
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                            ]
                                        ],
                                        'autoWidget'=> $disable_user_fields ? false : true,
                                        'displayFormat' => 'php:d-m-Y H:i:s',
                                        'saveFormat' => 'php:U',
                                        'language' => 'ru',
                                        'displayTimezone'=>'Europe/Moscow',
                                        'saveTimezone'=>'UTC',
                                        'disabled' => $disable_user_fields
                                    ])->label(false); ?>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="row top-info">
                                <div class="col-lg-6">
                                    <span>Контр.срок в Сбербанке</span>
                                </div>
                                <div class="col-lg-6">
                                    <?php echo $form->field($model, 'date_deadline')->widget(DateControl::classname(), [
                                        'type'=>DateControl::FORMAT_DATETIME,
                                        'widgetOptions' => [
                                            'pluginOptions' => [
                                                'autoclose' => true
                                            ]
                                        ],
                                        'autoWidget'=> $disable_user_fields ? false : true,
                                        'displayFormat' => 'php:d-m-Y H:i:s',
                                        'saveFormat' => 'php:U',
                                        'language' => 'ru',
                                        'displayTimezone'=>'Europe/Moscow',
                                        'saveTimezone'=>'UTC',
                                        'disabled' => $disable_user_fields
                                    ])->label(false); ?>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="row top-info">
                                <div class="col-lg-6">
                                    <span>Желаемая дата</span>
                                </div>
                                <div class="col-lg-6">
                                    <?php echo $form->field($model, 'date_desired')->widget(DateControl::classname(), [
                                        'type'=>DateControl::FORMAT_DATETIME,
                                        'widgetOptions' => [
                                            'pluginOptions' => [
                                                'autoclose' => true
                                            ]
                                        ],
                                        'autoWidget'=> $disable_user_fields ? false : true,
                                        'displayFormat' => 'php:d-m-Y H:i:s',
                                        'saveFormat' => 'php:U',
                                        'language' => 'ru',
                                        'displayTimezone'=>'Europe/Moscow',
                                        'saveTimezone'=>'UTC',
                                        'disabled' => $disable_user_fields
                                    ])->label(false); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="container-fluid">
                <div class="row">
                    <div class="row center-info">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <span>Краткое описание</span>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <?= $form->field($model, 'descr')->textInput(['maxlength' => true, 'disabled' => $disable_user_fields])->label(false)?>
                        </div>
                    </div>
                </div>
            </div>
        <div class="container-fluid">
                <div class="row">
                    <div class="row center-info">
                        <div class="col-lg-3  col-md-3 col-sm-3">
                            <span>Описание</span>
                        </div>
                        <div id="textarea" class="col-lg-5 col-md-5 col-sm-5">
                            <?= $form->field($model, 'full_descr')->textarea(['rows'=>9,'disabled' => $disable_user_fields])->label(false)?>
                        </div>
                    </div>
                </div>
            </div>
        <div class="container-fluid">
                <div class="row">
                    <div class="row center-info">
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <span>Код закрытия</span>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <?= $form->field($model, 'closure_code')->label(false)->dropDownList(ArrayHelper::map(ClosureStatuses::find()->select(['id','closure_code_name'])->all(), 'id', 'closure_code_name'),['class'=>'form-control inline-block',  'prompt' => '', 'disabled' => $disable_done_fields]) ?>
                        </div>
                    </div>
                </div>
            </div>
        <div class="container-fluid">
                <div class="row">
                    <div class="row center-info">
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <span>Решение</span>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5">
                            <?= $form->field($model, 'solution')->textarea(['rows'=>2, 'maxlength' => true, 'disabled' => $disable_done_fields])->label(false)?>
                        </div>
                    </div>
                </div>
            </div>

        <div class="container-fluid">
        <div class="row center-info">
            <div class="col-lg-8">
            </div>
            <div class="col-lg-3">
                <div class="form-group">

            </div>
        </div>
    </div>
        </div>

    <?php ActiveForm::end(); ?>
        <br>
    </div>
</div>

<?php
$js  = <<<JS
   $('textarea').textareaAutoSize();
JS;
$this->registerJs($js,\yii\web\View::POS_END);
?>