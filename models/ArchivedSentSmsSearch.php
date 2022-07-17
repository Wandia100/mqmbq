<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SentSms;

/**
 * ArchivedSentSmsSearch represents the model behind the search form of `app\models\SentSms`.
 */
class ArchivedSentSmsSearch extends SentSms
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category'], 'integer'],
            [['receiver', 'sender', 'message', 'created_date','station_id'], 'safe'],
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
        $query = SentSms::find();

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
            'created_date' => $this->created_date,
            'category' => $this->category,
        ]);

        $query->andFilterWhere(['like', 'receiver', $this->receiver])
            ->andFilterWhere(['like', 'sender', $this->sender])
            ->andFilterWhere(['like', 'message', $this->message]);
        if(\Yii::$app->myhelper->isStationManager()){
           $query->andWhere(['IN','station_id', \Yii::$app->myhelper->getStations()]); 
        }
            $query->orderBy('created_date DESC');
        return $dataProvider;
    }
}
