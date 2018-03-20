<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Workgroups */

$this->title = 'Обновить РГ: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'РГ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="workgroups-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
