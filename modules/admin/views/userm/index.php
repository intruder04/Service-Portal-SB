<?php

use yii\helpers\Html;
use yii\grid\GridView;

use app\models\Company;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsermSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Логины';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать пользователя', ['signup'], ['class' => 'btn btn-success']) ?>
    </p>
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'username',
            'displayname',
            'email:email',
            'created_at:datetime',
            // [
            //     'attribute' => 'status',
            //     'value' => function($model) {
            //         return $model->status == 0 ? 'Inactive' : 'Active';
            //     },
            //     'filter' => [
            //         0 => 'Inactive',
            //         10 => 'Active'
            //     ]
            // ],
            // 'company_id',
            [
                'attribute'=>'company_id',
                'label'=>'Компания',
                'format'=>'text', // Возможные варианты: raw, html
                'content'=>function($model){
                return (ArrayHelper::getValue((ArrayHelper::map(Company::find()->all(), 'id', 'companyname')),$model->company_id,'Нет компании'));
                     },
                'filter' => (ArrayHelper::map(Company::find()->all(), 'id', 'companyname')),
            ],
            'timezone',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?> 




</div>
