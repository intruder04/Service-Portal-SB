<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usertowg".
 *
 * @property integer $id
 * @property integer $wg_id
 * @property integer $username_id
 *
 * @property Workgroups $wg
 * @property User $username
 */
class Usertowg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usertowg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wg_id', 'username_id'], 'required'],
            [['wg_id', 'username_id'], 'string'],
//            [['wg_id'], 'exist', 'skipOnError' => true, 'targetClass' => Workgroups::className(), 'targetAttribute' => ['wg_id' => 'id']],
//            [['username_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['username_id' => 'id']],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wg_id' => 'РГ',
            'username_id' => 'Логин',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWg()
    {
        return $this->hasOne(Workgroups::className(), ['id' => 'wg_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsername()
    {
        return $this->hasMany(User::className(), ['id' => 'username_id']);
    }
}
