<?php
/**
 * @var $this yii\web\View
 */
?>

<?php
if(Yii::$app->controller !== null) {
    $this->render('_alert', [
        'module' => Yii::$app->controller->module
    ]);
}
?>

<?= $this->render('_menu') ?>

<div style="padding: 10px 0">
    <?= $content ?>
</div>