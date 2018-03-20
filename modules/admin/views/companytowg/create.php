<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Companytowg */

$this->title = 'Создать соответствие';
$this->params['breadcrumbs'][] = ['label' => 'Компании - РГ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="companytowg-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
