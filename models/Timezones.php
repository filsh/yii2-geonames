<?php

namespace filsh\geonames\models;

use Yii;

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
 */
class Timezones extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    
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
            [['country', 'timezone'], 'unique', 'targetAttribute' => ['country', 'timezone'], 'message' => 'The combination of Country and Timezone has already been taken.']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE   => ['country', 'timezone', 'offset_gmt', 'offset_dst', 'offset_raw']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country' => 'Country',
            'timezone' => 'Timezone',
            'offset_gmt' => 'Offset Gmt',
            'offset_dst' => 'Offset Dst',
            'offset_raw' => 'Offset Raw',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}