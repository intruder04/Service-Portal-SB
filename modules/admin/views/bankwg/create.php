<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Bankwg */

$this->title = 'Создать РГ';
$this->params['breadcrumbs'][] = ['label' => 'РГ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bankwg-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
