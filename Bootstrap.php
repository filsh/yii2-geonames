<?php

namespace filsh\geonames;

use filsh\yii2\runner\RunnerComponent;
use yii\web\GroupUrlRule;
use yii\i18n\PhpMessageSource;

class Bootstrap implements \yii\base\BootstrapInterface
{
    /**
     * @var array Model's map
     */
    private $_modelMap = [
        'Timezones' => 'filsh\geonames\models\Timezones',
        'Countries' => 'filsh\geonames\models\Countries',
        'TimezoneSearch' => 'filsh\geonames\models\TimezoneSearch',
    ];
    
    /**
     * @var array Runner's map
     */
    private $_runnerMap = [
        'CountryRunner' => 'filsh\geonames\runners\CountryRunner',
        'TimezoneRunner' => 'filsh\geonames\runners\TimezoneRunner',
    ];
    
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        /** @var $module Module */
        if ($app->hasModule('geonames') && ($module = $app->getModule('geonames')) instanceof Module) {
            $this->_modelMap = array_merge($this->_modelMap, $module->modelMap);
            foreach ($this->_modelMap as $name => $definition) {
                \Yii::$container->set("filsh\\geonames\\models\\" . $name, $definition);
                $module->modelMap[$name] = is_array($definition) ? $definition['class'] : $definition;
            }
            
            if(!$module->has('importer')) {
                $this->_runnerMap = array_merge($this->_runnerMap, $module->runnerMap);
                foreach ($this->_runnerMap as $name => $definition) {
                    \Yii::$container->set("filsh\\geonames\\runners\\" . $name, $definition);
                    $module->runnerMap[$name] = is_array($definition) ? $definition['class'] : $definition;
                }

                $module->set('importer', [
                    'class' => RunnerComponent::className(),
                    'runners' => $module->runnerMap
                ]);
            }
            
            if (!isset($app->get('i18n')->translations['geonames*'])) {
                $app->get('i18n')->translations['geonames*'] = [
                    'class'    => PhpMessageSource::className(),
                    'basePath' => __DIR__ . '/messages',
                ];
            }
            
            if ($app instanceof \yii\console\Application) {
                $module->controllerNamespace = 'filsh\geonames\commands';
            }
        }
    }
}