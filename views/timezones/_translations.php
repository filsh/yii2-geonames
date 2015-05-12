<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Yii;
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
        foreach(Yii::$app->controller->module->supportLanguages as $language) {
            $model->language = $language;
            
            echo $form->field($model, 'title')
                ->textInput([
                    'id' => 'timezones-title-' . $language,
                    'name' => Html::getInputName($model, 'translations') . '[' . $language . ']',
                    'maxlength' => true
                ])
                ->label(strtoupper($language));
        }
    ?>

    <div class="form-group">
        <div class="col-lg-offset-3 col-lg-9">
            <?= Html::submitButton(Module::t('geonames', 'Update'), ['class' => 'btn btn-block btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

<?php $this->endContent() ?>