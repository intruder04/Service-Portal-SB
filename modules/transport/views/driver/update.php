<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\transport\TransportDriver */
//$this->params['breadcrumbs'][] = ['label' => 'Transport Drivers', 'url' => ['index']];

$this->title = 'Редактировать водителя: ' . $model->driver_fullname;
$this->params['breadcrumbs'][] = ['label' => 'Водители', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->driver_fullname, 'url' => ['update', 'id' => $model->id]];
?>
<div class="transport-driver-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
