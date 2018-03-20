<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Pjax;
//use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;
//
//
//use yii\widgets\Breadcrumbs;
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

<?php $this->beginBody() ?>

<div class="wrap">
    <div id="progressbar"></div>
    <?php echo HeaderWidget::widget(); ?>
    <?php if (!Yii::$app->user->isGuest) { ?>

    <div class="container-fluid">
        <div class="row">
            <div id="mainBlock"  class="col-lg-12 col-md-12 col-sm-12">
                <div class="container-fluid">
                    <div class="row">
                        <?php Pjax::begin(); ?>
                        <?php echo LeftPanelWidget::widget(); ?>
                        <div id="tableBlock"  class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                            <div class="container-fluid">
                                    <?= $content ?>
                             </div>
                         </div>
                        
                         <?php 
                            $this->registerJsFile('@web/js/control.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

                            // $this->registerJsFile('@web/js/kv-export/kv-export-columns.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
                            // $this->registerJsFile('@web/js/kv-export/kv-export-data.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
                            // $this->registerJsFile('@web/js/kv-export/kv-grid-export.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
                            
                        ?>
                         <!-- Костыль -->
                         <script>
                            $('#exportBtn').append($('#w3 > div.summary'));

                            $('#exportBtn > div.btn-group > div:nth-child(2)').click(function(){
                                $('#exportBtn > div.btn-group > div:nth-child(2)').toggleClass('open');
                            });

                            
                        </script>
                         <!--  -->
                        <?php Pjax::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <?php $this->registerJsFile('@web/js/message.js',[\yii\web\View::POS_HEAD]); ?>
        <?php $this->registerJsFile('@web/js/nanobar.min.js'); ?>
    <?php } else { ?>
    <div class="container">
        <div id="fonIndex">
            <img src="../img/fon.png" width="98%" alt=""></p>
        </div>
    <?= $content ?>
    </div>
    <?php } ?>

</div>
</div>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
