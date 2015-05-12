<?php

use yii\db\Schema;
use yii\db\Migration;
use filsh\geonames\models\Timezones;

class m150512_210248_timezone_order_popular extends Migration
{
    public function up()
    {
        $this->addColumn(Timezones::tableName(), 'order_popular', Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0 AFTER `offset_raw`');
    }

    public function down()
    {
        $this->dropColumn(Timezones::tableName(), 'order_popular');
    }
}
