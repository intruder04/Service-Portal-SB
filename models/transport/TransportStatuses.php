<?php

namespace app\models\transport;

use Yii;

/**
 * This is the model class for table "transport_statuses".
 *
 * @property integer $id
 * @property string $status
 */
class TransportStatuses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transport_statuses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'required'],
            [['id'], 'integer'],
            [['status'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Статус',
        ];
    }
}
