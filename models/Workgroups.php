<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "workgroups".
 *
 * @property integer $id
 * @property string $wg_name
 * @property integer $company_id
 * @property string $wg_name_sber
 *
 * @property User[] $users
 */
class Workgroups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'workgroups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wg_name'], 'required'],
            [['wg_name'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wg_name' => 'РГ',
            'company_id' => 'Компания'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
    public function getRequests()
    {
        return $this->hasMany(Requests::className(),['workgroup_id' => 'id']);
    }
}
