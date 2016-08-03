<?php

namespace filsh\geonames\runners;

use Yii;
use filsh\geonames\models\Country;
use filsh\geonames\helpers\FileHelper;

class CountryTranslateRunner extends \filsh\yii2\runner\BaseRunner
{
    const SOURCE_URL = 'http://ws.geonames.org/countryInfoCSV?username=demo';

    public $language;
    
    public $tmpPath = '@runtime/runner/CountryTranslate';

    protected function doRun()
    {
        FileHelper::loadFile($this->getSourceUrl(), [
            'destDir' => $this->tmpPath,
            'onLoad' => function($file) {
                $this->resolveFile($file);
            }
        ]);

        FileHelper::removeDirectory($this->tmpPath);
    }

    protected function getSourceUrl()
    {
        return self::SOURCE_URL . '&' . 'lang=' . reset(explode('-', $this->language));
    }

    public function resolveFile($file)
    {
        if(!is_file($file)) {
            throw new \yii\base\Exception('Source file not found.');
        }

        Yii::$app->db->transaction(function() use($file) {
            $this->applyCsv($file);
        });
    }

    /**
     * @see https://github.com/debuggable/php_arrays/tree/master/generators
     * @param type $file
     */
    protected function applyCsv($file)
    {
        if(($handle = fopen($file, 'r')) === false) {
            return;
        }

        for($i = 0; ($data = fgetcsv($handle, 1000, "\t")) !== false; $i++) {
            if($i === 0) {
                continue;
            }

            $country = Country::find()
                    ->with('translations')
                    ->where(['iso' => $data[0]])
                    ->one();

            if($country === null) {
                continue;
            }
            
            $country->translate($this->language)->name = $data[4];
            $country->translate($this->language)->capital = $data[5];
            $country->translate($this->language)->currency_name = $data[10];

            if(!$country->save()) {
                throw new \yii\base\InvalidParamException('Unable to update country.');
            }
        }

        fclose($handle);
    }
}