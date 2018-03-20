<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\transport\TransportCar */

$this->title = 'Редактировать авто: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Автомобили', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
?>
<div class="transport-car-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
