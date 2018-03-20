<?php
/**
 * Created by PhpStorm.
 * User: intruder04
 * Date: 11/08/2017
 * Time: 10:42
 */

namespace app\controllers;

use app\models\Company;
use Yii;
use yii\web\Controller;

class AppController extends Controller
{
//    получить роль залогиненного пользователя
    public function getRole()
    {
        if (Yii::$app->user->identity) {
            return $roleName = key(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()));
        }
    }

//    create button access
    public function controlButtonsAccess()
    {
        return $this->getRole() === 'admin' ? true : false;
    }

    //    input field access
    public function inputFieldAccess()
    {
        return $this->getRole() === 'admin' ? false : true;
    }

    public function getServiceType()
    {
//        Companies::find()->where(['name' => 'CeBe'])->one();
//        debug(Yii::$app->user->identity->company_id);die;
        if (Yii::$app->user->identity) {

        $service_type = Company::find()->select(['service_type'])->
//        leftJoin('companytowg', 'workgroups.id = companytowg.wg_id')->
        where(['=', 'id', Yii::$app->user->identity->company_id])->one();
        return $service_type->service_type;
        }

    }

}