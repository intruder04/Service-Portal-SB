<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;


class CompanytowgSearch extends Companytowg
{

    public function rules()
    {
        return [
            [['id', 'company_id', 'bank_wg_id', 'wg_id'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Companytowg::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        /*Джойним связанные таблицы*/
        $query->joinWith(['company','bankWg','wg']);
        /*Устанавливаем выборку*/
        $query->andFilterWhere(['like', 'companyname', $this->company_id]);
        $query->andFilterWhere(['like', 'bankwg.wg_name', $this->bank_wg_id]);
        $query->andFilterWhere(['like', 'workgroups.wg_name', $this->wg_id]);

        return $dataProvider;
    }
}
