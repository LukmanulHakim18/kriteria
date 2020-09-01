<?php


namespace monitoring\modules\eksekutif\modules\institusi\controllers;

use common\helpers\kriteria9\K9InstitusiDirectoryHelper;
use common\helpers\kriteria9\K9InstitusiJsonHelper;
use common\models\kriteria9\led\institusi\K9DokumenLedInstitusi;
use common\models\kriteria9\led\institusi\K9LedInstitusi;
use Yii;

class LedInstitusiController extends BaseController
{
    public function actionDownloadDokumen($dokumen)
    {
        ini_set('max_execution_time', 5 * 60);
        $model = K9DokumenLedInstitusi::findOne($dokumen);
        $file = K9InstitusiDirectoryHelper::getDokumenLedPath($model->ledInstitusi->akreditasiInstitusi) . "/{$model->nama_dokumen}";
        return Yii::$app->response->sendFile($file);
    }

    public function actionLihat($led, $kriteria)
    {
        $profilInstitusi = $this->getProfilInstitusi();
        $led = K9LedInstitusi::findOne(['id_akreditasi_institusi'=>$led]);
        $modelLedClass = 'common\\models\\kriteria9\\led\\institusi\\K9LedInstitusiKriteria' . $kriteria;
        $modelLed = call_user_func($modelLedClass . '::findOne', ['id_led_institusi'=>$led->id]);

        $modelNarasiClass = 'akreditasi\\models\\kriteria9\\led\\institusi\\K9LedInstitusiNarasiKriteria' . $kriteria . 'Form';
        $modelNarasi = call_user_func($modelNarasiClass . '::findOne', ['id_led_institusi_kriteria' . $kriteria => $modelLed->id]);
        $relasiNarasiAttr = 'ledInstitusiKriteria' . $kriteria;

        $dataKriteria = K9InstitusiJsonHelper::getJsonKriteriaLed($kriteria);
        $poinKriteria = $dataKriteria['butir'];

        $akreditasiInstitusi = $modelLed->ledInstitusi->akreditasiInstitusi;

        $realPath = K9InstitusiDirectoryHelper::getDetailLedUrl($akreditasiInstitusi);


        return $this->render('lihat-kriteria', [
            'profilInstitusi'=>$profilInstitusi,
            'akreditasiInstitusi'=>$akreditasiInstitusi,
            'model' => $modelLed,
            'modelNarasi' => $modelNarasi,
            'poinKriteria' => $poinKriteria,
            'path' => $realPath,

        ]);
    }

    public function actionDownloadDetail($kriteria, $dokumen, $led, $jenis)
    {
        ini_set('max_execution_time', 5 * 60);
        $led = K9LedInstitusi::findOne($led);
        $namespace = 'common\\models\\kriteria9\\led\\institusi';
        $className = "$namespace\\K9LedInstitusiKriteria$kriteria" . "Detail";
        $model = call_user_func($className . '::findOne', $dokumen);
        $file = K9InstitusiDirectoryHelper::getDokumenLedPath($led->akreditasiInstitusi) . "/$jenis/{$model->isi_dokumen}";
        return Yii::$app->response->sendFile($file);
    }
}
