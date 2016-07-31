<?php

namespace filsh\geonames\models;

use yii\data\ActiveDataProvider;
use yii\behaviors\TimestampBehavior;
use filsh\geonames\Module;

/**
 * This is the model class for table "{{%countries}}".
 *
 * @property integer $id
 * @property string $iso
 * @property string $iso3
 * @property integer $iso_numeric
 * @property string $fips
 * @property string $name
 * @property string $capital
 * @property string $area
 * @property integer $population
 * @property string $continent
 * @property string $tld
 * @property string $currency_code
 * @property string $currency_name
 * @property string $phone_code
 * @property string $postal_code_format
 * @property string $postal_code_regex
 * @property string $languages
 * @property integer $geoname_id
 * @property string $neighbours
 * @property string $equivalent_fips_code
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Timezone[] $timezones
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%countries}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iso', 'iso3', 'iso_numeric', 'name', 'population', 'continent'], 'required'],
            [['iso_numeric', 'population', 'geoname_id'], 'integer'],
            [['area'], 'number'],
            [['iso', 'continent'], 'string', 'max' => 2],
            [['iso3', 'fips', 'tld', 'currency_code'], 'string', 'max' => 3],
            [['name', 'capital', 'phone_code', 'postal_code_format', 'postal_code_regex', 'languages', 'neighbours', 'equivalent_fips_code'], 'string', 'max' => 255],
            [['currency_name'], 'string', 'max' => 20],
            [['iso'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('geonames', 'ID'),
            'iso' => Module::t('geonames', 'Iso'),
            'iso3' => Module::t('geonames', 'Iso3'),
            'iso_numeric' => Module::t('geonames', 'Iso Numeric'),
            'fips' => Module::t('geonames', 'Fips'),
            'name' => Module::t('geonames', 'Name'),
            'capital' => Module::t('geonames', 'Capital'),
            'area' => Module::t('geonames', 'Area'),
            'population' => Module::t('geonames', 'Population'),
            'continent' => Module::t('geonames', 'Continent'),
            'tld' => Module::t('geonames', 'Tld'),
            'currency_code' => Module::t('geonames', 'Currency Code'),
            'currency_name' => Module::t('geonames', 'Currency Name'),
            'phone_code' => Module::t('geonames', 'Phone Code'),
            'postal_code_format' => Module::t('geonames', 'Postal Code Format'),
            'postal_code_regex' => Module::t('geonames', 'Postal Code Regex'),
            'languages' => Module::t('geonames', 'Languages'),
            'geoname_id' => Module::t('geonames', 'Geoname ID'),
            'neighbours' => Module::t('geonames', 'Neighbours'),
            'equivalent_fips_code' => Module::t('geonames', 'Equivalent Fips Code'),
            'created_at' => Module::t('geonames', 'Create Time'),
            'updated_at' => Module::t('geonames', 'Update Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTimezones()
    {
        return $this->hasMany(Timezone::class, ['country' => 'iso']);
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => self::find(),
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        return $dataProvider;
    }
}