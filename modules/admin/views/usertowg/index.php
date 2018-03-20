<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsertowgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Логин - РГ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usertowg-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить пользователя в РГ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'attribute'=>'wg_id',
                'format'=>'text', // Возможные варианты: raw, html
                'content'=>function($model){
                    return (ArrayHelper::getValue((ArrayHelper::map(\app\models\Workgroups::find()->all(), 'id', 'wg_name')),$model->wg_id,'Нет РГ'));
                },
                'filter' => (ArrayHelper::map(\app\models\Workgroups::find()->all(), 'id', 'wg_name')),
                'contentOptions' => ['style' => 'width:500px;  min-width:200px;'],
            ],
            [
            'attribute'=>'username_id',
            'format'=>'text', // Возможные варианты: raw, html
            'content'=>function($model){
                return (ArrayHelper::getValue((ArrayHelper::map(\app\models\User::find()->all(), 'id', 'displayname')),$model->username_id,'Нет логина'));
            },
                'filter' => (ArrayHelper::map(\app\models\User::find()->all(), 'id', 'displayname')),
            'contentOptions' => ['style' => 'width:300px;  min-width:200px;'],
        ],
//            'wg_id',
//            'username_id',
//            'user.username',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
