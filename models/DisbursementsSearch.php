<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Disbursements;

/**
 * DisbursementsSearch represents the model behind the search form of `app\models\Disbursements`.
 */
class DisbursementsSearch extends Disbursements
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'reference_id', 'reference_name', 'phone_number', 'conversation_id', 'disbursement_type', 'transaction_reference', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['amount'], 'number'],
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
        $query = Disbursements::find();

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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'reference_id', $this->reference_id])
            ->andFilterWhere(['like', 'reference_name', $this->reference_name])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'conversation_id', $this->conversation_id])
            ->andFilterWhere(['like', 'disbursement_type', $this->disbursement_type])
            ->andFilterWhere(['like', 'transaction_reference', $this->transaction_reference]);

        return $dataProvider;
    }
}
