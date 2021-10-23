<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StationTarget;

/**
 * StationTargetSearch represents the model behind the search form of `app\models\StationTarget`.
 */
class StationTargetSearch extends StationTarget
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'target'], 'integer'],
            [['start_time', 'end_time', 'station_id', 'unique_field'], 'safe'],
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
        $query = StationTarget::find();

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
        ]);

        $query->andFilterWhere(['like', 'station_id', $this->station_id])
            ->andFilterWhere(['like', 'unique_field', $this->unique_field]);
        $query->orderBy('id DESC');

        return $dataProvider;
    }
}
