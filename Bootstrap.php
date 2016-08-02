<?php

namespace filsh\geonames;

use filsh\yii2\runner\RunnerComponent;

class Bootstrap implements \yii\base\BootstrapInterface
{
    /**
     * @var array Model's map
     */
    private $_modelMap = [
        'Timezone' => 'filsh\geonames\models\Timezone',
        'Country' => 'filsh\geonames\models\Country',
    ];

    /**
     * @var array Runner's map
     */
    private $_runnerMap = [
        'CountryRunner' => 'filsh\geonames\runners\CountryRunner',
        'CountryTranslateRunner' => 'filsh\geonames\runners\CountryTranslateRunner',
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
                    'class' => RunnerComponent::class,
                    'runners' => $module->runnerMap
                ]);
            }

            if ($app instanceof \yii\console\Application) {
                $module->controllerNamespace = 'filsh\geonames\commands';
            }
        }
    }
}