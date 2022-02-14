<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Commissions;

/**
 * CommissionsSearch represents the model behind the search form of `app\models\Commissions`.
 */
class CommissionsSearch extends Commissions
{
    public $stationname;
    public $stationshowname;
    public $user;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'station_id', 'station_show_id', 'transaction_reference', 'created_at', 'updated_at', 'deleted_at','stationname','stationshowname','user'], 'safe'],
            [['amount', 'transaction_cost'], 'number'],
            [['status','c_type'], 'integer'],
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
        $t = isset($_GET['t']) && $_GET['t'] == 'p'?3:4;
        $query = Commissions::find();

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
            'amount' => $this->amount,
            'transaction_cost' => $this->transaction_cost,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ]);

        $query->andFilterWhere(['like', 'commissions.id', $this->id])
            ->andFilterWhere(['like', 'station_id', $this->station_id])
            ->andFilterWhere(['like', 'station_show_id', $this->station_show_id])
            ->andFilterWhere(['like', 'transaction_reference', $this->transaction_reference])
            ->andFilterWhere(['like', 'stations.name', $this->stationname])
            ->andFilterWhere(['like', 'station_shows.name', $this->stationshowname]);
        $today     = date( 'Y-m-d' );
        $yesterday = date( 'Y-m-d', strtotime( '-1 day' ) );
        if ( $daily ) {
                $query->andWhere( "DATE(commissions.created_at)>= DATE('" . $yesterday . "')" );
                $query->andWhere( "DATE(commissions.created_at)<= DATE('" . $today . "')" );
        }
        if ( $monthly ) {
                $query->andWhere( "MONTH(commissions.created_at)= MONTH(CURDATE())" );
                $query->andWhere( "YEAR(commissions.created_at)= YEAR(CURDATE())" );
        }
        if ( $from != null && $to != null ) {
                $query->andWhere( "DATE(commissions.created_at)>= DATE('" . $from . "')" );
                $query->andWhere( "DATE(commissions.created_at)<= DATE('" . $to . "')" );
        }
        $query ->where("c_type = '$t'");
        $session = \Yii::$app->session;
        if($session->get('isstationmanager')){
           $query->where(['IN','commissions.station_id', \Yii::$app->myhelper->getStations()]); 
        }
        $query->orderBy('commissions.created_at DESC');
        return $dataProvider;
    }
}
