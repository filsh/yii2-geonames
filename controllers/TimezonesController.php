<?php

namespace filsh\geonames\controllers;

use Yii;
use filsh\geonames\models\Timezones;

class TimezonesController extends \yii\web\Controller
{
    public function actionIndex()
    {
        /* @var $filterModel Timezones */
        $filterModel = Yii::createObject([
            'class'    => Timezones::className(),
            'scenario' => Timezones::SCENARIO_SEARCH,
        ]);
        $dataProvider = $filterModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'filterModel'  => $filterModel,
        ]);
    }
}