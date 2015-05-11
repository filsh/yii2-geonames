<?php

/**
 * @var $this yii\web\View
 */

use yii\bootstrap\Nav;
use filsh\geonames\Module;
?>

<?= Nav::widget([
    'options' => [
        'class' => 'nav-tabs',
        'style' => 'margin-bottom: 15px'
    ],
    'items' => [
        [
            'label'   => Module::t('geonames', 'Timezones'),
            'url'     => ['/geonames/timezones/index']
        ],
        [
            'label'   => Module::t('geonames', 'Countries'),
            'url'     => ['/geonames/countries/index']
        ],
        [
            'label' => Module::t('geonames', 'Create'),
            'items' => [
                [
                    'label'   => Module::t('geonames', 'New timezone'),
                    'url'     => ['/geonames/timezones/create']
                ],
                [
                    'label'   => Module::t('geonames', 'New country'),
                    'url'     => ['/geonames/countries/create']
                ]
            ]
        ]
    ]
]) ?>
