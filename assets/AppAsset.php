<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;


class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/style.css',
       // 'css/hover.css',
        'css/font-awesome.css',

    ];
    public $js = [
        'js/bootstrap.js',
        //'js/control.js',
        //'js/jquery.textarea_autosize.js',
    ];


    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',

    ];

}
