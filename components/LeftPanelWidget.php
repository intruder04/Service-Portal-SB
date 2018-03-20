<?php
/**
 * Created by PhpStorm.
 * User: Note
 * Date: 09.08.2017
 * Time: 9:04
 */

namespace app\components;
use yii\base\Widget;
use Yii;
use app\models\Company;

class LeftPanelWidget extends Widget
{
    public function getPrevPage() {
        return isset($_GET['f']) ? $_GET['f'] : '';
    }

    public function getCurrentPath() {
        return Yii::$app->urlManager->parseRequest(Yii::$app->request)[0];
    }

    public function getServiceType()
    {
//        Companies::find()->where(['name' => 'CeBe'])->one();
//        debug(Yii::$app->user->identity->company_id);die;
        $service_type = Company::find()->select(['service_type'])->
//        leftJoin('companytowg', 'workgroups.id = companytowg.wg_id')->
        where(['=', 'id', Yii::$app->user->identity->company_id])->one();
        return $service_type -> service_type;

    }

    public function run(){
        return $this->render('leftPanel', [
            'currentPath' => $this->getCurrentPath(),
            'prevPage' => $this->getPrevPage(),
            'service_type' => $this->getServiceType(),
        ]);
    }
}