<?php

namespace filsh\geonames\models\Country\Form;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use filsh\geonames\models\Country;

/**
 * Search represents the model behind the search form about `filsh\geonames\models\Country`.
 */
class Search extends Country
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'iso_numeric', 'population', 'geoname_id', 'created_at', 'updated_at'], 'integer'],
            [['iso', 'iso3', 'fips', 'name', 'capital', 'continent', 'tld', 'currency_code', 'currency_name', 'phone_code', 'postal_code_format', 'postal_code_regex', 'languages', 'neighbours', 'equivalent_fips_code'], 'safe'],
            [['area'], 'number'],
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
        $query = Country::find();

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
            'iso_numeric' => $this->iso_numeric,
            'area' => $this->area,
            'population' => $this->population,
            'geoname_id' => $this->geoname_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'iso', $this->iso])
            ->andFilterWhere(['like', 'iso3', $this->iso3])
            ->andFilterWhere(['like', 'fips', $this->fips])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'capital', $this->capital])
            ->andFilterWhere(['like', 'continent', $this->continent])
            ->andFilterWhere(['like', 'tld', $this->tld])
            ->andFilterWhere(['like', 'currency_code', $this->currency_code])
            ->andFilterWhere(['like', 'currency_name', $this->currency_name])
            ->andFilterWhere(['like', 'phone_code', $this->phone_code])
            ->andFilterWhere(['like', 'postal_code_format', $this->postal_code_format])
            ->andFilterWhere(['like', 'postal_code_regex', $this->postal_code_regex])
            ->andFilterWhere(['like', 'languages', $this->languages])
            ->andFilterWhere(['like', 'neighbours', $this->neighbours])
            ->andFilterWhere(['like', 'equivalent_fips_code', $this->equivalent_fips_code]);

        return $dataProvider;
    }
}
