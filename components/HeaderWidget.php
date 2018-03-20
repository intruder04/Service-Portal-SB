<?php
/**
 * Created by PhpStorm.
 * User: Note
 * Date: 09.08.2017
 * Time: 8:47
 */

namespace app\components;

use app\models\GlobalSearch;
use yii\base\Widget;
use yii;



class HeaderWidget extends Widget
{
//
//    public function getServiceType()
//    {
////        Companies::find()->where(['name' => 'CeBe'])->one();
////        debug(Yii::$app->user->identity->company_id);die;
//        $service_type = Company::find()->select(['service_type'])->
////        leftJoin('companytowg', 'workgroups.id = companytowg.wg_id')->
//        where(['=', 'id', Yii::$app->user->identity->company_id])->one();
//        return $service_type -> service_type;
//
//    }
//
    public function run(){

        $model = new GlobalSearch();
        $serviceType = Yii::$app->controller->getServiceType();

        return $this->render('header',compact('model','serviceType'));
    }
}