<?php

use yii\db\Schema;
use yii\db\Migration;
use filsh\geonames\models\Timezone;

class m150511_195242_create_timezone_translations_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable(Timezone\Translation::tableName(), [
            'timezone_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'language' => $this->string(16)->notNull(),
            'title' => $this->string(255)->notNull(),
            'CONSTRAINT fk_timezones_timezone_translations_timezone_id FOREIGN KEY (timezone_id) REFERENCES ' . Timezone::tableName() . ' (id) ON DELETE CASCADE ON UPDATE CASCADE',
            'PRIMARY KEY(timezone_id, language)',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable(Timezone\Translation::tableName());
    }
}
