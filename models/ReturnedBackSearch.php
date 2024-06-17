<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ReturnedBack;

/**
 * ReturnedBackSearch represents the model behind the search form of `app\models\ReturnedBack`.
 */
class ReturnedBackSearch extends ReturnedBack
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_item_id', 'name'], 'safe'],
            [['howmany', 'enabled'], 'integer'],
            [['outprice'], 'number'],
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
        $query = ReturnedBack::find();

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
            'howmany' => $this->howmany,
            'outprice' => $this->outprice,
            'enabled' => $this->enabled,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'category_item_id', $this->category_item_id])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
