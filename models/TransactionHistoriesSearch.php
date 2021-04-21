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
    public $stationname;
    public $stationshowname;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'mpesa_payment_id', 'reference_name', 'reference_phone', 'reference_code', 'station_id', 'station_show_id', 'created_at', 'updated_at', 'deleted_at','stationname','stationshowname'], 'safe'],
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
    public function search($params, $daily = false, $monthly = false, $from = null, $to = null)
    {
        $query = TransactionHistories::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        
        $query->joinWith(['stations']);
        $query->joinWith(['stationshows']);
        
        $dataProvider->sort->attributes['stationname'] = [
            'asc'  => [ 'station.name' => SORT_ASC ],
            'desc' => [ 'station.name' => SORT_DESC ],
        ];

         $dataProvider->sort->attributes['stationshowname'] = [
            'asc'  => [ 'station_shows.name' => SORT_ASC ],
            'desc' => [ 'station_shows.name' => SORT_DESC ],
        ];
         
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'transaction_histories.amount' => $this->amount,
            'status' => $this->status,
            //'transaction_histories.created_at' => $this->created_at,
            'transaction_histories.updated_at' => $this->updated_at,
            'transaction_histories.deleted_at' => $this->deleted_at,
        ]);

        $query->andFilterWhere(['like', 'transaction_histories.id', $this->id])
            ->andFilterWhere(['like', 'mpesa_payment_id', $this->mpesa_payment_id])
            ->andFilterWhere(['like', 'reference_name', $this->reference_name])
            ->andFilterWhere(['like', 'reference_phone', $this->reference_phone])
            ->andFilterWhere(['like', 'reference_code', $this->reference_code])
            ->andFilterWhere(['like', 'station_id', $this->station_id])
            ->andFilterWhere(['like', 'transaction_histories.created_at', $this->created_at])
            ->andFilterWhere(['like', 'station_show_id', $this->station_show_id])
            ->andFilterWhere(['like', 'stations.name', $this->stationname])
            ->andFilterWhere(['like', 'station_shows.name', $this->stationshowname]);
        $today     = date( 'Y-m-d' );
        $yesterday = date( 'Y-m-d', strtotime( '-1 day' ) );
        if ( $daily ) {
                $query->andWhere( "DATE(transaction_histories.created_at)>= DATE('" . $yesterday . "')" );
                $query->andWhere( "DATE(transaction_histories.created_at)<= DATE('" . $today . "')" );
        }
        if ( $monthly ) {
                $query->andWhere( "MONTH(transaction_histories.created_at)= MONTH(CURDATE())" );
                $query->andWhere( "YEAR(transaction_histories.created_at)= YEAR(CURDATE())" );
        }
        if ( $from != null && $to != null ) {
            #$query->andWhere( "DATE(transaction_histories.created_at)>= DATE('" . $from . "')" );
            #$query->andWhere( "DATE(transaction_histories.created_at)<= DATE('" . $to . "')" );
            $query->andWhere( "transaction_histories.created_at >= '$from'" );
            $query->andWhere( "transaction_histories.created_at <= '$to'" );
        }
        $query->orderBy('transaction_histories.created_at DESC');
        return $dataProvider;
    }
}
