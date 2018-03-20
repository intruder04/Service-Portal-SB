<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property integer $id
 * @property string $companyname
 * @property string $contact
 * @property string $coordinator
 * @property string $assignee_sber
 *
 * @property Requests[] $requests
 * @property User[] $users
 * @property Users[] $users0
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['companyname','assignee_sber','service_type'], 'required'],
            [['companyname'], 'string', 'max' => 300],
            [['contact', 'coordinator', 'assignee_sber','service_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'companyname' => 'Название компании',
            'contact' => 'Контакт',
            'coordinator' => 'Координатор',
            'assignee_sber' => 'Исполнитель в банке',
            'service_type' => 'Тип услуг'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getRequests()
//    {
//        return $this->hasMany(Requests::className(), ['company_id' => 'id']);
//    }

    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getUsers()
//    {
//        return $this->hasMany(User::className(), ['company_id' => 'id']);
//    }

    /*Связь с Companytowg*/
    public function getCompanytowg()
    {
        return $this->hasMany(Companytowg::className(),['company_id'=>'id']);
    }


}
