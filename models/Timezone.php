<?php

namespace filsh\geonames\models;

use yii\data\ActiveDataProvider;
use yii\behaviors\TimestampBehavior;
use creocoder\translateable\TranslateableBehavior;
use filsh\geonames\Module;

/**
 * This is the model class for table "{{%timezones}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $country
 * @property string $timezone
 * @property string $offset_gmt
 * @property string $offset_dst
 * @property string $offset_raw
 * @property integer $order_popular
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Country $country
 * @property Timezone\Translation[] $translations
 */
class Timezone extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => TranslateableBehavior::class,
                'translationAttributes' => ['title'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_INSERT | self::OP_UPDATE,
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%timezones}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country', 'timezone', 'offset_gmt', 'offset_dst', 'offset_raw'], 'required'],
            [['offset_gmt', 'offset_dst', 'offset_raw'], 'number'],
            [['order_popular'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['country'], 'string', 'max' => 2],
            [['timezone'], 'string', 'max' => 255],
            [['country', 'timezone'], 'unique', 'targetAttribute' => ['country', 'timezone'], 'message' => 'The combination of Country and Timezone has already been taken.'],
            [['translations'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('geonames', 'ID'),
            'title' => Module::t('geonames', 'Title'),
            'country' => Module::t('geonames', 'Country'),
            'timezone' => Module::t('geonames', 'Timezone'),
            'offset_gmt' => Module::t('geonames', 'Offset Gmt'),
            'offset_dst' => Module::t('geonames', 'Offset Dst'),
            'offset_raw' => Module::t('geonames', 'Offset Raw'),
            'order_popular' => Module::t('geonames', 'Order Popular'),
            'created_at' => Module::t('geonames', 'Create Time'),
            'updated_at' => Module::t('geonames', 'Update Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['iso' => 'country']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(Timezone\Translation::class, ['timezone_id' => 'id']);
    }
}