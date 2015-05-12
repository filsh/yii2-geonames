<?php

namespace filsh\geonames\models;

use Yii;
use yii\data\ActiveDataProvider;
use filsh\geonames\Module;

/**
 * This is the model class for table "{{%timezones}}".
 *
 * @property integer $id
 * @property string $country
 * @property string $timezone
 * @property string $offset_gmt
 * @property string $offset_dst
 * @property string $offset_raw
 * @property integer $create_time
 * @property integer $update_time
 *
 * @property Countries $country0
 */
class Timezones extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_UPDATE_TRANSLATIONS = 'update-translations';
    
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
            ],
            'translations' => [
                'class' => 'dosamigos\translateable\TranslateableBehavior',
                'translationAttributes' => ['title']
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return array_merge(
            parent::attributes(),
            ['translations']
        );
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
            [['country'], 'string', 'max' => 2],
            [['timezone'], 'string', 'max' => 255],
            [['country', 'timezone'], 'unique', 'targetAttribute' => ['country', 'timezone'], 'message' => 'The combination of Country and Timezone has already been taken.'],
            [['translations'], 'safe']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['country', 'timezone', 'offset_gmt', 'offset_dst', 'offset_raw'],
            self::SCENARIO_UPDATE => ['country', 'timezone', 'offset_gmt', 'offset_dst', 'offset_raw'],
            self::SCENARIO_UPDATE_TRANSLATIONS => ['translations'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('geonames', 'ID'),
            'country' => Module::t('geonames', 'Country'),
            'timezone' => Module::t('geonames', 'Timezone'),
            'offset_gmt' => Module::t('geonames', 'Offset Gmt'),
            'offset_dst' => Module::t('geonames', 'Offset Dst'),
            'offset_raw' => Module::t('geonames', 'Offset Raw'),
            'create_time' => Module::t('geonames', 'Create Time'),
            'update_time' => Module::t('geonames', 'Update Time'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::className(), ['iso' => 'country']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(TimezoneTranslations::className(), ['timezone_id' => 'id']);
    }
    
    public function saveTranslations()
    {
        return $this->getDb()->transaction(function() {
            TimezoneTranslations::deleteAll(['timezone_id' => $this->id]);

            foreach($this->translations as $language => $translation) {
                $this->language = $language;
                $this->title = $translation;
                
                if(!$this->saveTranslation()) {
                    return false;
                }
            }
            return true;
        });
    }
}