<?php

namespace app\modules\transport\controllers;

use Yii;
use app\models\transport\TransportDriver;
use app\models\transport\TransportDriverSearch;
use app\models\transport\TransportCar;
use yii\db\Query;
use app\controllers\AppController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TransportDriverController implements the CRUD actions for TransportDriver model.
 */
class DriverController extends AppController
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

    public function actionDriverphone($id)
    {
        $count = TransportDriver::find()
            ->where(['id' => $id])
            ->count();

        $query=new Query();

        $query->addSelect(['driver_fullname', 'driver_phone', 'vehicle_brand', 'vehicle_id_number', 'vehicle_color'])
            ->from ([TransportDriver::tableName()])
            ->leftJoin(TransportCar::tableName(),TransportDriver::tableName().'.car_id = ' . TransportCar::tableName() . '.id')
            ->where([TransportDriver::tableName().'.id'=>$id]);

        $users = $query->all();

        if($count>0){
            foreach($users as $user){
                return $user['driver_phone'] . "%%" . $user['vehicle_brand'] . "%%" . $user['vehicle_id_number']. "%%" . $user['driver_fullname']. "%%" . $user['vehicle_color'];
            }
        }
        else{
            return "---";
        }
    }




    /**
     * Lists all TransportDriver models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TransportDriverSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TransportDriver model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TransportDriver model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TransportDriver();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TransportDriver model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/transport/driver']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TransportDriver model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TransportDriver model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TransportDriver the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TransportDriver::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
