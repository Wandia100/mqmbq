<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StationShowPrizes;

/**
 * StationShowPrizesSearch represents the model behind the search form of `app\models\StationShowPrizes`.
 */
class StationShowPrizesSearch extends StationShowPrizes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'station_id', 'station_show_id', 'prize_id', 'created_at', 'updated_at', 'deleted_at', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'], 'safe'],
            [['draw_count', 'enabled'], 'integer'],
            [['amount'], 'number'],
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
    public function search($params,$showid='')
    {
        $query = StationShowPrizes::find();

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
            'draw_count' => $this->draw_count,
            'amount' => $this->amount,
            'enabled' => $this->enabled,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'station_id', $this->station_id])
            ->andFilterWhere(['like', 'station_show_id', $this->station_show_id])
            ->andFilterWhere(['like', 'prize_id', $this->prize_id])
            ->andFilterWhere(['like', 'monday', $this->monday])
            ->andFilterWhere(['like', 'tuesday', $this->tuesday])
            ->andFilterWhere(['like', 'wednesday', $this->wednesday])
            ->andFilterWhere(['like', 'thursday', $this->thursday])
            ->andFilterWhere(['like', 'friday', $this->friday]);
        
        if($showid != ''){
            $query->andWhere("station_show_id = '$showid'");
        }
        $query->orderBy('id DESC');

        return $dataProvider;
    }
}
