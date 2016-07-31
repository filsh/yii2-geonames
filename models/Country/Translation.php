<?php

namespace filsh\geonames\models\Country;

use filsh\geonames\Module;
use filsh\geonames\models\Country;

/**
 * This is the model class for table "{{%country_translations}}".
 *
 * @property integer $country_id
 * @property string $language
 * @property string $name
 * @property string $capital
 * @property string $currency_name
 *
 * @property Timezone $timezone
 */
class Translation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%country_translations}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id'], 'integer'],
            [['language'], 'string', 'max' => 16],
            [['name', 'capital', 'currency_name'], 'string', 'max' => 255],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::class, 'targetAttribute' => ['country_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'country_id' => Module::t('geonames', 'Country ID'),
            'language' => Module::t('geonames', 'Language'),
            'name' => Module::t('geonames', 'Name', [], $this->language) . '(' . $this->language . ')',
            'capital' => Module::t('geonames', 'Capital', [], $this->language) . '(' . $this->language . ')',
            'currency_name' => Module::t('geonames', 'Currency Name', [], $this->language) . '(' . $this->language . ')',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }
}
