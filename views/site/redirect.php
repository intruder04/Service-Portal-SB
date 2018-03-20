<?php
use yii\helpers\Url;

//Этот view указан как view по умолчанию в /config/web.php

if ($role === 'admin') {
    Yii::$app->response->redirect(Url::to(['admin/userm/index'], true));
}
//            эксплуатация
elseif ($servicetype == '1') {
    Yii::$app->response->redirect(Url::to(['reqexpl/index'], true));
}
//            транспорт
elseif ($servicetype == '2') {

    Yii::$app->response->redirect(Url::to(['reqtr/index'], true));
}

else {
    Yii::$app->response->redirect(Url::to(['site/login'], true));
}