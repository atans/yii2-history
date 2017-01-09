<?php

namespace atans\history\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use atans\history\models\History;

/**
 * HistorySearch represents the model behind the search form about `atans\history\models\History`.
 */
class HistorySearch extends History
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['table', 'event', 'model_scenario', 'key', 'data', 'ip', 'created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = History::find();

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
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'table', $this->table])
            ->andFilterWhere(['like', 'event', $this->event])
            ->andFilterWhere(['like', 'model_scenario', $this->model_scenario])
            ->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'data', $this->data])
            ->andFilterWhere(['like', 'ip', $this->ip]);

        return $dataProvider;
    }
}
