<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "closure_statuses".
 *
 * @property integer $id
 * @property string $closure_code_name
 *
 * @property Requests[] $requests
 */
class ClosureStatuses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'closure_statuses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['closure_code_name'], 'required'],
            [['closure_code_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'closure_code_name' => 'Closure Code Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Requests::className(), ['closure_code' => 'id']);
    }
}
