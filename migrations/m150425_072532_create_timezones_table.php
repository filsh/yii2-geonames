<?php

use yii\db\Schema;
use yii\db\Migration;
use filsh\geonames\models\Timezone;
use filsh\geonames\models\Country;

class m150425_072532_create_timezones_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable(Timezone::tableName(), [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(255) DEFAULT NULL',
            'country' => Schema::TYPE_STRING . '(2) NOT NULL',
            'timezone' => Schema::TYPE_STRING . '(255) NOT NULL',
            'offset_gmt' => Schema::TYPE_DECIMAL . '(3,1) NOT NULL',
            'offset_dst' => Schema::TYPE_DECIMAL . '(3,1) NOT NULL',
            'offset_raw' => Schema::TYPE_DECIMAL . '(3,1) NOT NULL',
            'order_popular' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'UNIQUE (country, timezone)',
            'FOREIGN KEY (country) REFERENCES ' . Country::tableName() . ' (iso) ON DELETE CASCADE ON UPDATE CASCADE'
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable(Timezone::tableName());
    }
}
