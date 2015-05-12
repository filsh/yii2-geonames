<?php

namespace filsh\geonames\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use filsh\geonames\models\Timezones;

class TimezoneSearch extends Model
{
    /**
     * @var string
     */
    public $country;
    
    /**
     * @var string
     */
    public $timezone;
    
    /**
     * @var string
     */
    public $title;
    
    /**
     * @var float
     */
    public $offset_gmt;
    
    /**
     * @var float
     */
    public $offset_dst;
    
    /**
     * @var float
     */
    public $offset_raw;
    
    /**
     * @var integer
     */
    public $order_popular;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country', 'timezone', 'title', 'offset_gmt', 'offset_dst', 'offset_raw', 'order_popular'], 'safe'],
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Timezones::find();
        $query->joinWith(['translations']);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['title'] = [
            'asc'  => ['title' => SORT_ASC],
            'desc' => ['title' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        
        $query
            ->andFilterWhere(['country' => $this->country])
            ->andFilterWhere(['like', 'timezone', $this->timezone])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['offset_gmt' => $this->offset_gmt])
            ->andFilterWhere(['offset_dst' => $this->offset_dst])
            ->andFilterWhere(['offset_raw' => $this->offset_raw])
            ->andFilterWhere(['order_popular' => $this->order_popular]);
        
        return $dataProvider;
    }
}