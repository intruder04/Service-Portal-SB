<?php

namespace app\models\transport;

use app\models\Company;
use Yii;

/**
 * This is the model class for table "transport_cars".
 *
 * @property integer $id
 * @property string $vehicle_brand
 * @property string $vehicle_id_number
 * @property string $vehicle_color
 *
 * @property TransportDriver[] $transportDrivers
 */
class TransportCar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transport_cars';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['company_id', 'integer'],
            [['vehicle_brand'], 'string', 'max' => 200],
            [['vehicle_id_number', 'vehicle_color'], 'string', 'max' => 255],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vehicle_brand' => 'Марка',
            'vehicle_id_number' => 'Госномер',
            'vehicle_color' => 'Цвет',
            'company_id' => 'Компания',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransportDrivers()
    {
        return $this->hasMany(TransportDriver::className(), ['car_id' => 'id']);
    }
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
}
