<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

use app\components\HeaderWidget;
use app\components\LeftPanelWidgetAdmin;

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
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="../../favicons/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="180x180" href="../../favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../favicons/favicon-16x16.png">
    <link rel="manifest" href="../favicons/manifest.json">
    <link rel="mask-icon" href="../favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
    <?php $this->head() ?>
</head>
<?php $this->beginBody() ?>
<!---->
<div class="wrap">
    <!--****************************************-->
    <!--Виджет шапки-->
    <?php echo HeaderWidget::widget(); ?>
    <!--Тело   -->
    <?php if (!Yii::$app->user->isGuest) { ?>

        <div class="container-fluid">
            <div class="row">
                <div id="mainBlock"  class="col-lg-12 col-md-12 col-sm-12">
                    <div class="container-fluid">
                        <div class="row">
                            <div id="left-panel" class="col-lg-2 col-md-12 col-sm-12">
                                <div>
                                    <?php echo LeftPanelWidgetAdmin::widget(); ?>
                                </div>
                            </div>

                            <div class="col-lg-10 col-md-12 col-sm-12">
                                <div class="container-fluid">
                                    <?= Breadcrumbs::widget([
                                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                    ]) ?>
                                    <?= $content ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php } else { ?>
        <div class="container">
            <?= $content ?>
        </div>
    <?php } ?>

    <div class="navbar-fixed-bottom  row-fluid">
        <div class="navbar-inner">
            <div class="container-fluid footer">
                <p class="text-right">&copy; <?//= date('Y') ?>
            </div>
        </div>
    </div>

</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>