<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Requests */

$this->title = 'Создать заявку';
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requests-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('__form', [
        'model' => $model,
    ]) ?>

</div>
