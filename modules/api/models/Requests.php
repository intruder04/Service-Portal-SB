<?php

namespace app\modules\api\models;

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
 * @property integer $closure_code
 * @property integer $date_created
 * @property integer $date_created_sber
 * @property integer $date_updated
 * @property integer $date_done
 * @property integer $date_deadline
 * @property integer $date_desired
 * @property string $sberwg
 * @property string $sberassignee
 * @property string $assignee
 * @property integer $company_id
 * @property integer $workgroup_id
 * @property string $bank_contact
 * @property string $bank_contact_phone
 *
 * @property ClosureStatuses $closureCode
 * @property Company $company
 * @property Statuses $status0
 * @property Workgroups $workgroup
 */
class Requests extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'requests';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sb_id', 'descr', 'full_descr', 'solution'], 'required'],
            [['status', 'closure_code', 'date_created', 'date_created_sber', 'date_updated', 'date_done', 'date_deadline', 'date_desired', 'company_id', 'workgroup_id'], 'integer'],
            [['full_descr', 'solution'], 'string'],
            [['sb_id'], 'string', 'max' => 50],
            [['descr', 'sberwg', 'sberassignee', 'assignee', 'bank_contact', 'bank_contact_phone'], 'string', 'max' => 255],
            [['closure_code'], 'exist', 'skipOnError' => true, 'targetClass' => ClosureStatuses::className(), 'targetAttribute' => ['closure_code' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => Statuses::className(), 'targetAttribute' => ['status' => 'id']],
            [['workgroup_id'], 'exist', 'skipOnError' => true, 'targetClass' => Workgroups::className(), 'targetAttribute' => ['workgroup_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sb_id' => 'Sb ID',
            'status' => 'Status',
            'descr' => 'Descr',
            'full_descr' => 'Full Descr',
            'solution' => 'Solution',
            'closure_code' => 'Closure Code',
            'date_created' => 'Date Created',
            'date_created_sber' => 'Date Created Sber',
            'date_updated' => 'Date Updated',
            'date_done' => 'Date Done',
            'date_deadline' => 'Date Deadline',
            'date_desired' => 'Date Desired',
            'sberwg' => 'Sberwg',
            'sberassignee' => 'Sberassignee',
            'assignee' => 'Assignee',
            'company_id' => 'Company ID',
            'workgroup_id' => 'Workgroup ID',
            'bank_contact' => 'Bank Contact',
            'bank_contact_phone' => 'Bank Contact Phone',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClosureCode()
    {
        return $this->hasOne(ClosureStatuses::className(), ['id' => 'closure_code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(Statuses::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkgroup()
    {
        return $this->hasOne(Workgroups::className(), ['id' => 'workgroup_id']);
    }
}
