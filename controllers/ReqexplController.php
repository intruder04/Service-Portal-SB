<?php

namespace app\controllers;

use app\models\GlobalSearch;
use app\models\NewOrder;
use Yii;
use app\models\Requests;
use app\models\RequestsSearch;

//use yii\db\Query;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ReqexplController extends AppController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new RequestsSearch();
        $newOrder = new NewOrder();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=7;
//        $this->view->params['controlButtonsAccess'] = $this->controlButtonsAccess();

         if (Yii::$app->request->isPjax) {
             return $this->renderAjax();
         }

        return $this->render('index', [

            'arrOrder' => $newOrder->searchNewOrder(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'controlButtonsAccess' => $this->controlButtonsAccess(),

        ]);
    }

    public function actionMygrp()
    {
        $searchModel = new RequestsSearch();
        $newOrder = new NewOrder();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->pagination->pageSize=7;
        $this->view->params['controlButtonsAccess'] = $this->controlButtonsAccess();

        //Для работы фильтров
       if (Yii::$app->request->isPjax) {
           return $this->renderAjax();
       }

        return $this->render('index', [

            'arrOrder' => $newOrder->searchNewOrder(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'controlButtonsAccess' => $this->controlButtonsAccess(),
        ]);
    }

     public function actionMy()
    {
        $searchModel = new RequestsSearch();
        $newOrder = new NewOrder();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=7;
        $this->view->params['controlButtonsAccess'] = $this->controlButtonsAccess();

       if (Yii::$app->request->isPjax) {
           return $this->renderAjax('my');
       }

        return $this->render('index', [
            'arrOrder' => $newOrder->searchNewOrder(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'controlButtonsAccess' => $this->controlButtonsAccess(),
        ]);
    }

    public function actionMydone()
    {
        $searchModel = new RequestsSearch();
        $newOrder = new NewOrder();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->pagination->pageSize=7;
        $this->view->params['controlButtonsAccess'] = $this->controlButtonsAccess();

       if (Yii::$app->request->isPjax) {
           return $this->renderAjax();
       }

        return $this->render('index', [

            'arrOrder' => $newOrder->searchNewOrder(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'controlButtonsAccess' => $this->controlButtonsAccess(),
        ]);
    }

    public function actionRejected()
    {
        $searchModel = new RequestsSearch();
        $newOrder = new NewOrder();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=7;
        $this->view->params['controlButtonsAccess'] = $this->controlButtonsAccess();
        
        if (Yii::$app->request->isPjax) {
            return $this->renderAjax();
        }
        
        return $this->render('index', [
            'arrOrder' => $newOrder->searchNewOrder(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'controlButtonsAccess' => $this->controlButtonsAccess(),
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Requests();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
//        Кнопки в заявке предыдущ\следующ
        $prevNext = new RequestsSearch();
        $index = $prevNext->NextOrPrev($id);

        $nextID = $index['next'];
        $disableNext = ($nextID===null)?'disabled':null;
        $prevID = $index['prev'];
        $disablePrev = ($prevID===null)?'disabled':null;

        $prevPage = isset($_GET['f']) ? $_GET['f'] : '';

        $model = $this->findModel($id);
        $model->load(\Yii::$app->request->post());

        if ($model->validate()) {
            if ($model->status == 7) {
                $model->date_done = time();
            }
        } else {
            $errorString = '';
            foreach($model->errors as $item) {
                $errorString =  $errorString . " " .  $item[0];
            }
            Yii::$app->session->setFlash('nosolution', $errorString);
        }

        $status_change = Yii::$app->request->post('status_change', null);

//        Логика кнопок действий
        if ($status_change) {
            $buttonLogicObj = new RequestsSearch();
            $buttonLogicArr = $buttonLogicObj->ButtonLogic($status_change, $model);
            foreach($buttonLogicArr as $logicParam => $logicValue) {
                $model->$logicParam = $logicValue;
            }
            $model->save();
            return $this->redirect(['update', 'id' => $model->id , 'f' => $prevPage]);
        }


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([Yii::$app->controller->id . '/' . $prevPage]);
        } else {
//            debug($model);die;
            return $this->render('update', [
                'model' => $model,
                'inputFieldAccess' => $this->inputFieldAccess(),
                'nextID'=>$nextID,
                'prevID'=>$prevID,
                'disableNext'=>$disableNext,
                'disablePrev'=>$disablePrev,
            ]);
        }
    }

    protected function findModel($id)
    {
        if (($model = Requests::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionGlobalsearch(){
        //Входной запрос
        $request = Yii::$app->request->get();
        $inpQuery=$request['GlobalSearch']['query'];

        $model = new GlobalSearch();
        $dataProvider = $model->searchCol($inpQuery);

        return $this->render('globalSearch',compact('model','dataProvider'));
    }
}
