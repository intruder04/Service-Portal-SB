<?php

namespace app\components;
use yii\base\Widget;
use yii;

class LeftPanelWidgetAdmin extends Widget
{
    public function getPath() {
        return Yii::$app->urlManager->parseRequest(Yii::$app->request)[0];
    }

    public function run(){
        return $this->render('leftPanelAdmin',[
                'currentpath' => $this->getPath()
        ]);
    }
}