<?php

namespace filsh\geonames\controllers;

use Yii;
use filsh\geonames\models\Countries;

class CountriesController extends \yii\web\Controller
{
    public function actionIndex()
    {
        /* @var $filterModel Countries */
        $filterModel = Yii::createObject([
            'class'    => Countries::className(),
            'scenario' => Countries::SCENARIO_SEARCH,
        ]);
        $dataProvider = $filterModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'filterModel'  => $filterModel,
        ]);
    }
}