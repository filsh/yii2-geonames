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
    public $enableFlashMessages = true;

    /**
     * @var array Model's map
     */
    public $modelMap = [];

    /**
     * @var array Runner's map
     */
    public $runnerMap = [];

    /**
     * @var array
     */
    public $supportedLanguages = ['ru-RU'];

    /**
     * @var array
     */
    protected $translateLanguages;

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
            'class' => PhpMessageSource::class,
            'basePath' => __DIR__ . '/messages',
        ];
    }

    public function getTranslateLanguages()
    {
        if($this->translateLanguages !== null) {
            return $this->translateLanguages;
        }

        $this->translateLanguages = array_map(function($language) {
            return str_replace('_', '-', $language);
        }, $this->supportedLanguages);

        if(($key = array_search(\Yii::$app->sourceLanguage, $this->translateLanguages)) !== false) {
            unset($this->translateLanguages[$key]);
        }
        return $this->translateLanguages;
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/geonames/' . $category, $message, $params, $language);
    }
}