<?php

use yii\bootstrap\Nav;
use filsh\geonames\Module;

/* @var $this yii\web\View */
/* @var $model filsh\geonames\models\Country */

$this->title = Module::t('geonames', 'Update {modelClass}: ', [
    'modelClass' => 'Country',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Module::t('geonames', 'Countries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Module::t('geonames', 'Update');
?>

<?= $this->render('/_alert', [
    'module' => Yii::$app->getModule('geonames'),
]) ?>

<?= $this->render('/_menu') ?>

<div class="row">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <?= Nav::widget([
                    'options' => [
                        'class' => 'nav-pills nav-stacked'
                    ],
                    'items' => [
                        ['label' => Module::t('geonames', 'Country details'), 'url' => ['/geonames/countries/update', 'id' => $model->id]],
                        '<hr>',
                        [
                            'label' => Module::t('geonames', 'Delete'),
                            'url'   => ['/geonames/countries/delete', 'id' => $model->id],
                            'linkOptions' => [
                                'class' => 'text-danger',
                                'data-method' => 'post',
                                'data-confirm' => Module::t('geonames', 'Are you sure you want to delete this record?')
                            ],
                        ],
                    ]
                ]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-body">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>
