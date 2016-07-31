<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use filsh\geonames\Module;

/* @var $this yii\web\View */
/* @var $model filsh\geonames\models\Timezone */

$this->title = Module::t('geonames', 'Create Timezones');
$this->params['breadcrumbs'][] = ['label' => Module::t('geonames', 'Timezones'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
                        ['label' => Module::t('geonames', 'Timezone details'), 'url' => ['/geonames/timezones/create']],
                        ['label' => Module::t('geonames', 'Timezone translations'), 'url' => '#', 'options' => [
                            'class' => 'disabled',
                            'onclick' => 'return false;'
                        ]],
                    ]
                ]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-body">
                <?= $this->render('_form', ['model' => $model]) ?>
            </div>
        </div>
    </div>
</div>