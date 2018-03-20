<?php

namespace app\modules\api\controllers;
use app\models\User;
use yii\filters\auth\HttpBasicAuth;

use app\models\Requests;
use yii\web\Response;
use yii;

class RequestsController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'auth' => function ($username, $password) {
                $user = User::findByUsername($username);
                if ($user && $user->validatePassword($username, $password)) {
                    return $user;
                } else {
                }

            }
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        echo 'this is test';die;
        return $this->render('index');
    }

    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
//        echo 'this is create';die;
//        return $this->render('index');
//        return array ('status' => true);
        $request = new Requests();
        $request->scenario = Requests::SCENARIO_CREATE;
        $request->attributes = Yii::$app->request->post();

        if ($request->validate()) {
            $request->save();
            return array('status'=>true, 'data'=>'request was created');
        }else{
            return array('status'=>false,'data'=>$request->getErrors());
        }
//        $request2 = new \app\modules\api\models\Requests();
    }

}
