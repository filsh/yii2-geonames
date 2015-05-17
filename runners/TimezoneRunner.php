<?php

namespace filsh\geonames\runners;

use Yii;
use filsh\geonames\models\Timezones;
use filsh\geonames\helpers\FileHelper;

class TimezoneRunner extends \filsh\yii2\runner\BaseRunner
{
    const SOURCE_URL = 'http://download.geonames.org/export/dump/timeZones.txt';
    
    public $tmpPath = '@runtime/runner/timezones';
    
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
        return self::SOURCE_URL;
    }
    
    protected function resolveFile($file)
    {
        if(!is_file($file)) {
            throw new \yii\base\Exception('Source file not found.');
        }
        
        Yii::$app->db->transaction(function() use($file) {
            $this->applyCsv($file);
        });
    }
    
    protected function applyCsv($file)
    {
        if(($handle = fopen($file, 'r')) === false) {
            return;
        }
        
        for($i = 0; ($data = fgetcsv($handle, 1000, "\t")) !== false; $i++) {
            if($i === 0) {
                continue;
            }

            /* @var $timezone Timezones */
            $timezone = Yii::createObject([
                'class'    => Timezones::className(),
                'scenario' => Timezones::SCENARIO_CREATE,
            ]);
            $attributes = [
                'country' => $data[0],
                'timezone' => $data[1],
                'offset_gmt' => $data[2],
                'offset_dst' => $data[3],
                'offset_raw' => $data[4],
            ];
            
            $exists = $timezone
                ->find()
                ->where('country = :country AND timezone = :timezone', [
                    ':country' => $attributes['country'],
                    ':timezone' => $attributes['timezone'],
                ])
                ->exists();
            
            if(!$exists) {
                $timezone->setAttributes($attributes);
                
                if(!$timezone->save()) {
                    throw new \yii\base\InvalidParamException('Unable to create timezone.');
                }
            }
        }

        fclose($handle);
    }
}