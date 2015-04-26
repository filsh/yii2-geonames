<?php

use yii\db\Schema;
use yii\db\Migration;
use filsh\geonames\models\Timezones;
use filsh\geonames\models\Countries;

class m150425_072531_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable(Countries::tableName(), [
            'id' => Schema::TYPE_PK,
            'iso' => Schema::TYPE_STRING . '(2) NOT NULL',
            'iso3' => Schema::TYPE_STRING . '(3) NOT NULL',
            'iso_numeric' => Schema::TYPE_INTEGER . ' NOT NULL',
            'fips' => Schema::TYPE_STRING . '(3) DEFAULT NULL',
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'capital' => Schema::TYPE_STRING . '(255) DEFAULT NULL',
            'area' => Schema::TYPE_DECIMAL . ' DEFAULT NULL',
            'population' => Schema::TYPE_INTEGER . ' NOT NULL',
            'continent' => Schema::TYPE_STRING . '(2) NOT NULL',
            'tld' => Schema::TYPE_STRING . '(3) DEFAULT NULL',
            'currency_code' => Schema::TYPE_STRING . '(3) DEFAULT NULL',
            'currency_name' => Schema::TYPE_STRING . '(20) DEFAULT NULL',
            'phone_code' => Schema::TYPE_STRING . '(255) DEFAULT NULL',
            'postal_code_format' => Schema::TYPE_STRING . '(255) DEFAULT NULL',
            'postal_code_regex' => Schema::TYPE_STRING . '(255) DEFAULT NULL',
            'languages' => Schema::TYPE_STRING . '(255) DEFAULT NULL',
            'geoname_id' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'neighbours' => Schema::TYPE_STRING . '(255) DEFAULT NULL',
            'equivalent_fips_code' => Schema::TYPE_STRING . '(255) DEFAULT NULL',
            'create_time' => Schema::TYPE_INTEGER.' NOT NULL',
            'update_time' => Schema::TYPE_INTEGER.' NOT NULL',
            'UNIQUE KEY(`iso`)'
        ], $tableOptions);
        
        $this->createTable(Timezones::tableName(), [
            'id' => Schema::TYPE_PK,
            'country' => Schema::TYPE_STRING . '(2) NOT NULL',
            'timezone' => Schema::TYPE_STRING . '(255) NOT NULL',
            'offset_gmt' => Schema::TYPE_DECIMAL . '(3,1) NOT NULL',
            'offset_dst' => Schema::TYPE_DECIMAL . '(3,1) NOT NULL',
            'offset_raw' => Schema::TYPE_DECIMAL . '(3,1) NOT NULL',
            'create_time' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_time' => Schema::TYPE_INTEGER . ' NOT NULL',
            'UNIQUE KEY (`country`, `timezone`)',
            'FOREIGN KEY (`country`) REFERENCES ' . Countries::tableName() . ' (`iso`) ON DELETE CASCADE ON UPDATE CASCADE'
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable(Timezones::tableName());
        $this->dropTable(Countries::tableName());
    }
}
