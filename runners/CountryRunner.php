<?php

namespace filsh\geonames\runners;

use Yii;
use filsh\geonames\models\Countries;
use filsh\geonames\helpers\FileHelper;

class CountryRunner extends \filsh\yii2\runner\BaseRunner
{
    const SOURCE_URL = 'http://download.geonames.org/export/dump/countryInfo.txt';
    
    public $tmpPath = '@runtime/runner/countries';
    
    public function run()
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
        return self::SOURCE_URL;
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
        
        while(($data = fgetcsv($handle, 0, "\t")) !== false) {
            if(count($data) == 1 || preg_match('/^#/', $data[0])) {
                continue;
            }
            
            /* @var $country Countries */
            $country = Yii::createObject([
                'class'    => Countries::className(),
                'scenario' => Countries::SCENARIO_CREATE,
            ]);
            $attributes = [
                'iso' => $data[0],
                'iso3' => $data[1],
                'iso_numeric' => $data[2],
                'fips' => $data[3],
                'name' => $data[4],
                'capital' => $data[5],
                'area' => $data[6],
                'population' => $data[7],
                'continent' => $data[8],
                'tld' => $data[9],
                'currency_code' => $data[10],
                'currency_name' => $data[11],
                'phone_code' => $data[12],
                'postal_code_format' => $data[13],
                'postal_code_regex' => $data[14],
                'languages' => $data[15],
                'geoname_id' => $data[16],
                'neighbours' => $data[17],
                'equivalent_fips_code' => $data[18],
            ];
            
            $exists = $country
                ->find()
                ->where('iso = :iso', [
                    ':iso' => $attributes['iso']
                ])
                ->exists();
            
            if(!$exists) {
                $country->setAttributes($attributes);
                
                if(!$country->save()) {
                    throw new \yii\base\InvalidParamException('Unable to create country.');
                }
            }
        }

        fclose($handle);
    }
}