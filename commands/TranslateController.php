<?php

namespace filsh\geonames\commands;

use filsh\geonames\Module;
use yii\helpers\Console;

class TranslateController extends \yii\console\Controller
{
    public function beforeAction($action)
    {
        if(false === parent::beforeAction($action)) {
            return false;
        }
        return $this->module->has('importer');
    }

    /**
     * Import country translates from external source.
     * This command load and parse countryinfo csv data file.
     *
     * @throws Exception if the path argument is invalid.
     */
    public function actionCountries($language)
    {
        if(!in_array($language, Module::getInstance()->translateLanguages)) {
            $this->stdout("Not supported language code, available codes: [" . implode(', ', Module::getInstance()->translateLanguages) . "].\n", Console::FG_RED);
            return self::EXIT_CODE_ERROR;
        }

        $this->module->importer->run('CountryTranslateRunner', ['language' => $language]);

        $this->stdout(Module::t('common', 'Country translates has been imported') . "!\n", Console::FG_YELLOW);
    }
}