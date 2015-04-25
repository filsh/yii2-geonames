<?php

use yii\db\Schema;
use yii\db\Migration;
use filsh\geonames\models\Timezones;

class m150425_072531_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable(Timezones::tableName(), [
            'id' => Schema::TYPE_PK,
            'country' => Schema::TYPE_STRING . '(2) NOT NULL',
            'timezone' => Schema::TYPE_STRING . '(255) NOT NULL',
            'offset_gmt' => Schema::TYPE_DECIMAL . '(1,1) NOT NULL',
            'offset_dst' => Schema::TYPE_DECIMAL . '(1,1) NOT NULL',
            'offset_raw' => Schema::TYPE_DECIMAL . '(1,1) NOT NULL',
            'create_time' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_time' => Schema::TYPE_INTEGER . ' NOT NULL',
            'UNIQUE KEY (`country`, `timezone`)'
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable(Timezones::tableName());
    }
}
