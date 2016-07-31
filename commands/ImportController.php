<?php

namespace filsh\geonames\commands;

use Yii;
use filsh\geonames\Module;
use yii\helpers\Console;

class ImportController extends \yii\console\Controller
{
    public function beforeAction($action)
    {
        if(false === parent::beforeAction($action)) {
            return false;
        }
        return $this->module->has('importer');
    }
    
    /**
     * Import countries from external source.
     * This command load and parse countryinfo csv data file.
     *
     * @throws Exception if the path argument is invalid.
     */
    public function actionCountries()
    {
        $this->module->importer->run('CountryRunner');
        
        $this->stdout(Module::t('common', 'Countries has been imported') . "!\n", Console::FG_GREEN);
    }
    
    /**
     * Import timezones from external source.
     * This command load and parse timezones csv data file.
     *
     * @throws Exception if the path argument is invalid.
     */
    public function actionTimezones()
    {
        $this->module->importer->run('TimezoneRunner');
        
        $this->stdout(Module::t('common', 'Timezones has been imported') . "!\n", Console::FG_GREEN);
    }
}