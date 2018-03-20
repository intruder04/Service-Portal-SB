<?php
/**
 * Created by PhpStorm.
 * User: intruder04
 * Date: 04/10/2017
 * Time: 11:06
 */

namespace app\modules\admin\controllers;

use app\models\Company;
use Yii;
use yii\web\Controller;

class TransportController extends Controller
{
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