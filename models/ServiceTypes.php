<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "service_types".
 *
 * @property integer $id
 * @property string $service_name
 */
class ServiceTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_name'], 'required'],
            [['service_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service_name' => 'Название услуги',
        ];
    }
}
