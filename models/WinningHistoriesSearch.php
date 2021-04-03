<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WinningHistories;

/**
 * WinningHistoriesSearch represents the model behind the search form of `app\models\WinningHistories`.
 */
class WinningHistoriesSearch extends WinningHistories
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'prize_id', 'station_show_prize_id', 'reference_name', 'reference_phone', 'reference_code', 'station_id', 'presenter_id', 'station_show_id', 'conversation_id', 'transaction_reference', 'remember_token', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['amount', 'transaction_cost'], 'number'],
            [['status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = WinningHistories::find();

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
            'amount' => $this->amount,
            'transaction_cost' => $this->transaction_cost,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'prize_id', $this->prize_id])
            ->andFilterWhere(['like', 'station_show_prize_id', $this->station_show_prize_id])
            ->andFilterWhere(['like', 'reference_name', $this->reference_name])
            ->andFilterWhere(['like', 'reference_phone', $this->reference_phone])
            ->andFilterWhere(['like', 'reference_code', $this->reference_code])
            ->andFilterWhere(['like', 'station_id', $this->station_id])
            ->andFilterWhere(['like', 'presenter_id', $this->presenter_id])
            ->andFilterWhere(['like', 'station_show_id', $this->station_show_id])
            ->andFilterWhere(['like', 'conversation_id', $this->conversation_id])
            ->andFilterWhere(['like', 'transaction_reference', $this->transaction_reference])
            ->andFilterWhere(['like', 'remember_token', $this->remember_token]);

        return $dataProvider;
    }
}
