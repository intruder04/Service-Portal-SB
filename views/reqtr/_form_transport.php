<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\transport\TransportDriver;
use app\models\Workgroups;
use app\models\User;
use kartik\datecontrol\DateControl;
//use yii\widgets\ActiveField;
//use kartik\date\DatePicker;

//disable input if not admin
$disable_user_fields = $inputFieldAccess;
?>
<?php
//$this->registerCssFile('@web/css/styleOrderTaxi.css', ['depends' => ['app\assets\AppAsset']]);
?>
<?php $form = ActiveForm::begin([]); ?>
<?php
//debug(isset($model->driver) ? 'asd' : 'asds');
//die();
//disable input if not admin
$disable_user_fields = $inputFieldAccess;
//disable status change when done
$disable_done_fields = ($model->status > 5 and $disable_user_fields and !(Yii::$app->session->hasFlash('nosolution'))) ? true : false;
$disable_price_fields = ($model->status > 7 and $disable_user_fields and !(Yii::$app->session->hasFlash('nosolution'))) ? true : false;

$prevPage = isset($_GET['f']) ? $_GET['f'] : '';
?>

<?php if (Yii::$app->session->hasFlash('nosolution')): ?>
    <div class="alert alert-danger alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4><i class="icon fa fa-exclamation-triangle"></i> Ошибка!</h4>
        <?= Yii::$app->session->getFlash('nosolution') ?>
    </div>
<?php endif; ?>

<div class="container-fluid" id="orderTaxi">
    <div class="row">
        <div class="col-lg-12">
<!--Header for button-->
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php echo Html::a( 'Назад', '/' . Yii::$app->controller->id . '/'.$prevPage ,['class'=>'btn btn-warning','id'=>'btnBack']); ?>

                    <?= Html::a('', ['update', 'id' => $nextID, 'f' => $prevPage], ['title' => 'Следующая заявка','class' => 'btn btn-default r-align btn-md fa fa-chevron-down '.$disableNext]) ?>
                    <?= Html::a('', ['update', 'id' => $prevID, 'f' => $prevPage], ['title' => 'Предыдущая заявка','class' => 'btn btn-default r-align btn-md fa fa-chevron-up '.$disablePrev]) ?>

                    <?php if (!$disable_done_fields) { ?>
                        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id'=>'btnSave']) ?>
                    <?php } ?>

                    <?php
                    if (($model->status < 5 and $model->assignee == '') or !$disable_user_fields){
                        echo Html::a('Взять в работу',
                            ['/' . Yii::$app->controller->id . '/update?id='.$model->id . '&f=' . $prevPage], [
                                'class' => 'btn btn-warning',
                                'id'=>'btnInwork',
                                'data-method' => 'POST',
                                'data-params' => [
                                    'status_change' => 10
                                ],
                            ]);
                    }

                    if (($model->driver_id == '' or $model->status < 5) or !$disable_user_fields){
                        echo Html::a('Назначить авто',
                            ['/' . Yii::$app->controller->id . '/update?id='.$model->id . '&f=' . $prevPage], [
                                'class' => 'btn btn-warning',
                                'id'=>'btnAuto',
                                'data-method' => 'POST',
                                'data-params' => [
                                    'status_change' => 11
                                ],
                            ]);
                    }

                    if ($model->status == 5 or !$disable_user_fields or ($model->status == 5 and ($model->closure_code == '' or $model->solution == ''))) {
                        echo Html::a('Завершить поездку',
                            ['/' . Yii::$app->controller->id . '/update?id=' . $model->id . '&f=' . 'mydone'], [
                                'class' => 'btn btn-success',
                                'data' => [
//                            'confirm' => 'Внимание! Выполнить заявку можно только один раз! Выполнить заявку?',
                                ],
                                'id' => 'btnSave',
                                'data-method' => 'POST',
                                'data-params' => [
                                    'status_change' => 12
                                ],
                            ]);
                    }

                    if ($model->status == 7 or !$disable_user_fields) {
                        echo Html::a('Передать данные о поездке в банк',
                            ['/' . Yii::$app->controller->id . '/update?id=' . $model->id . '&f=' . 'pricesent'], [
                                'class' => 'btn btn-success',
                                'data' => [
//                            'confirm' => 'Внимание! Выполнить заявку можно только один раз! Выполнить заявку?',
                                ],
                                'id' => 'btnSave',
                                'data-method' => 'POST',
                                'data-params' => [
                                    'status_change' => 13
                                ],
                            ]);
                    }
                    ?>

                </div>
            </div>
