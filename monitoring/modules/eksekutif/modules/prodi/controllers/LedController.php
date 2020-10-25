<?php


namespace monitoring\modules\eksekutif\modules\prodi\controllers;

use common\helpers\kriteria9\K9ProdiDirectoryHelper;
use common\helpers\kriteria9\K9ProdiJsonHelper;
use common\models\kriteria9\led\prodi\K9ProdiEksporDokumen;
use common\models\kriteria9\led\prodi\K9LedProdi;
use Yii;

class LedController extends BaseController
{

    public function actionLihat($led, $kriteria, $prodi)
    {
        $modelProdi = $this->findProdi($prodi);
        $modelLedClass = 'common\\models\\kriteria9\\led\\prodi\\K9LedProdiKriteria' . $kriteria;
        $modelLed = call_user_func($modelLedClass . '::findOne', $led);

        $akreditasiProdi = $modelLed->ledProdi->akreditasiProdi;
        $modelNarasiClass = 'akreditasi\\models\\kriteria9\\led\\prodi\\K9LedProdiNarasiKriteria' . $kriteria . 'Form';
        $modelNarasi = call_user_func($modelNarasiClass . '::findOne', ['id_led_prodi_kriteria' . $kriteria => $modelLed->id]);
        $relasiNarasiAttr = 'ledProdiKriteria' . $kriteria;


        $json = K9ProdiJsonHelper::getJson('led');
        $dataKriteria = $json[$kriteria - 1];
        $poinKriteria = $dataKriteria['butir'];

        $detailUrl = K9ProdiDirectoryHelper::getDetailLedUrl($akreditasiProdi);


        return $this->render('lihat-kriteria', [
            'akreditasiProdi'=>$akreditasiProdi,
            'modelProdi'=>$modelProdi,
            'model' => $modelLed,
            'modelNarasi' => $modelNarasi,
            'poinKriteria' => $poinKriteria,
            'path' => $detailUrl,
        ]);
    }

    public function actionDownloadDetail($kriteria, $dokumen, $led, $jenis)
    {
        ini_set('max_execution_time', 5 * 60);
        $led = K9LedProdi::findOne($led);
        $namespace = 'common\\models\\kriteria9\\led\\prodi';
        $className = "$namespace\\K9LedProdiKriteria$kriteria" . 'Detail';
        $model = call_user_func($className . '::findOne', $dokumen);
        $file = K9ProdiDirectoryHelper::getDokumenLedPath($led->akreditasiProdi) . "/$jenis/{$model->isi_dokumen}";
        return Yii::$app->response->sendFile($file);
    }
}
