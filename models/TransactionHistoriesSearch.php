<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TransactionHistories;

/**
 * TransactionHistoriesSearch represents the model behind the search form of `app\models\TransactionHistories`.
 */
class TransactionHistoriesSearch extends TransactionHistories
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'mpesa_payment_id', 'reference_name', 'reference_phone', 'reference_code', 'station_id', 'station_show_id', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['amount', 'commission'], 'number'],
            [['status', 'is_archived'], 'integer'],
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
        $query = TransactionHistories::find();

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
            'commission' => $this->commission,
            'status' => $this->status,
            'is_archived' => $this->is_archived,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'mpesa_payment_id', $this->mpesa_payment_id])
            ->andFilterWhere(['like', 'reference_name', $this->reference_name])
            ->andFilterWhere(['like', 'reference_phone', $this->reference_phone])
            ->andFilterWhere(['like', 'reference_code', $this->reference_code])
            ->andFilterWhere(['like', 'station_id', $this->station_id])
            ->andFilterWhere(['like', 'station_show_id', $this->station_show_id]);

        return $dataProvider;
    }
}
