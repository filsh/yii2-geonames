<?php

use yii\db\Schema;
use yii\db\Migration;
use filsh\geonames\models\Country;

class m150425_072531_create_countries_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable(Country::tableName(), [
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
            'created_at' => Schema::TYPE_INTEGER.' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER.' NOT NULL',
            'UNIQUE (iso)',
            'UNIQUE (iso3)',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable(Country::tableName());
    }
}
