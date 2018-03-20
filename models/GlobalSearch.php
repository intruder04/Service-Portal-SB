<?php
/**
 * Created by PhpStorm.
 * User: Note
 * Date: 13.08.2017
 * Time: 19:53
 */

namespace app\models;

use yii\db\ActiveRecord;
use yii\data\ArrayDataProvider;
use Yii;

class GlobalSearch extends ActiveRecord
{
    public $query;

    public static function tableName()
    {
        return 'requests';
    }

    public function searchCol($inpQuery){
        $queryS =  GlobalSearch::find();

        $dataProvider = new ArrayDataProvider([
            'allModels'=>$queryS -> orFilterWhere(['like','sb_id',$inpQuery])
                -> orFilterWhere(['like','descr',$inpQuery])
                -> orFilterWhere(['like','full_descr',$inpQuery])
//                только своя компания:
                ->andFilterWhere(['requests.company_id' => Yii::$app->user->identity->company_id])
                -> limit(100)->all(),
            'pagination'=>[
                'pageSize'=>7,
            ],
        ]);
        return $dataProvider;
    }

    public function rules(){
        return [
            ['query','trim']
        ];
    }
    public function attributeLabels()
    {
        return [

            'sb_id' => 'ID Сбербанка',
            'status' => 'Статус',
            'descr' => 'Тема',
            'workgroup_id' => 'Рабочая группа',
            'assignee' => 'Исполнитель',
            'date_created' => 'Дата создания',
            'date_updated' => 'Дата обновления',
            'date_deadline' => 'Контрольный срок',

        ];
    }

    public function getStatuses()
    {
        return $this->hasOne(Statuses::className(),['id' => 'status']);
    }

    public function getWorkgroups()
    {
        return $this->hasOne(Workgroups::className(), ['id' => 'workgroup_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'assignee']);
    }
}