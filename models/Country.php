<?php

namespace filsh\geonames\models;

use Yii;
use filsh\geonames\Module;
use yii\data\ActiveDataProvider;

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
 * @property integer $create_time
 * @property integer $update_time
 *
 * @property Timezone[] $timezones
 */
class Country extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_SEARCH = 'search';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['create_time', 'update_time'],
                    self::EVENT_BEFORE_UPDATE => 'update_time',
                ],
            ]
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
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['iso', 'iso3', 'iso_numeric', 'fips', 'name', 'capital', 'area', 'population', 'continent', 'tld', 'currency_code', 'currency_name', 'phone_code', 'postal_code_format', 'postal_code_regex', 'languages', 'geoname_id', 'neighbours', 'equivalent_fips_code'],
            self::SCENARIO_SEARCH => ['iso', 'iso3', 'iso_numeric', 'fips', 'name', 'capital', 'area', 'population', 'continent', 'tld', 'currency_code', 'currency_name', 'phone_code', 'postal_code_format', 'postal_code_regex', 'languages', 'geoname_id', 'neighbours', 'equivalent_fips_code']
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
            'create_time' => Module::t('geonames', 'Create Time'),
            'update_time' => Module::t('geonames', 'Update Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTimezones()
    {
        return $this->hasMany(Timezone::className(), ['country' => 'iso']);
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