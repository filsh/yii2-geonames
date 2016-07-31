<?php

namespace filsh\geonames\models\Timezone\Form;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use filsh\geonames\models\Timezone;

/**
 * Search represents the model behind the search form about `filsh\geonames\models\Timezone`.
 */
class Search extends Timezone
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_popular', 'created_at', 'updated_at'], 'integer'],
            [['title', 'country', 'timezone'], 'safe'],
            [['offset_gmt', 'offset_dst', 'offset_raw'], 'number'],
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
        $query = Timezone::find();

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
            'offset_gmt' => $this->offset_gmt,
            'offset_dst' => $this->offset_dst,
            'offset_raw' => $this->offset_raw,
            'order_popular' => $this->order_popular,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'timezone', $this->timezone]);

        return $dataProvider;
    }
}
