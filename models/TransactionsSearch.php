<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Transactions;

/**
 * TransactionsSearch represents the model behind the search form of `app\models\Transactions`.
 */
class TransactionsSearch extends Transactions
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'category_id', 'category_item_id', 'name', 'description', 'item_code', 'mode_payment', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['amount'], 'number'],
            [['quantity'], 'integer'],
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
    public function search($params, $daily = false, $monthly = false, $from = null, $to = null)
    {
        $query = Transactions::find();

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
            'quantity' => $this->quantity,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'category_id', $this->category_id])
            ->andFilterWhere(['like', 'category_item_id', $this->category_item_id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'item_code', $this->item_code])
            ->andFilterWhere(['like', 'mode_payment', $this->mode_payment]);

            $today     = date( 'Y-m-d' );
            $yesterday = date( 'Y-m-d', strtotime( '-1 day' ) );
            if ( $daily ) {
                    $query->andWhere( "DATE(transactions.created_at)>= DATE('" . $yesterday . "')" );
                    $query->andWhere( "DATE(transactions.created_at)<= DATE('" . $today . "')" );
            }
            if ( $monthly ) {
                    $query->andWhere( "MONTH(transactions.created_at)= MONTH(CURDATE())" );
                    $query->andWhere( "YEAR(transactions.created_at)= YEAR(CURDATE())" );
            }
            if ( $from != null && $to != null ) {
                #$query->andWhere( "DATE(transactions.created_at)>= DATE('" . $from . "')" );
                #$query->andWhere( "DATE(transactions.created_at)<= DATE('" . $to . "')" );
                $query->andWhere( "transactions.created_at >= '$from'" );
                $query->andWhere( "transactions.created_at <= '$to'" );
            }
            $query->orderBy('transactions.created_at DESC');
            return $dataProvider;

    }
}
