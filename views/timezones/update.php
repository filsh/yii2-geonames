<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;

/* @var $this yii\web\View */
/* @var $model filsh\geonames\models\Timezones */

$this->title = Yii::t('geonames', 'Update {modelClass}: ', [
    'modelClass' => 'Timezones',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('geonames', 'Timezones'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('geonames', 'Update');
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
                        ['label' => Yii::t('user', 'Timezone details'), 'url' => ['/geonames/timezones/update', 'id' => $model->id]],
                        ['label' => Yii::t('user', 'Timezone translations'), 'url' => ['/geonames/timezones/update-translations', 'id' => $model->id]],
                        '<hr>',
                        [
                            'label' => Yii::t('user', 'Delete'),
                            'url'   => ['/geonames/timezones/delete', 'id' => $model->id],
                            'linkOptions' => [
                                'class' => 'text-danger',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('user', 'Are you sure you want to delete this record?')
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