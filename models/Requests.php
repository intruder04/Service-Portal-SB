<?php

namespace app\models;

use app\models\transport\TransportStatuses;
use Yii;
use app\models\transport\TransportDriver;

/**
 * This is the model class for table "requests".
 *
 * @property integer $id
 * @property string $sb_id
 * @property integer $status
 * @property string $descr
 * @property string $full_descr
 * @property string $solution
 * @property integer $date_created
 * @property integer $date_updated
 * @property integer $date_done
 * @property string $work_group
 * @property string $assignee
 */
class Requests extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

//    api scenario
const SCENARIO_CREATE = 'create';


    public static function tableName()
    {
        return 'requests';
    }

    public function getRole()
    {
        return key(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()));
    }

    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    public function getDisplayname()
    {
        return $this->hasOne(User::className(), ['id' => 'company_id']);
    }

    public function rules()
    {
        return [
            [['sb_id', 'descr', 'full_descr'], 'required'],
            ['closure_code', 'required', 'when' => function ($model) {
                return $model->status > '3';
                     }, 'whenClient' => "function (attribute, value) {
                     return $('#requests-status').val() > '3'; }"],
            ['solution', 'required', 'when' => function ($model) {
                return $model->status > '3';
                     }, 'whenClient' => "function (attribute, value) {
                    return $('#requests-status').val() > '3'; }"],
            [['status','closure_code','workgroup_id'], 'integer'],
            [['full_descr', 'solution'], 'string'],
            [['date_created', 'date_updated', 'date_done','date_created_sber','date_deadline','date_desired','driver_id','ride_start_time','ride_end_time','ride_duration','ride_idle_time','ride_distance','ride_price'], 'safe'],
            [['sb_id'], 'string', 'max' => 50],
            ['assignee', 'required', 'when' => function ($model) {
                return ($model->assignee == '' && ($model->status > '2'));
                }, 'whenClient' => "function (attribute, value) {
                    return $('#requests-assignee').val() == '' && $('#requests-status').val() > '2'; }"],
            [['descr','bank_contact','bank_contact_phone'], 'string', 'max' => 255],
        ];
    }

    public function scenarios(){
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['sb_id', 'descr'];
        return $scenarios;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sb_id' => 'ID Сбербанка',
            'status' => 'Статус',
            'descr' => 'Тема',
            'full_descr' => 'Описание',
            'solution' => 'Решение',
            'date_created' => 'Дата создания',
            'date_updated' => 'Дата обновления',
            'date_deadline' => 'Контрольный срок',
            'date_done' => 'Дата выполнения',
            'workgroup_id' => 'Рабочая группа',
            'assignee' => 'Исполнитель',
            'closure_code' => 'Код закрытия',
            'bank_contact' => 'Обратился',
            'bank_contact_phone' => 'Телефон обратившегося',
            'company_id' => 'Компания',

        ];
    }

    public function getWorkgroups()
    {
        return $this->hasOne(Workgroups::className(), ['id' => 'workgroup_id']);
    }

    public function getStatusJoin()
    {
        return $this->hasOne(Statuses::className(),['id' => 'status']);
    }

    //    Связи для транспорта
    public function getDriver()
    {
        return $this->hasOne(TransportDriver::className(), ['id' => 'driver_id']);
    }

    public function getTransportStatus()
    {
        return $this->hasOne(TransportStatuses::className(), ['id' => 'status']);
    }

}
