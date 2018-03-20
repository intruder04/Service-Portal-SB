<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\ServiceTypes;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CompaniesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Компании';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="companies-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать компанию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'companyname',
            'contact',
            'coordinator',
//            'service_type',
            [
                'attribute'=>'service_type',
                'format'=>'text', // Возможные варианты: raw, html
                'content'=>function($model){
                    return (ArrayHelper::getValue((ArrayHelper::map(ServiceTypes::find()->all(), 'id', 'service_name')),$model->service_type,'Тип сервиса не задан'));
                },
                'filter' => (ArrayHelper::map(ServiceTypes::find()->all(), 'id', 'service_name')),
            ],
            'assignee_sber',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