<!-- Блок 1 -->
            <div class="col-lg-5">
                <div class="panel panel-primary">
                    <div class="panel-heading">Информация о заказе</div>
                    <div class="panel-body">
                        <div>
                            <?= $form->field($model, 'sb_id', ['template' => "{label}\n{input}" ,'options' => ['tag' => null]],['errorOptions' => ['tag' => false]])->textInput(['maxlength' => true, 'class'=>'field-class', 'type' => 'string', 'disabled' => $disable_user_fields])?>
                        </div>
                        <div>
                            <?= $form->field($model, 'bank_contact', ['template' => "{label}\n{input}", 'options' => ['tag' => null]])->textInput(['maxlength' => true, 'class'=>'field-class', 'disabled' => $disable_user_fields])->label("Клиент")?>
                        </div>
                        <div>
                            <?= $form->field($model, 'bank_contact_phone', ['template' => "{label}\n{input}", 'options' => ['tag' => null]])->textInput(['maxlength' => true, 'class'=>'field-class', 'disabled' => $disable_user_fields])->label("Телефон клиента")?>
                        </div>
                        <div>
                            <?= $form->field($model, 'travel_from', ['template' => "{label}\n{input}" ,'options' => ['tag' => null]],['errorOptions' => ['tag' => false]])->textArea(['rows'=>2, 'maxlength' => true, 'class'=>'field-class', 'type' => 'string', 'disabled' => $disable_user_fields])?>
                        </div>
                        <div>
                            <?= $form->field($model, 'travel_to', ['template' => "{label}\n{input}", 'options' => ['tag' => null]],['errorOptions' => ['tag' => false]])->textArea(['rows'=>2, 'maxlength' => true, 'class'=>'field-class', 'type' => 'string', 'disabled' => $disable_user_fields])?>
                        </div>
                        <div>
                            <?= $form->field($model, 'ride_stops', ['template' => "{label}\n{input}", 'options' => ['tag' => null]])->textArea(['rows'=>2, 'class'=>'field-class', 'disabled' => $disable_user_fields])?>
                        </div>
                        <div>

<!---->
                            <?php echo $form->field($model, 'ride_start_time', ['template' => "{label}\n{input}", 'options' => ['tag' => null]])->widget(DateControl::classname(), [
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
                                'disabled' => $disable_user_fields,
                                'class'=>'field-class'
                            ]) ?>

                        </div>
                        <div>


                            <?php echo $form->field($model, 'ride_end_time', ['template' => "{label}\n{input}", 'options' => ['tag' => null]])->widget(DateControl::classname(), [
                                'type'=>DateControl::FORMAT_DATETIME,
                                'widgetOptions' => [
                                    'pluginOptions' => [
                                        'autoclose' => true
                                    ]
                                ],
//                                'autoWidget'=> false,
                                'displayFormat' => 'php:d-m-Y H:i:s',
                                'saveFormat' => 'php:U',
                                'language' => 'ru',
                                'displayTimezone'=>'Europe/Moscow',
                                'saveTimezone'=>'UTC',
                                'disabled' => $disable_done_fields,
                                'class'=>'field-class'
                            ]) ?>



                        </div>
                    </div>

                </div>
            </div>
<!-- Блок 2 -->
            <div class="col-lg-7">
                <div class="container-fluid">
                    <div class="row">
