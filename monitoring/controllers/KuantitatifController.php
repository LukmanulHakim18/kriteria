<?php


namespace monitoring\controllers;


use common\helpers\kriteria9\K9InstitusiDirectoryHelper;
use common\helpers\kriteria9\K9ProdiDirectoryHelper;
use common\models\kriteria9\akreditasi\K9AkreditasiInstitusi;
use common\models\kriteria9\akreditasi\K9AkreditasiProdi;
use common\models\kriteria9\kuantitatif\institusi\K9DataKuantitatifInstitusi;
use common\models\kriteria9\kuantitatif\prodi\K9DataKuantitatifProdi;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class KuantitatifController extends \yii\web\Controller
{

    public function actionProdi($id)
    {
        $akreditasiProdi = K9AkreditasiProdi::findOne($id);
        if (!$akreditasiProdi) {
            throw new NotFoundHttpException();
        }
        $dataProvider = new ActiveDataProvider(['query' => $akreditasiProdi->getKuantitatif()]);

        return $this->renderAjax('_list', ['dataProvider' => $dataProvider, 'untuk' => 'prodi']);

    }

    public function actionInstitusi($id)
    {
        $akreditasiInstitusi = K9AkreditasiInstitusi::findOne($id);
        if (!$akreditasiInstitusi) {
            throw new NotFoundHttpException();
        }
        $dataProvider = new ActiveDataProvider(['query' => $akreditasiInstitusi->getKuantitatif()]);

        return $this->renderAjax('_list', ['dataProvider' => $dataProvider, 'untuk' => 'institusi']);

    }

    public function actionDownloadProdi($id)
    {
        $dokumen = K9DataKuantitatifProdi::findOne($id);
        if (!$dokumen) {
            throw new NotFoundHttpException();
        }

        $path = K9ProdiDirectoryHelper::getKuantitatifPath($dokumen->akreditasiProdi);
        return \Yii::$app->response->sendFile("$path/$dokumen->isi_dokumen");

    }

    public function actionDownloadInstitusi($id)
    {
        $dokumen = K9DataKuantitatifInstitusi::findOne($id);
        if (!$dokumen) {
            throw new NotFoundHttpException();
        }

        $path = K9InstitusiDirectoryHelper::getKuantitatifPath($dokumen->akreditasiInstitusi);
        return \Yii::$app->response->sendFile("$path/$dokumen->isi_dokumen");

    }
}
