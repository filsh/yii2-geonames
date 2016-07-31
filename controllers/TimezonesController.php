<?php

namespace filsh\geonames\controllers;

use Yii;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\web\NotFoundHttpException;
use filsh\geonames\Module;
use filsh\geonames\models\Timezone;

class TimezonesController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
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
        /* @var $filterModel Timezone */
        $filterModel = Yii::createObject(Timezone::class);
        $dataProvider = $filterModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'filterModel'  => $filterModel,
        ]);
    }

    /**
     * Creates a new Timezone model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /** @var Timezone $model */
        $model = Yii::createObject(Timezone::class);

        foreach (Yii::$app->request->post('Translation', []) as $language => $data) {
            foreach ($data as $attribute => $translation) {
                $model->translate($language)->$attribute = $translation;
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Timezone model.
     * If update is successful, the browser will be refreshed page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $this->performAjaxValidation($model);

        foreach (Yii::$app->request->post('Translation', []) as $language => $data) {
            foreach ($data as $attribute => $translation) {
                $model->translate($language)->$attribute = $translation;
            }
        }

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
     * Deletes an existing Timezone model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param  integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->getSession()->setFlash('success', Module::t('geonames', 'Timezone has been deleted'));

        return $this->redirect(['index']);
    }

    /**
     * Finds the Timezone model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Timezone the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        /** @var Timezone $model */
        $model = Yii::createObject(Timezone::class);
        $model = $model::find()->with('translations')->where(['id' => $id])->one();
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