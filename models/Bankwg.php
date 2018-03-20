<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bankwg".
 *
 * @property integer $id
 * @property string $wg_name
 */
class Bankwg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bankwg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wg_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wg_name' => 'РГ в банке',
        ];
    }
}
