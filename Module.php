<?php

namespace filsh\geonames;

use Yii;

class Module extends \yii\base\Module
{
    const VERSION = '0.0.1';
    
    public $modelMap = [];
    
    public function init()
    {
        parent::init();
        $this->components = [
            'runner' => [
                'class' => 'filsh\yii2\runner\RunnerComponent',
                'runners' => [
//                    'first',
                    'second' => function(array $params) {
                        echo 'inline runner with params: ' . json_encode($params);
                    }
                ]
            ]
        ];
        
var_dump($this->runner->run('second', ['var' => 'value']));exit;
    }
}