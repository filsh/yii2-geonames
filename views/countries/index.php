<?php

use filsh\geonames\Module;
use filsh\geonames\models\Country;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Url;
/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var Country $filterModel
 */

$this->title = Module::t('geonames', 'Countries');
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $this->beginContent('@filsh/geonames/views/layout.php') ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $filterModel,
    'layout'       => "{items}\n{pager}",
    'columns'      => [
        'iso',
        'iso3',
        'iso_numeric',
        'fips',
        [
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function($model) {
                $names = [$model->name];
                foreach(Module::getInstance()->translateLanguages as $language) {
                    if(($name = $model->translate($language)->name) !== null) {
                        $names[] = $name . '(' . $language . ')';
                    }
                }
                if(!empty($names)) {
                    return implode($names, '</br>');
                }
            }
        ],
        [
            'attribute' => 'capital',
            'format' => 'raw',
            'value' => function($model) {
                $names = [$model->capital];
                foreach(Module::getInstance()->translateLanguages as $language) {
                    if(($name = $model->translate($language)->capital) !== null) {
                        $names[] = $name . '(' . $language . ')';
                    }
                }
                if(!empty($names)) {
                    return implode($names, '</br>');
                }
            }
        ],
        'area',
        'population',
        'continent',
        'tld',
        'currency_code',
        [
            'attribute' => 'currency_name',
            'format' => 'raw',
            'value' => function($model) {
                $names = [$model->currency_name];
                foreach(Module::getInstance()->translateLanguages as $language) {
                    if(($name = $model->translate($language)->currency_name) !== null) {
                        $names[] = $name . '(' . $language . ')';
                    }
                }
                if(!empty($names)) {
                    return implode($names, '</br>');
                }
            }
        ],
        'phone_code',
        'postal_code_format',
        'postal_code_regex',
        'languages',
        'geoname_id',
        'neighbours',
        'equivalent_fips_code',
        [
            'class'      => ActionColumn::class,
            'template'   => '{update} {delete}',
            'urlCreator' => function ($action, $model) {
                return Url::to(['countries/' . $action, 'id' => $model['id']]);
            },
            'options' => [
                'style' => 'width: 5%'
            ],
        ]
    ],
]) ?>

<?php $this->endContent() ?>