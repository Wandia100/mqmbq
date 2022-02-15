<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PlayerTrend;

/**
 * PlayerTrendSearch represents the model behind the search form of `app\models\PlayerTrend`.
 */
class PlayerTrendSearch extends PlayerTrend
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'frequency'], 'integer'],
            [['msisdn', 'hour','station', 'hour_date', 'unique_field', 'created_at','station_id'], 'safe'],
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
        $query = PlayerTrend::find();

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
            'msisdn' => $this->msisdn,
            'hour' => $this->hour,
            'station' => $this->station,
            'frequency' => $this->frequency,
            'hour_date' => $this->hour_date,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'msisdn', $this->msisdn])
            ->andFilterWhere(['like', 'hour', $this->hour])
            ->andFilterWhere(['like', 'station', $this->station])
            ->andFilterWhere(['like', 'unique_field', $this->unique_field]);
        $today     = date( 'Y-m-d' );
        $yesterday = date( 'Y-m-d', strtotime( '-1 day' ) );
        if ( $daily ) {
                $query->andWhere( "DATE(hour_date)>= DATE('" . $yesterday . "')" );
                $query->andWhere( "DATE(hour_date)<= DATE('" . $today . "')" );
        }
        if ( $monthly ) {
                $query->andWhere( "MONTH(hour_date)= MONTH(CURDATE())" );
                $query->andWhere( "YEAR(hour_date)= YEAR(CURDATE())" );
        }
        if ( $from != null && $to != null ) {
                $query->andWhere( "DATE(hour_date)>= DATE('" . $from . "')" );
                $query->andWhere( "DATE(hour_date)<= DATE('" . $to . "')" );
        }
        $session = \Yii::$app->session;
        if($session->get('isstationmanager')){
           $query->where(['IN','station_id', \Yii::$app->myhelper->getStations()]); 
        }
        $query->orderBy('hour_date,frequency DESC');
        return $dataProvider;
    }
}
