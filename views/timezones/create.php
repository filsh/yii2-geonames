<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model filsh\geonames\models\Timezones */

$this->title = Yii::t('geonames', 'Create Timezones');
$this->params['breadcrumbs'][] = ['label' => Yii::t('geonames', 'Timezones'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="timezones-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>