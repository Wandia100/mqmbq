<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StationManagementStations;

/**
 * StationManagementStationsSearch represents the model behind the search form of `app\models\StationManagementStations`.
 */
class StationManagementStationsSearch extends StationManagementStations
{
    public $stationname;
    public $stationmanagementname;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'station_id', 'station_management_id', 'created_at', 'updated_at', 'deleted_at','unique_field','stationname','stationmanagementname'], 'safe'],
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
        $query = StationManagementStations::find();

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            //->andFilterWhere(['like', 'station_id', $this->station_id])
            //->andFilterWhere(['like', 'station_management_id', $this->station_management_id]);
            ->andFilterWhere(['like', 'stations.name', $this->stationname])
            ->andFilterWhere(['like', 'users.first_name', $this->stationmanagementname]);

        return $dataProvider;
    }
}
