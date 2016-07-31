<?php

use filsh\geonames\Module;

/**
 * @var yii\widgets\ActiveForm    $form
 * @var filsh\geonames\models\Country $model
 */
?>

<?= $form->field($model, 'iso')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'iso3')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'iso_numeric')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'fips')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?php foreach(Module::getInstance()->supportLanguages as $language) {
    echo $form->field($model->translate($language), "[$language]name")->textInput(['maxlength' => true]);
} ?>

<?= $form->field($model, 'capital')->textInput(['maxlength' => true]) ?>

<?php foreach(Module::getInstance()->supportLanguages as $language) {
    echo $form->field($model->translate($language), "[$language]capital")->textInput(['maxlength' => true]);
} ?>

<?= $form->field($model, 'area')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'population')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'continent')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'tld')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'currency_code')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'currency_name')->textInput(['maxlength' => true]) ?>

<?php foreach(Module::getInstance()->supportLanguages as $language) {
    echo $form->field($model->translate($language), "[$language]currency_name")->textInput(['maxlength' => true]);
} ?>

<?= $form->field($model, 'phone_code')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'postal_code_format')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'postal_code_regex')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'languages')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'geoname_id')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'neighbours')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'equivalent_fips_code')->textInput(['maxlength' => true]) ?>