<!-- Блок 3- -->
                        <div class="col-lg-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">Водитель</div>
                                <div class="panel-body">
                                    <div>
                                        <?= $form->field($model, 'driver_id', ['template' => "{label}\n{input}\n{error}" ,'options' => ['tag' => null]])->dropDownList(ArrayHelper::map(TransportDriver::find()->
                                        select(['id','driver_fullname'])->
                                        where(['=', 'company_id', Yii::$app->user->identity->company_id])->all(), 'id', 'driver_fullname'),
                                            [
                                                'class'=>'dropdown-class',
                                                'disabled' => $disable_done_fields,
                                                'prompt' => '---',
                                                'onchange'=>'
                                        $.post( "'.Yii::$app->urlManager->createUrl('transport/driver/driverphone?id=').'"+$(this).val(), function( data ) {
                  split=data.split(\'%%\');
                    phone = split[0];
                    brand = split[1];
                    vehicle_id = split[2];
                    fullname = split[3];
                    color = split[4];
                  $( "#transportdriver-driver_phone" ).val( phone );
                  $( "#transportcar-vehicle_brand" ).val( brand );
                  $( "#transportcar-vehicle_id_number" ).val( vehicle_id );
                  $( "#transportcar-vehicle_color" ).val( color );
                  current_solution = $("#requeststransport-solution").val();
                  
                  starting_regexp = /^Назначена/i;
                  console.log(phone);
                    if (phone !== \'---\') {
                        if (current_solution.match(starting_regexp)) {
                            $("#requeststransport-solution").val("Назначена машина: " + brand + ", " + vehicle_id + ", " + color + ". Водитель: " + fullname + ", " + phone);
                        }
                        else {
                            $("#requeststransport-solution").val("Назначена машина: " + brand + ", " + vehicle_id + ". Водитель: " + fullname + ", " + phone + "\n" + current_solution);
                        }
                    }
                            });'
                                            ])
                                        ?>
                                    </div>
                                    <div>
                                        <?php if ($model->driver) { ?>
                                            <?= $form->field($model->driver, 'driver_phone',
                                                [
                                                    'template' => "{label}\n{input}", 'options' => ['tag' => null]
                                                ])
                                                ->textInput(['maxlength' => true, 'class'=>'field-class', 'disabled' => $disable_user_fields])
                                            ?>
                                        <?php } else { ?>
                                            <div>
                                                <label class="control-label" for="transportdriver-driver_phone">Телефон</label>
                                                <input type="text" id="transportdriver-driver_phone" class="field-class" name="TransportDriver[driver_phone]" value="---" disabled="" maxlength="255">
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div>
                                        <?php if ($model->driver) { ?>
                                            <?= $form->field($model->driver->car, 'vehicle_brand',
                                                [
                                                    'template' => "{label}\n{input}", 'options' => ['tag' => null]
                                                ])
                                                ->textInput(['maxlength' => true, 'class'=>'field-class', 'disabled' => $disable_user_fields])
                                            ?>
                                        <?php } else { ?>
                                            <div>
                                                <label class="control-label" for="transportcar-vehicle_brand">Марка</label>
                                                <input type="text" id="transportcar-vehicle_brand" class="field-class" name="TransportCar[vehicle_brand]" value="---" disabled="" maxlength="200">
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div>
                                        <?php if ($model->driver) { ?>
                                            <?= $form->field($model->driver->car, 'vehicle_color',
                                                [
                                                    'template' => "{label}\n{input}", 'options' => ['tag' => null]
                                                ])
                                                ->textInput(['maxlength' => true, 'class'=>'field-class', 'disabled' => $disable_user_fields])
                                            ?>
                                        <?php } else { ?>
                                            <div>
                                                <label class="control-label" for="transportcar-vehicle_color">Цвет</label>
                                                <input type="text" id="transportcar-vehicle_color" class="field-class" name="TransportCar[vehicle_color]" value="---" disabled="" maxlength="200">
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div>
                                        <?php if ($model->driver) { ?>
                                            <?= $form->field($model->driver->car, 'vehicle_id_number',
                                                [
                                                    'template' => "{label}\n{input}", 'options' => ['tag' => null]
                                                ])
                                                ->textInput(['maxlength' => true, 'class'=>'field-class', 'disabled' => $disable_user_fields])
                                            ?>
                                        <?php } else { ?>
                                            <div>
                                                <label class="control-label" for="transportcar-vehicle_id_number">Госномер</label>
                                                <input type="text" id="transportcar-vehicle_id_number" class="field-class" name="TransportCar[vehicle_id_number]" value="---" disabled="" maxlength="255">
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
<!-- Блок 4  -->
                        <div class="col-lg-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">Состояние заказа</div>
                                <div class="panel-body">
                                    <div>
                                        <?= $form->field($model, 'status', ['template' => "{label}\n{input}\n{error}" ,'options' => ['tag' => null]])->dropDownList(ArrayHelper::map(\app\models\transport\TransportStatuses::find()->
                                        select(['id','status'])->all(), 'id', 'status'),
                                            [
                                                'class'=>'dropdown-class',
                                                'disabled'=>$disable_done_fields
                                            ])
                                        ?>

                                    </div>
                                    <div>
                                        <?= $form->field($model, 'workgroup_id', ['template' => "{label}\n{input}\n{error}" ,'options' => ['tag' => null]])->dropDownList(ArrayHelper::map(Workgroups::find()->
                                        select(['workgroups.id','wg_name'])->
                                        leftJoin('companytowg', 'workgroups.id = companytowg.wg_id')->
                                        where(['=', 'companytowg.company_id', Yii::$app->user->identity->company_id])->all(), 'id', 'wg_name'),                             [
                                            'class'=>'dropdown-class',
                                            'disabled' => $disable_done_fields,
//                                        'disabled' => $disable_user_fields,
                                            'onchange'=>'
                                        $.post( "'.Yii::$app->urlManager->createUrl('admin/usertowg/userlist?id=').'"+$(this).val(), function( data ) {
                  $( "select#requests-assignee" ).html( data );
                            });'
                                        ])
                                        ?>
                                    </div>
                                    <div>
                                        <?= $form->field($model, 'assignee', ['template' => "{label}\n{input}\n{error}" ,'options' => ['tag' => null]])->dropDownList(ArrayHelper::map(User::find()->
                                        select(['user.id','displayname'])->
                                        innerJoin('usertowg', 'username_id = user.id')->
                                        where(['=', 'wg_id', $model->workgroup_id])->
                                        all(), 'id', 'displayname'),
                                            [
                                                'class'=>'dropdown-class',
                                                'prompt' => '---',
                                                'disabled' => $disable_done_fields
                                            ]) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!-- Блок 5  -->

                <div class="panel panel-success">
                    <div class="panel-heading">Данные о поездке для отправки в банк</div>
                    <div class="panel-body">
                        <div class="col-lg-6">
                            <div>
                                <?= $form->field($model, 'ride_duration', ['template' => "{label}\n{input}", 'options' => ['tag' => null]])->textInput(['maxlength' => true, 'class'=>'field-class', 'disabled' => $disable_price_fields, 'placeholder' => 'ЧЧ:ММ'])?>
                                
                            </div>
                            <div>
                                <?= $form->field($model, 'ride_idle_time', ['template' => "{label}\n{input}" ,'options' => ['tag' => null]],['errorOptions' => ['tag' => false]])->textInput(['maxlength' => true, 'class'=>'field-class', 'type' => 'string', 'disabled' => $disable_price_fields, 'placeholder' => 'ЧЧ:ММ'])?>
                            </div>
                        </div>
<!--Блок 6-->
                <div class="col-lg-6">
                    <div>
                        <?= $form->field($model, 'ride_distance', ['template' => "{label}\n{input}" ,'options' => ['tag' => null]],['errorOptions' => ['tag' => false]])->textInput(['maxlength' => true, 'class'=>'field-class', 'type' => 'string', 'disabled' => $disable_price_fields, 'placeholder' => 'КМ'])?>
                    </div>
                    <div>
                        <?= $form->field($model, 'ride_price', ['template' => "{label}\n{input}" ,'options' => ['tag' => null]],['errorOptions' => ['tag' => false]])->textInput(['maxlength' => true, 'class'=>'field-class', 'type' => 'string', 'disabled' => $disable_price_fields, 'placeholder' => '₽'])?>
                    </div>
                </div>
                    </div>
                </div>
            </div>
        </div>
<!--Блок 7-->
            <div class="col-lg-10">
                <div class="panel panel-info">
                    <div class="panel-heading">Подробная информация о заказе</div>
                    <div class="panel-body">
                        <div>
                            <?= $form->field($model, 'solution', ['template' => "{label}\n{input}" ,'options' => ['tag' => null]],['errorOptions' => ['tag' => false]])->textArea(['maxlength' => true, 'rows'=>2, 'class'=>'field-class', 'type' => 'string', 'disabled' => $disable_done_fields])?>
                        </div>
                        <div>
                            <?= $form->field($model, 'closure_code', ['template' => "{label}\n{input}\n{error}" ,'options' => ['tag' => null]])->dropDownList(ArrayHelper::map(\app\models\ClosureStatuses::find()->select(['id','closure_code_name'])->all(), 'id', 'closure_code_name'),['class'=>'dropdown-class',  'prompt' => '', 'disabled' => $disable_done_fields]) ?>
                        </div>
                        <div>
                            <?= $form->field($model, 'full_descr', ['template' => "{label}\n{input}" ,'options' => ['tag' => null]],['errorOptions' => ['tag' => false]])->textArea(['maxlength' => true, 'rows'=>10, 'class'=>'field-class', 'type' => 'string', 'disabled' => $disable_user_fields])?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</div>
<?php ActiveForm::end() ?>
<?php
$js  = <<<JS
   $('textarea').textareaAutoSize();
JS;
$this->registerJs($js,\yii\web\View::POS_END);
?>
