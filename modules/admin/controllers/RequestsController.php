<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Requests;
use app\models\Company;
use app\models\User;
use app\models\RequestsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

/**
 * RequestsController implements the CRUD actions for Requests model.
 */

class RequestsController extends TransportController
{
    /**
     * @inheritdoc
     */
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

    /**
     * Lists all Requests models.
     * @return mixed
     */
    public function actionIndex()
    {
        // debug(Yii::$app->user->identity->workgroup_id);die;
        $searchModel = new RequestsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
        
    }

    /**
     * Displays a single Requests model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionShow()
    {
        $company = Company::find()->where('id=1')->all();
        var_dump($company);

    }

    /**
     * Creates a new Requests model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Requests();
        // var_dump($model->load(Yii::$app->request->post()));
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            if ($model->validate() && $model->save()) {
                return $this->redirect(['index']);
            }
        }
            else {
                return $this->render('create', ['model'=>$model]);
            }
            
    
    }

    /**
     * Updates an existing Requests model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        // var_dump(Yii::$app->user->can('updateOwnRequest', ['post' => $model]));die;
        // var_dump(Yii::$app->user);die;

//        if(!Yii::$app->user->can('updateOwnRequest', ['post' => $model])){
//            throw new ForbiddenHttpException ("Вам сюда нельзя, не ваша заявка");
//        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        
    }

    /**
     * Deletes an existing Requests model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        
        $model = $this->findModel($id)->delete();
        if(!Yii::$app->user->can('updateOwnRequest', ['post' => $model])){
            throw new ForbiddenHttpException ("Вам сюда нельзя");
        }
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Requests model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Requests the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Requests::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
