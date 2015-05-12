<?php

namespace filsh\geonames\controllers;

use Yii;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use filsh\geonames\Module;
use filsh\geonames\models\Timezones;
use filsh\geonames\models\TimezoneSearch;

class TimezonesController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    
    /**
     * Lists all Timezones models.
     * @return mixed
     */
    public function actionIndex()
    {
        /* @var $filterModel TimezoneSearch */
        $filterModel = Yii::createObject(TimezoneSearch::className());
        $dataProvider = $filterModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'filterModel'  => $filterModel,
        ]);
    }
    
    /**
     * Creates a new Timezones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /** @var Timezones $model */
        $model = Yii::createObject([
            'class'    => Timezones::className(),
            'scenario' => Timezones::SCENARIO_CREATE,
        ]);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Timezones model.
     * If update is successful, the browser will be refreshed page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Timezones::SCENARIO_UPDATE;

        $this->performAjaxValidation($model);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Module::t('geonames', 'Timezone details have been updated'));
            return $this->refresh();
        } else {
            return $this->render('_details', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Updates an translations for existing Timezones model.
     * If update is successful, the browser will be refreshed page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateTranslations($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Timezones::SCENARIO_UPDATE_TRANSLATIONS;

        $this->performAjaxValidation($model);
        
        if ($model->load(Yii::$app->request->post()) && $model->saveTranslations()) {
            Yii::$app->getSession()->setFlash('success', Module::t('geonames', 'Timezone translations have been updated'));
            return $this->refresh();
        } else {
            return $this->render('_translations', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Finds the Timezones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Timezones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        /** @var Timezones $model */
        $model = Yii::createObject(Timezones::className());
        if (($model = $model::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * Performs AJAX validation.
     * @param array|Model $model
     * @throws ExitException
     */
    protected function performAjaxValidation($model)
    {
        if (Yii::$app->request->isAjax && !Yii::$app->request->isPjax) {
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                echo json_encode(ActiveForm::validate($model));
                Yii::$app->end();
            }
        }
    }
}