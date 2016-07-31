<?php

namespace filsh\geonames\models;

use Yii;

/**
 * This is the model class for table "{{%timezone_translations}}".
 *
 * @property integer $id
 * @property integer $timezone_id
 * @property string $language
 * @property string $title
 * @property integer $create_time
 * @property integer $update_time
 *
 * @property Timezone $timezone
 */
class TimezoneTranslations extends \yii\db\ActiveRecord
{
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
        ];
    }

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
            [['timezone_id', 'language', 'title'], 'required'],
            [['timezone_id'], 'integer'],
            [['language'], 'string', 'max' => 6],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'timezone_id' => 'Timezone ID',
            'language' => 'Language',
            'title' => 'Title',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTimezone()
    {
        return $this->hasOne(Timezone::className(), ['id' => 'timezone_id']);
    }
}