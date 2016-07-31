<?php

namespace filsh\geonames\models\Timezone;

use filsh\geonames\Module;
use filsh\geonames\models\Timezone;

/**
 * This is the model class for table "{{%timezone_translations}}".
 *
 * @property integer $timezone_id
 * @property string $language
 * @property string $title
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
        return '{{%timezone_translations}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['timezone_id'], 'integer'],
            [['language'], 'string', 'max' => 16],
            [['title'], 'string', 'max' => 255],
            [['timezone_id'], 'exist', 'skipOnError' => true, 'targetClass' => Timezone::class, 'targetAttribute' => ['timezone_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'timezone_id' => Module::t('geonames', 'Timezone ID'),
            'language' => Module::t('geonames', 'Language'),
            'title' => Module::t('geonames', 'Title', [], $this->language) . '(' . $this->language . ')',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTimezone()
    {
        return $this->hasOne(Timezone::class, ['id' => 'timezone_id']);
    }
}
