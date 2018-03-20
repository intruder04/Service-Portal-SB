<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
//use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;


use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

use app\components\HeaderWidget;
use app\components\LeftPanelWidget;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title = 'SP') ?></title>
    <link rel="shortcut icon" href="../favicons/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="180x180" href="../favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicons/favicon-16x16.png">
    <link rel="manifest" href="../favicons/manifest.json">
    <link rel="mask-icon" href="../favicons/safari-pinned-tab.svg" color="#5bbad5">

    <meta name="theme-color" content="#ffffff">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


<div class="logoBlock">
    <a href="/">Service portal</a>
</div><div class =headerBlock>

</div>
<div class="filtersBlock">3</div><div class="contentBlcok">4</div>




<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
