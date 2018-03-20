<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\transport\TransportDriver */

$this->title = 'Создать нового водителя';
$this->params['breadcrumbs'][] = ['label' => 'Водители', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transport-driver-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
