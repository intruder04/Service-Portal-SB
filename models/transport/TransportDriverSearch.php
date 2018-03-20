<?php

namespace app\models\transport;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\transport\TransportDriver;

/**
 * TransportDriverSearch represents the model behind the search form about `app\models\transport\TransportDriver`.
 */
class TransportDriverSearch extends TransportDriver
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'car_id'], 'integer'],
            [['driver_fullname', 'driver_phone', 'company_id', 'sber_workgroup_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TransportDriver::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith(['company']);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'car_id' => $this->car_id,
            'company_id' => $this->company_id,
            'sber_workgroup_id' => $this->sber_workgroup_id,
        ]);

        $query->andFilterWhere(['like', 'driver_fullname', $this->driver_fullname])
            ->andFilterWhere(['like', 'driver_phone', $this->driver_phone])
            ->andFilterWhere(['like', 'companyname', $this->company_id]);

        return $dataProvider;
    }
}
