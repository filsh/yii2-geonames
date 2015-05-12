<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use filsh\geonames\Module;
?>

<?php $this->beginContent('@filsh/geonames/views/timezones/update.php', ['model' => $model]) ?>

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'enableAjaxValidation'   => true,
        'enableClientValidation' => false,
        'fieldConfig' => [
            'horizontalCssClasses' => [
                'wrapper' => 'col-sm-9',
            ]
        ],
    ]); ?>

    <?php
        foreach($model->getLanguages() as $language) {
            $model->language = $language;
            ?>
            <fieldset>
                <legend><?= strtoupper($language) ?></legend>
                <?= $form->field($model, 'title')->textInput(['name' => 'translations[' . $language . ']', 'maxlength' => true]) ?>
            </fieldset>
            <?php
        }
    ?>

    <div class="form-group">
        <div class="col-lg-offset-3 col-lg-9">
            <?= Html::submitButton(Module::t('geonames', 'Update'), ['class' => 'btn btn-block btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

<?php $this->endContent() ?>