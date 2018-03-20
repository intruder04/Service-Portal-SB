<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\transport\TransportCarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Автомобили';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transport-car-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить автомобиль', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php //Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return [
                'id' => $model['id'],
                'style' => "cursor: pointer",
                'onclick' => 'location.href="'
                    . Yii::$app->urlManager->createUrl('/transport/car/update')
                    . '?id="+(this.id)+""'
            ];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
            'attribute'=> 'id',
            'contentOptions' => ['style' => 'width:10%;  min-width:50px;'],
            ],
            'vehicle_brand',
            'vehicle_id_number',
            'vehicle_color',
            [
                'attribute'=>'company_id',
                'value'=>'company.companyname',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'view' => false
                ]
            ],
        ],
    ]); ?>
<?php //Pjax::end(); ?></div>
