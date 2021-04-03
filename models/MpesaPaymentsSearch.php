<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MpesaPayments;

/**
 * MpesaPaymentsSearch represents the model behind the search form of `app\models\MpesaPayments`.
 */
class MpesaPaymentsSearch extends MpesaPayments
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'TransID', 'FirstName', 'MiddleName', 'LastName', 'MSISDN', 'InvoiceNumber', 'BusinessShortCode', 'ThirdPartyTransID', 'TransactionType', 'OrgAccountBalance', 'BillRefNumber', 'TransAmount', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['is_archived'], 'integer'],
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
        $query = MpesaPayments::find();

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
            'is_archived' => $this->is_archived,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'TransID', $this->TransID])
            ->andFilterWhere(['like', 'FirstName', $this->FirstName])
            ->andFilterWhere(['like', 'MiddleName', $this->MiddleName])
            ->andFilterWhere(['like', 'LastName', $this->LastName])
            ->andFilterWhere(['like', 'MSISDN', $this->MSISDN])
            ->andFilterWhere(['like', 'InvoiceNumber', $this->InvoiceNumber])
            ->andFilterWhere(['like', 'BusinessShortCode', $this->BusinessShortCode])
            ->andFilterWhere(['like', 'ThirdPartyTransID', $this->ThirdPartyTransID])
            ->andFilterWhere(['like', 'TransactionType', $this->TransactionType])
            ->andFilterWhere(['like', 'OrgAccountBalance', $this->OrgAccountBalance])
            ->andFilterWhere(['like', 'BillRefNumber', $this->BillRefNumber])
            ->andFilterWhere(['like', 'TransAmount', $this->TransAmount])
            ->andFilterWhere(['like', 'deleted_at', $this->deleted_at]);

        return $dataProvider;
    }
}
