<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\transport\TransportDriver */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Водители', 'url' => ['index']];

?>
<div class="transport-driver-view">

<!--    <h1>--><?//= Html::encode($this->driver_fullname) ?><!--</h1>-->

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'driver_fullname',
            'driver_phone',
            'status',
            'car_id',
            'company_id',
//            'sber_workgroup_id',
        ],
    ]) ?>

</div>
