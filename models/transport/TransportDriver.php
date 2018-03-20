<?php

namespace app\models\transport;

use app\models\Company;
use app\models\Statuses;
use Yii;

/**
 * This is the model class for table "transport_drivers".
 *
 * @property integer $id
 * @property string $driver_fullname
 * @property string $driver_phone
 * @property integer $status
 * @property integer $car_id
 * @property integer $company_id
 * @property integer $sber_workgroup_id
 *
 * @property Requests[] $requests
 * @property TransportCar $car
 */
class TransportDriver extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transport_drivers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'car_id', 'company_id', 'sber_workgroup_id'], 'integer'],
            [['driver_fullname', 'driver_phone'], 'string', 'max' => 255],
            [['car_id'], 'exist', 'skipOnError' => true, 'targetClass' => TransportCar::className(), 'targetAttribute' => ['car_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'driver_fullname' => 'ФИО',
            'driver_phone' => 'Телефон',
            'status' => 'Статус',
            'car_id' => 'Госномер авто',
            'company_id' => 'Компания',
            'sber_workgroup_id' => 'Sber Workgroup ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCar()
    {
        return $this->hasOne(TransportCar::className(), ['id' => 'car_id']);
    }

    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
}
