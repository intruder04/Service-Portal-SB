<?php

namespace app\models\transport;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\transport\TransportCar;

/**
 * TransportCarSearch represents the model behind the search form about `app\models\transport\TransportCar`.
 */
class TransportCarSearch extends TransportCar
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['vehicle_brand', 'vehicle_id_number', 'vehicle_color', 'company_id'], 'safe'],
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
        $query = TransportCar::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'vehicle_brand', $this->vehicle_brand])
            ->andFilterWhere(['like', 'vehicle_id_number', $this->vehicle_id_number])
            ->andFilterWhere(['like', 'vehicle_color', $this->vehicle_color])
            ->andFilterWhere(['like', 'company_id', $this->company_id]);

        return $dataProvider;
    }
}
