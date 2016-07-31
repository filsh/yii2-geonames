<?php

use filsh\geonames\Module;

/**
 * @var yii\widgets\ActiveForm    $form
 * @var filsh\geonames\models\Timezone $model
 */
?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?php foreach(Module::getInstance()->supportLanguages as $language) {
    echo $form->field($model->translate($language), "[$language]title")->textInput(['maxlength' => true]);
} ?>

<?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'timezone')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'offset_gmt')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'offset_dst')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'offset_raw')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'order_popular')->textInput(['maxlength' => true]) ?>
