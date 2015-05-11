<?php

/**
 * @var yii\widgets\ActiveForm    $form
 * @var filsh\geonames\models\Timezones $model
 */
?>

<?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'timezone')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'offset_gmt')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'offset_dst')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'offset_raw')->textInput(['maxlength' => true]) ?>
