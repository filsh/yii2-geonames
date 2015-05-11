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
 * @property Timezones $timezone
 */
class TimezoneTranslations extends \yii\db\ActiveRecord
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
            [['timezone_id', 'language', 'title', 'create_time', 'update_time'], 'required'],
            [['timezone_id', 'create_time', 'update_time'], 'integer'],
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
        return $this->hasOne(Timezones::className(), ['id' => 'timezone_id']);
    }
}