<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StationShows;

/**
 * StationShowsSearch represents the model behind the search form of `app\models\StationShows`.
 */
class StationShowsSearch extends StationShows
{
    public $stationname;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'station_id', 'name', 'description', 'show_code', 'start_time', 'end_time', 'created_at', 'updated_at', 'deleted_at', 'stationname'], 'safe'],
            [['target', 'invalid_percentage'], 'number'],
            [['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday', 'enabled'], 'integer'],
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
        $query = StationShows::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $query->joinWith(['stations']);
        
        $dataProvider->sort->attributes['stationname'] = [
            'asc'  => [ 'stations.name' => SORT_ASC ],
            'desc' => [ 'stations.name' => SORT_DESC ],
        ];
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'target' => $this->target,
            'invalid_percentage' => $this->invalid_percentage,
            'monday' => $this->monday,
            'tuesday' => $this->tuesday,
            'wednesday' => $this->wednesday,
            'thursday' => $this->thursday,
            'friday' => $this->friday,
            'saturday' => $this->saturday,
            'sunday' => $this->sunday,
            'enabled' => $this->enabled,
            'station_shows.created_at' => $this->created_at,
            'station_shows.updated_at' => $this->updated_at,
            'station_shows.deleted_at' => $this->deleted_at,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'station_id', $this->station_id])
            ->andFilterWhere(['like', 'station_shows.name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'show_code', $this->show_code])
            ->andFilterWhere(['like', 'start_time', $this->start_time])
            ->andFilterWhere(['like', 'end_time', $this->end_time])
            ->andFilterWhere(['like', 'stations.name', $this->stationname]);
        if(\Yii::$app->myhelper->isStationManager()){
           $query->where(['IN','station_id', \Yii::$app->myhelper->getStations()]); 
        }
        $query->orderBy('created_at DESC');
        return $dataProvider;
    }
}
