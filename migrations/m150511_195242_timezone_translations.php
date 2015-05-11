<?php

use yii\db\Schema;
use yii\db\Migration;
use filsh\geonames\models\Timezones;
use filsh\geonames\models\TimezoneTranslations;

class m150511_195242_timezone_translations extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable(TimezoneTranslations::tableName(), [
            'id' => Schema::TYPE_PK,
            'timezone_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'language' =>  Schema::TYPE_STRING . '(6) NOT NULL',
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'create_time' => Schema::TYPE_INTEGER . ' NOT NULL',
            'update_time' => Schema::TYPE_INTEGER . ' NOT NULL',
            'FOREIGN KEY (`timezone_id`) REFERENCES ' . Timezones::tableName() . ' (`id`) ON DELETE CASCADE ON UPDATE CASCADE'
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable(TimezoneTranslations::tableName());
    }
}
