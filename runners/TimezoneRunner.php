<?php

namespace filsh\geonames\runners;

class TimezoneRunner extends \filsh\yii2\runner\BaseRunner
{
    public $dataReader;
    
    public function run()
    {
        var_dump($this->dataReader);exit;
    }
}