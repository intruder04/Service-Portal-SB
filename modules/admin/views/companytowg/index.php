<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CompanytowgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Компания - РГ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="companytowg-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать соответствие', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'id',
            [
                'attribute'=>'company_id',
                'value'=>'company.companyname',
                'label'=>'Компания'
            ],
            [
                'attribute'=>'bank_wg_id',
                'value'=>'bankWg.wg_name',
                'label'=>'РГ в банке'
            ],
            [
                'attribute'=>'wg_id',
                'value'=>'wg.wg_name',
                'label'=>'РГ на портале'
            ],
//            'company_id',
//            'bank_wg_id',
//            'wg_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
