<?php

namespace filsh\geonames\controllers;

use Yii;
use filsh\geonames\models\Country;

class CountriesController extends \yii\web\Controller
{
    public function actionIndex()
    {
        /* @var $filterModel Country */
        $filterModel = Yii::createObject(Country::class);
        $dataProvider = $filterModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'filterModel'  => $filterModel,
        ]);
    }
}