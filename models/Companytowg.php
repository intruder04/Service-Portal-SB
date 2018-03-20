<?php

namespace app\models;

use Yii;

class Companytowg extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'companytowg';
    }

    public function rules()
    {
        return [
            [['company_id', 'bank_wg_id', 'wg_id'], 'required'],
//            [['company_id', 'bank_wg_id', 'wg_id'], 'integer'],
            [['bank_wg_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bankwg::className(), 'targetAttribute' => ['bank_wg_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['wg_id'], 'exist', 'skipOnError' => true, 'targetClass' => Workgroups::className(), 'targetAttribute' => ['wg_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Компания',
            'bank_wg_id' => 'РГ в банке',
            'wg_id' => 'РГ на портале',
        ];
    }

    public function getBankWg()
    {
        return $this->hasOne(Bankwg::className(), ['id' => 'bank_wg_id']);
    }

    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    public function getWg()
    {
        return $this->hasOne(Workgroups::className(), ['id' => 'wg_id']);
    }


}
