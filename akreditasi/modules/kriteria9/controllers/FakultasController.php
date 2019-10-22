<?php
/**
 * mutu-v2
 * @author Adryan Eka Vandra <adryanekavandra@gmail.com>
 */
/**
 * Class FakultasController
 * @package akreditasi\modules\kriteria9\controllers
 */


namespace akreditasi\modules\kriteria9\controllers;


use akreditasi\models\PencarianFakultasForm;
use common\models\FakultasAkademi;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class FakultasController extends Controller
{

    /**
     * @param $action
     * @return bool
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->layout="main";
        return parent::beforeAction($action);
    }

    /**
     * Mencari fakultas akademi yang tersedia, jika ditemukan lakukan redirect ke halaman fakultas.
     * Jika tidak maka throw NotFoundHttpException.
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionArsip(){

        $model = new PencarianFakultasForm();
        $fakultas = FakultasAkademi::find()->all();
        $dataFakultas = ArrayHelper::map($fakultas,'id','nama');

        if($model->load(\Yii::$app->request->post())){
            $url = $model->cari();
            if(!$url) throw new NotFoundHttpException('Data yang anda cari tidak ditemukan');

            return $this->redirect($url) ;
        }

        return $this->render('arsip',[
            'model'=>$model,
            'dataFakultas'=>$dataFakultas
        ]);
    }

}