<?php

namespace filsh\geonames;

class Bootstrap implements \yii\base\BootstrapInterface
{
    /** @var array Model's map */
    private $_modelMap = [
        'Timezones' => 'filsh\geonames\models\Timezones',
    ];
    
    /** @inheritdoc */
    public function bootstrap($app)
    {
        /** @var $module Module */
        if ($app->hasModule('geonames') && ($module = $app->getModule('geonames')) instanceof Module) {
            $this->_modelMap = array_merge($this->_modelMap, $module->modelMap);
            foreach ($this->_modelMap as $name => $definition) {
                $class = "filsh\\geonames\\models\\" . $name;
                \Yii::$container->set($class, $definition);
                $modelName = is_array($definition) ? $definition['class'] : $definition;
                $module->modelMap[$name] = $modelName;
            }
            
            if ($app instanceof \yii\console\Application) {
                $module->controllerNamespace = 'filsh\geonames\commands';
            } else {
                ;
            }
        }
    }
}