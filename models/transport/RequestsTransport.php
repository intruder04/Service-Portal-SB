<?php

namespace app\models\transport;

use app\models\Company;
use app\models\User;
use app\models\Workgroups;
use Yii;

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
class RequestsTransport extends \yii\db\ActiveRecord
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
//            ['closure_code', 'required', 'when' => function ($model) {
//                return $model->status > '4';
//                     }, 'whenClient' => "function (attribute, value) {
//                     return $('#requeststransport-status').val() > '4'; }"],
//            ['solution', 'required', 'when' => function ($model) {
//                return $model->status > '4';
//                     }, 'whenClient' => "function (attribute, value) {
//                    return $('#requeststransport-status').val() > '4'; }"],
            [['status','closure_code','workgroup_id'], 'integer'],
            [['full_descr', 'solution'], 'string'],
            [['date_created', 'date_updated', 'date_done','date_created_sber','date_deadline','date_desired','driver_id', 'solution' , 'closure_code','assignee','ride_end_time','ride_duration','ride_idle_time','ride_distance','ride_price'], 'safe'],
            [['sb_id'], 'string', 'max' => 50],
//            ['assignee', 'required', 'when' => function ($model) {
//                return ($model->assignee == '' && ($model->status > '2'));
//                }, 'whenClient' => "function (attribute, value) {
//                    return $('#requeststransport-assignee').val() == '' && $('#requeststransport-status').val() > '2'; }"],
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
            'travel_from' => 'Пункт отправления',
            'travel_to' => 'Пункт назначения',
            'ride_stops' => 'Промежуточные пункты',
            'ride_start_time' => 'Время начала поездки',
            'ride_end_time' => 'Время завершения поездки',
            'driver_id' => 'Водитель',
            'ride_duration' => 'Длительность поездки',
            'ride_idle_time' => 'Время простоя',
            'ride_distance' => 'Пробег',
            'ride_price' => 'Цена',

        ];
    }

    public function getWorkgroups()
    {
        return $this->hasOne(Workgroups::className(), ['id' => 'workgroup_id']);
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
