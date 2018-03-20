<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Company;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\WorkgroupsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'РГ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="workgroups-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать РГ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'wg_name',
//            [
//                'attribute'=>'company_id',
//                'label'=>'Компания',
//                'format'=>'text', // Возможные варианты: raw, html
//                'content'=>function($model){
//                return (ArrayHelper::getValue((ArrayHelper::map(Company::find()->all(), 'id', 'companyname')),$model->company_id,'Нет компании'));
//                     },
//                'filter' => (ArrayHelper::map(Company::find()->all(), 'id', 'companyname')),
//            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
