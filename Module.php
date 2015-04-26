<?php

namespace filsh\geonames;

use Yii;
use yii\i18n\PhpMessageSource;

class Module extends \yii\base\Module
{
    const VERSION = '0.0.1';
    
    /**
     * @var bool Whether to show flash messages.
     */
    public $enableFlashMessages;
    
    /**
     * @var array Model's map
     */
    public $modelMap = [];
    
    /**
     * @var array Runner's map
     */
    public $runnerMap = [];
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }
    
    public function registerTranslations()
    {
        Yii::$app->i18n->translations['modules/geonames/*'] = [
            'class' => PhpMessageSource::className(),
            'basePath' => __DIR__ . '/messages',
        ];
    }
    
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/geonames/' . $category, $message, $params, $language);
    }
}