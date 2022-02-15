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
    public $stationname;
    public $stationshowname;
    public $stationshowprizeamount;
    public $prizename;
    public $presenter;
    
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'prize_id', 'station_show_prize_id', 'reference_name', 'reference_phone', 'reference_code', 'station_id', 'presenter_id', 'station_show_id', 'conversation_id', 'transaction_reference', 'remember_token', 'created_at', 'updated_at', 'deleted_at','stationname','stationshowname','stationshowprizeamount','prizename','presenter'], 'safe'],
            [['amount', 'transaction_cost'], 'number'],
            [['status','notified'], 'integer'],
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
    public function search($params, $daily = false, $monthly = false, $from = null, $to = null,$src = '')
    {
        $route= isset($_GET['route'])?$_GET['route']:null;
        $query = WinningHistories::find();

        // add conditions that should always apply here
        if($src == 1){
             $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 5, 
                ],
            ]);
            $dataProvider->setTotalCount(5);
        }else{
             $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
        }
        $query->joinWith(['stations']);
        $query->joinWith(['stationshows']);
        $query->joinWith(['prizes']);
        $query->joinWith(['stationshowprize']);
        $query->joinWith(['presenter']);
        
        $dataProvider->sort->attributes['stationname'] = [
            'asc'  => [ 'stations.name' => SORT_ASC ],
            'desc' => [ 'stations.name' => SORT_DESC ],
        ];

         $dataProvider->sort->attributes['stationshowname'] = [
            'asc'  => [ 'station_shows.name' => SORT_ASC ],
            'desc' => [ 'station_shows.name' => SORT_DESC ],
        ];
          $dataProvider->sort->attributes['stationshowprizeamount'] = [
            'asc'  => [ 'station_show_prizes.amount' => SORT_ASC ],
            'desc' => [ 'station_show_prizes.amount' => SORT_DESC ],
        ];
           $dataProvider->sort->attributes['prizename'] = [
            'asc'  => [ 'prizes.name' => SORT_ASC ],
            'desc' => [ 'prizes.name' => SORT_DESC ],
        ];
            $dataProvider->sort->attributes['presenter'] = [
            'asc'  => [ 'users.first_name' => SORT_ASC ],
            'desc' => [ 'users.first_name' => SORT_DESC ],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'winning_histories.amount' => $this->amount,
            'transaction_cost' => $this->transaction_cost,
            'status' => $this->status,
            'notified' => $this->notified,
            //'winning_histories.created_at' => $this->created_at,
            'winning_histories.updated_at' => $this->updated_at,
            'winning_histories.deleted_at' => $this->deleted_at,
        ]);

        $query->andFilterWhere(['like', 'winning_histories.id', $this->id])
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
            ->andFilterWhere(['like', 'remember_token', $this->remember_token])
            ->andFilterWhere(['like', 'stations.name', $this->stationname])
            ->andFilterWhere(['like', 'station_shows.name', $this->stationshowname])
            ->andFilterWhere(['like', 'prizes.name', $this->prizename])
            ->andFilterWhere(['like', 'winning_histories.created_at', $this->created_at])
            ->andFilterWhere(['like', 'station_show_prizes.amount', $this->stationshowprizeamount]);
            if(!empty( $this->presenter)){
                $query->andWhere('users.first_name LIKE "%'.trim($this->presenter). '%" ' .
                'OR users.last_name LIKE "%'.trim($this->presenter). '%"');
            }
            
            if($route == 2){
               # $query->andWhere(['IN','prizes.id', \Yii::$app->params['noncashitems']]);
                 $query->andWhere("notified != 2");
            }

        $today     = date( 'Y-m-d' );
        $yesterday = date( 'Y-m-d', strtotime( '-1 day' ) );
        if ( $daily ) {
                $query->andWhere( "DATE(winning_histories.created_at)>= DATE('" . $yesterday . "')" );
                $query->andWhere( "DATE(winning_histories.created_at)<= DATE('" . $today . "')" );
        }
        if ( $monthly ) {
                $query->andWhere( "MONTH(winning_histories.created_at)= MONTH(CURDATE())" );
                $query->andWhere( "YEAR(winning_histories.created_at)= YEAR(CURDATE())" );
        }
        if ( $from != null && $to != null ) {
                $query->andWhere( "DATE(winning_histories.created_at)>= DATE('" . $from . "')" );
                $query->andWhere( "DATE(winning_histories.created_at)<= DATE('" . $to . "')" );
        }
        $session = \Yii::$app->session;
        if($session->get('isstationmanager')){
           $query->where(['IN','winning_histories.station_id', \Yii::$app->myhelper->getStations()]); 
        }
        $query->orderBy('winning_histories.created_at DESC');
        
        return $dataProvider;
    }
}
