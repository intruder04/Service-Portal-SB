<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
//use app\models\Company;
//use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\transport\TransportDriverSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Водители';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transport-driver-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать водителя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php //Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return [
                'id' => $model['id'],
                'style' => "cursor: pointer",
                'onclick' => 'location.href="'
                    . Yii::$app->urlManager->createUrl('/transport/driver/update')
                    . '?id="+(this.id)+""'
            ];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'id',
            [
            'attribute'=>'driver_fullname',
            'contentOptions' => ['style' => 'width:30  min-width:50px;'],
            ],
            [
                'attribute'=> 'driver_phone',
                'contentOptions' => ['style' => 'width:15%;  min-width:50px;'],
            ],
            [
                'attribute'=>'status',
                'value' => function($model, $key, $index, $column) { return $model->status == 0 ? 'Уволен' : 'Работает';},
                'contentOptions' => ['style' => 'width:25%;  min-width:50px;'],
            ],
            [
                'attribute'=>'car_id',
                'value'=>'car.vehicle_id_number',
            ],
            [
                'attribute'=>'company_id',
                'value'=>'company.companyname',
                'contentOptions' => ['style' => 'width:30%;  min-width:50px;'],
            ],
            // 'sber_workgroup_id',
            [
                    'class' => 'yii\grid\ActionColumn',
                    'visibleButtons' => [
                    'view' => false
                                        ]
            ],
        ],
    ]); ?>
<?php //Pjax::end(); ?></div>
