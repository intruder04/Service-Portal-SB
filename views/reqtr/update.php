<?php

use yii\helpers\Html;
//use yii\data\ArrayDataProvider;
/* @var $this yii\web\View */
/* @var $model app\models\Requests */
//$this->title = 'Внести изменения: ' . $model->id;
//$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->sb_id, 'url' => ['update', 'id' => $model->sb_id]];
//$this->params['breadcrumbs'][] = 'Редактировать';
//debug($model->status);die;
?>
<div class="requests-update">

    <h1><?= Html::encode($this->title) ?></h1>
        <?= $this->render('_form_transport', [
            'model' => $model,
            'inputFieldAccess' => $inputFieldAccess,
            'nextID'=>$nextID,
            'prevID'=>$prevID,
            'disableNext'=>$disableNext,
            'disablePrev'=>$disablePrev,
        ]) ?>
</div>