<?php

namespace filsh\geonames\commands;

use Yii;

class ImportController extends \yii\console\Controller
{
    const TIMEZONES_SOURCE_URL = 'http://download.geonames.org/export/dump/timeZones.txt';
    
    public function beforeAction($action)
    {
        if(false === parent::beforeAction($action)) {
            return false;
        }
        return $this->module->has('importer');
    }
    
    /**
     * Import timezones from specified source.
     *
     * This command load and parse Maxmind timezones csv data file.
     *
     * @param string $sourceUrl the path of the destination source file.
     * @throws Exception if the path argument is invalid.
     */
    public function actionTimezones($sourceUrl = self::TIMEZONES_SOURCE_URL)
    {
        $this->module->importer->run('timezones', [
            'dataReader' => $sourceUrl
        ]);
    }
}