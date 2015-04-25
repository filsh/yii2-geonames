<?php

namespace filsh\geonames\commands;

use Yii;

class ImportController extends \yii\console\Controller
{
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
        Yii::$app->runner->run('timezones', [
            'sourceUrl' => $sourceUrl
        ]);
    }
}