<?php


namespace monitoring\modules\eksekutif\modules\prodi\controllers;

use common\helpers\kriteria9\K9ProdiDirectoryHelper;
use common\helpers\kriteria9\K9ProdiJsonHelper;
use common\models\kriteria9\led\prodi\K9ProdiEksporDokumen;
use Yii;
use yii\data\ActiveDataProvider;

class AkreditasiController extends BaseController
{

    public function actionIndex($prodi)
    {
        $modelProdi = $this->findProdi($prodi);
        $akreditasiDataProvider = new ActiveDataProvider(['query' => $modelProdi->getK9AkreditasiProdis()]);

        return $this->render('index', ['prodi' => $modelProdi, 'akreditasiDataProvider' => $akreditasiDataProvider]);
    }

    public function actionDetail($id, $prodi)
    {

        $modelProdi = $this->findProdi($prodi);
        $akreditasiProdi = $modelProdi->getK9AkreditasiProdis()->where(['id' => $id])->one();

        //led
        $jsonLed = K9ProdiJsonHelper::getAllJsonLed();
        $json_kriteria = K9ProdiJsonHelper::getAllJsonLed();
        $json_eksternal = K9ProdiJsonHelper::getJsonLedKondisiEksternal();
        $json_profil = K9ProdiJsonHelper::getJsonLedProfil();
        $json_analisis = K9ProdiJsonHelper::getJsonLedAnalisis();
        $ledProdi = $akreditasiProdi->k9LedProdi;
        $dokumenLed = $ledProdi->getEksporDokumen()->orderBy('kode_dokumen')->all();
        $kriteriaLed = $this->getArrayKriteraLed($ledProdi->id);
        $urlLed = K9ProdiDirectoryHelper::getDokumenLedUrl($ledProdi->akreditasiProdi);
        $modelEksternal = $ledProdi->narasiEksternal;
        $modelProfil = $ledProdi->narasiProfil;
        $modelAnalisis = $ledProdi->narasiAnalisis;


        //lk
        $jsonLk = K9ProdiJsonHelper::getAllJsonLk($modelProdi->jenjang);
        $lkProdi = $akreditasiProdi->k9LkProdi;
        $kriteriaLk = $this->getArrayKriteriaLk($lkProdi->id);
        return $this->render('detail', [
            'modelProdi' => $modelProdi,
            'akreditasiProdi' => $akreditasiProdi,
            'jsonLed' => $jsonLed,
            'ledProdi' => $ledProdi,
            'dokumenLed' => $dokumenLed,
            'kriteriaLed' => $kriteriaLed,
            'urlLed' => $urlLed,
            'jsonLk' => $jsonLk,
            'lkProdi' => $lkProdi,
            'kriteriaLk' => $kriteriaLk,
            'json' => $json_kriteria,
            'json_eksternal' => $json_eksternal,
            'json_profil' => $json_profil,
            'json_analisis' => $json_analisis,
            'modelEksternal' => $modelEksternal,
            'modelAnalisis' => $modelAnalisis,
            'modelProfil' => $modelProfil,
        ]);
    }

    public function actionDownloadDokumen($dokumen)
    {
        ini_set('max_execution_time', 5 * 60);
        $model = K9ProdiEksporDokumen::findOne($dokumen);
        $file = K9ProdiDirectoryHelper::getDokumenLedPath($model->ledProdi->akreditasiProdi) . "/{$model->nama_dokumen}";
        return Yii::$app->response->sendFile($file);
    }
}
