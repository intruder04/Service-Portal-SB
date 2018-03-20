<?php
/**
 * Created by PhpStorm.
 * User: Note
 * Date: 16.08.2017
 * Time: 9:05
 */

namespace app\models;


use Faker\Provider\DateTime;
use yii\db\ActiveRecord;

class NewOrder extends ActiveRecord
{
    public static function tableName()
    {
        return 'requests';
    }

    public function searchNewOrder()
    {
        $outData=array();
        $newOrder = NewOrder::find()->asArray()->distinct()->where(['between','date_created',time()-60,time()])->all();

        foreach ($newOrder as $order) {
            $outData[] = $order['sb_id'];
        }
        return $outData;
    }
}