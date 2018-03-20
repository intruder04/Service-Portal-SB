<?php

//use yii\helpers\Html;
//use yii\grid\GridView;
//use app\models\Company;
use app\models\Workgroups;
use app\models\Statuses;
use app\models\User;
use yii\helpers\ArrayHelper;
use kartik\daterange\DateRangePicker;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel app\models\RequestsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Заявки';
//$this->params['breadcrumbs'][] = $this->title;
// debug(Yii::$app->user->identity->workgroup_id);die;
//debug(Yii::$app->timeZone);die;
$action = Yii::$app->controller->action->id;
$statusType = \app\models\transport\TransportStatuses::find()->all();
?>

<div class="requests-index">

<h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php if ($controlButtonsAccess === true) {
    echo '<p>';
    echo Html::a('Создать', ['create'], ['class' => 'btn btn-success']);
    echo '</p>';
        } ?>

<?php

//Формируем колонки
$gridColumns = [
   [
        'attribute' => 'sb_id',
        'contentOptions' => ['style' => 'width:10%;  min-width:30px;'],
    ],
    [
        'attribute'=>'status',
        'format'=>'text', // Возможные варианты: raw, html
        'content'=>function($model) use ($statusType) {
            return (ArrayHelper::getValue((ArrayHelper::map(
                $statusType, 'id', 'status'
            )
            ), $model->status,'Нет статуса'));
        },
        'filter' => (ArrayHelper::map($statusType, 'id', 'status')),
        //'contentOptions' => ['style' => 'width:100px;  min-width:50px;'],
        'contentOptions' => ['style' => 'width:10%;  min-width:50px;'],
    ],
    ['attribute' => 'descr',
        'contentOptions' => ['style' => 'width:40%;  min-width:200px;'],
    ],

    [
        'attribute'=>'workgroup_id',
        'format'=>'text', // Возможные варианты: raw, html
        'contentOptions' => ['style' => 'width:10%;'],
        'content'=>function($model){
            return (ArrayHelper::getValue((ArrayHelper::map(Workgroups::find()->
            all(), 'id', 'wg_name')),$model->workgroup_id,'Нет РГ'));
        },
        'filter' => (ArrayHelper::map(Workgroups::find()->select(['workgroups.id','wg_name'])->
        leftJoin('companytowg', 'workgroups.id = companytowg.wg_id')->
        where(['=', 'companytowg.company_id', Yii::$app->user->identity->company_id])->all(), 'id', 'wg_name')),
    ],
    [
        'attribute' => 'assignee',
        'format'=>'text',
        'contentOptions' => ['style' => 'width:20%;'],
        'content'=>function($model){
            return (ArrayHelper::getValue((ArrayHelper::map(User::find()->all(), 'id', 'displayname')),$model->assignee,'---'));
        },
        'filter' => (ArrayHelper::map(User::find()->
        select(['id','displayname'])->
        where(['=', 'company_id', Yii::$app->user->identity->company_id])->all(), 'id', 'displayname')),
    ],
    [
        'attribute' => 'date_created',
        'value' => 'date_created',
        'format' =>  ['date', 'php:d-m-Y h:i:s'],
        'filter' => DateRangePicker::widget([
            'model'=>$searchModel,
            'attribute'=>'date_created',
            'convertFormat'=>true,
            'hideInput'=>false,
            'pluginOptions'=>[
                'locale'=>[
                    'format' => 'd-m-Y'
                ]
            ]
        ]),
    ],
    [
        'attribute' => 'date_done',
        'format' =>  ['date', 'php:d-m-Y h:i:s'],
        'visible'=> (Yii::$app->urlManager->parseRequest(Yii::$app->request)[0] === Yii::$app->controller->id . '/mydone') ? 1 : 0,
        'filter' => DateRangePicker::widget([
            'model'=>$searchModel,
            'attribute'=>'date_done',
            'convertFormat'=>true,
            'hideInput'=>false,
            'pluginOptions'=>[
                'locale'=>[
                    'format' => 'd-m-Y'
                ]
            ]
        ]),
    ],
    [
        'attribute' => 'date_deadline',
        'format' =>  ['date', 'php:d-m-Y h:i:s'],
        'filter' => DateRangePicker::widget([
            'model'=>$searchModel,
            'attribute'=>'date_deadline',
            'convertFormat'=>true,
            'hideInput'=>false,
            'pluginOptions'=>[
                'locale'=>[
                    'format' => 'd-m-Y'
                ]
            ]
        ]),
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'visible' => $controlButtonsAccess,
    ],

];
?>
        <div class="panel panel-default">
            <div class="panel-body">
                <div  id="exportBtn">
<?php
//Кнопки тэкспорта и сброса
echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
    
    'pjaxContainerId' => 'kv-pjax-container',
    'columns' => [
        'sb_id',
        [
            'attribute'=>'status',
            'content'=>function($model){
                return (ArrayHelper::getValue((ArrayHelper::map(\app\models\transport\TransportStatuses::find()->all(), 'id', 'status')),$model->status,'Нет статуса'));
            },
        ],
        'descr',
        'full_descr',
        'date_created:datetime',
        'date_deadline:datetime',
        'date_done:datetime'
    ],
    'fontAwesome' => true,
    'dropdownOptions' => [
        'label' => "&nbsp;".'Экспорт',
        'class' => 'btn btn-default',
        'id' => 'export-dropdown'
    ],
    'exportConfig' => [
        ExportMenu::FORMAT_TEXT => false,
        ExportMenu::FORMAT_PDF => false,
        ExportMenu::FORMAT_CSV => false,
        ExportMenu::FORMAT_HTML => false,
        ExportMenu::FORMAT_PDF => false,
        ExportMenu::FORMAT_EXCEL => true
    ]
]);
?>
    <?php if (Yii::$app->controller->action->id != 'update') { ?>
        <?= Html::a("Сбросить фильтры "."&nbsp;"."<i class='fa fa-refresh' aria-hidden='true'></i>", [$this->context->route], ['class' => 'btn btn-default', 'id' => 'refreshButton']) ?>
    <?php } ?>
                </div>
            </div>
        </div>
<?php
echo  GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,

        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],

        'filterModel' => $searchModel,

        'rowOptions' => function ($model, $key, $index, $grid) use ($action) {
//                  Подсветка контрольного срока. Если 30 минут до КС - желтый. Если текущее время старше КС - красный
          $class = ((time() > $model['date_deadline'] - 1800) && ($model['status'] != 7) && (time() < $model['date_deadline'])) ? 'warning' : (time() > $model['date_deadline'] && $model['status'] != 7 ? 'danger':'');
          return [
              'id' => $model['id'],
              'style' => "cursor: pointer",
              'class'=>$class,
              'onclick' => 'location.href="'
                  . Yii::$app->urlManager->createUrl(Yii::$app->controller->id . '/update')
                  . '?id="+(this.id)+'
                  . "\"&f=".$action."\""
                ];
        },
        'persistResize'=>false,
        'tableOptions' => [
            'class' => 'table table-bordered table-hover kartik-grid-view'
    ],
    ]);
?>

</div>

<?php $this->registerJsFile('@web/js/sendMessage.js',['depends' => 'yii\web\YiiAsset']); ?>

<?php
if(date("s") == 0) {
    foreach ($arrOrder as $order) { ?>
        <script>
            sendNotification('Автоинформирование',{body: 'На вашу РГ поступил запрос <?= $order?>',icon: '../img/icon.png' ,dir: 'auto'});
        </script>
    <?php }
}
 ?>

