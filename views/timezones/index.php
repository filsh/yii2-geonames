<?php

use filsh\geonames\Module;
use filsh\geonames\models\Timezones;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Url;
/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var Timezones $filterModel
 */

$this->title = Module::t('geonames', 'Timezones');
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $this->beginContent('@filsh/geonames/views/layout.php') ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $filterModel,
    'layout'       => "{items}\n{pager}",
    'columns'      => [
        'country',
        'timezone',
        'offset_gmt',
        'offset_dst',
        'offset_raw',
        [
            'class'      => ActionColumn::className(),
            'template'   => '{update} {delete}',
            'urlCreator' => function ($action, $model) {
                return Url::to(['timezones/' . $action, 'id' => $model['id']]);
            },
            'options' => [
                'style' => 'width: 5%'
            ],
        ]
    ],
]) ?>

<?php $this->endContent() ?>