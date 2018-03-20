<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Usertowg;
use app\models\UsertowgSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use app\models\User;

/**
 * UsertowgController implements the CRUD actions for Usertowg model.
 */
class UsertowgController extends TransportController
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
     * Lists all Usertowg models.
     * @return mixed
     */

    public function actionIndex()
    {
        $searchModel = new UsertowgSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUserlist($id)
    {
        $countUsers = Usertowg::find()
            ->where(['wg_id' => $id])
            ->count();

        $query=new Query();
        $query->addSelect(['user.id', 'user.displayname'])
            ->from ([Usertowg::tableName()])
            ->leftJoin(User::tableName(),'user.id = usertowg.username_id')
            ->where(['usertowg.wg_id'=>$id]);

        $users = $query->all();

//        $users = Usertowg::find()
//            ->select(['user.id','user.displayname'])
//            ->where(['wg_id1' => $id])
//            ->joinWith('username')
//            ->orderBy('user.id DESC')
//            ->all();

        if($countUsers>0){
            foreach($users as $user){
//                debug($user);
                echo "<option value='".$user['id']."'>".$user['displayname']."</option>";
            }
        }
        else{
            echo "<option>-</option>";
        }
    }

    /**
     * Displays a single Usertowg model.
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
     * Creates a new Usertowg model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usertowg();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Usertowg model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Usertowg model.
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
     * Finds the Usertowg model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usertowg the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usertowg::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
