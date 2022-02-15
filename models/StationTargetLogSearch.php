<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StationTarget;

/**
 * StationTargetSearch represents the model behind the search form of `app\models\StationTarget`.
 */
class StationTargetLogSearch extends StationTargetLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'target','achieved','diff'], 'integer'],
            [['start_time', 'end_time', 'station_id', 'unique_field','station_name','range_date','station_target_id'], 'safe'],
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
        $query = StationTargetLog::find();

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
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'target' => $this->target,
            'station_name' => $this->station_name,
            'range_date' => $this->range_date,
            'station_target_id' => $this->station_target_id,
            'achieved' => $this->achieved,
            'diff' => $this->diff,
        ]);

        $query->andFilterWhere(['like', 'station_id', $this->station_id])
            ->andFilterWhere(['like', 'unique_field', $this->unique_field]);
        $today     = date( 'Y-m-d' );
        $yesterday = date( 'Y-m-d', strtotime( '-1 day' ) );
        if ( $daily ) {
                $query->andWhere( "DATE(range_date)>= DATE('" . $yesterday . "')" );
                $query->andWhere( "DATE(range_date)<= DATE('" . $today . "')" );
        }
        if ( $monthly ) {
                $query->andWhere( "MONTH(range_date)= MONTH(CURDATE())" );
                $query->andWhere( "YEAR(range_date)= YEAR(CURDATE())" );
        }
        if ( $from != null && $to != null ) {
                $query->andWhere( "DATE(range_date)>= DATE('" . $from . "')" );
                $query->andWhere( "DATE(range_date)<= DATE('" . $to . "')" );
        }
        $session = \Yii::$app->session;
        if($session->get('isstationmanager')){
           $query->where(['IN','station_id', \Yii::$app->myhelper->getStations()]); 
        }
        $query->orderBy('range_date DESC');

        return $dataProvider;
    }
}
