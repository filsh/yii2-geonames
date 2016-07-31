<?php

use yii\db\Schema;
use yii\db\Migration;
use filsh\geonames\models\Country;

class m150511_195243_create_country_translations_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable(Country\Translation::tableName(), [
            'country_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'language' => $this->string(16)->notNull(),
            'name' => $this->string(255)->notNull(),
            'capital' => $this->string(255)->notNull(),
            'currency_name' => $this->string(255)->notNull(),
            'CONSTRAINT fk_countries_country_translations_country_id FOREIGN KEY (country_id) REFERENCES ' . Country::tableName() . ' (id) ON DELETE CASCADE ON UPDATE CASCADE'
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable(Country\Translation::tableName());
    }
}
