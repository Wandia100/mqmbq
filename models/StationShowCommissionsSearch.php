<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StationShowCommissions;

/**
 * StationShowCommissionsSearch represents the model behind the search form of `app\models\StationShowCommissions`.
 */
class StationShowCommissionsSearch extends StationShowCommissions
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'perm_group'], 'integer'],
            [['station_id', 'station_show_id', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['commission'], 'number'],
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
        $query = StationShowCommissions::find();

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
            'perm_group' => $this->perm_group,
            'commission' => $this->commission,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ]);

        $query->andFilterWhere(['like', 'station_id', $this->station_id])
            ->andFilterWhere(['like', 'station_show_id', $this->station_show_id]);
        
        if($showid != ''){
            $query->andWhere("station_show_id = '$showid'");
        }
        $query->orderBy('id DESC');

        return $dataProvider;
    }
}
