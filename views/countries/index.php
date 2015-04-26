<?php

use filsh\geonames\Module;
use filsh\geonames\models\Countries;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Url;
/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var Countries $filterModel
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
        'name',
        'capital',
        'area',
        'population',
        'continent',
        'tld',
        'currency_code',
        'currency_name',
        'phone_code',
        'postal_code_format',
        'postal_code_regex',
        'languages',
        'geoname_id',
        'neighbours',
        'equivalent_fips_code',
        [
            'class'      => ActionColumn::className(),
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