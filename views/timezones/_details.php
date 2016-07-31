<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php $this->beginContent('@filsh/geonames/views/timezones/update.php', ['model' => $model]) ?>

    <?= $this->render('_form', ['model' => $model]) ?>

<?php $this->endContent() ?>