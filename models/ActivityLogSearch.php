<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ActivityLog;

/**
 * ActivityLogSearch represents the model behind the search form of `app\models\ActivityLog`.
 */
class ActivityLogSearch extends ActivityLog
{
    public $user;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'is_deleted'], 'integer'],
            [['description', 'causer_id', 'properties', 'created_at', 'updated_at','user'], 'safe'],
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
        $query = ActivityLog::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->joinWith(['user']);
        
        
        $dataProvider->sort->attributes['user'] = [
            'asc'  => [ 'users.first_name' => SORT_ASC ],
            'desc' => [ 'users.first_name' => SORT_DESC ],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'causer_id', $this->causer_id])
            ->andFilterWhere(['like', 'properties', $this->properties]); 
        if(!empty( $this->user)){
            $query->andWhere('users.first_name LIKE "%'.trim($this->user). '%" ' .
            'OR users.last_name LIKE "%'.trim($this->user). '%"');
        }

        return $dataProvider;
    }
}
