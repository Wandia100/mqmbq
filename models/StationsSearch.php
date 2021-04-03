<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Stations;

/**
 * StationsSearch represents the model behind the search form of `app\models\Stations`.
 */
class StationsSearch extends Stations
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'address', 'station_code', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['enabled'], 'integer'],
            [['invalid_percentage'], 'number'],
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
        $query = Stations::find();

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
            'enabled' => $this->enabled,
            'invalid_percentage' => $this->invalid_percentage,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'station_code', $this->station_code]);

        return $dataProvider;
    }
}
