<?php


namespace monitoring\modules\eksekutif\modules\institusi\controllers;

use common\helpers\kriteria9\K9InstitusiDirectoryHelper;
use common\helpers\kriteria9\K9InstitusiJsonHelper;
use common\helpers\kriteria9\K9ProdiDirectoryHelper;
use common\helpers\kriteria9\K9ProdiJsonHelper;
use common\models\FakultasAkademi;
use common\models\kriteria9\akreditasi\K9Akreditasi;
use common\models\kriteria9\akreditasi\K9AkreditasiInstitusi;
use common\models\kriteria9\led\institusi\K9InstitusiEksporDokumen;
use common\models\kriteria9\led\prodi\K9ProdiEksporDokumen;
use yii\data\ActiveDataProvider;

class AkreditasiController extends BaseController
{

    public function actionIndexProdi()
    {

        //Akreditasi Prodi
        $fakultasDataProvider = new ActiveDataProvider(['query' => FakultasAkademi::find()]);


        $akreditasiTerakhir = K9Akreditasi::find()->where(['jenis_akreditasi' => 'prodi'])->orderBy('id DESC')->one();

        return $this->render('index-prodi',
            ['fakultasDataProvider' => $fakultasDataProvider, 'akreditasiTerakhir' => $akreditasiTerakhir]);
    }

    public function actionIndex()
    {

        $profilInstitusi = $this->getProfilInstitusi();
        //akreditasiInstitusi
        $aptDataProvider = new ActiveDataProvider(['query' => K9AkreditasiInstitusi::find()->orderBy('id DESC')]);

        return $this->render('index', ['aptDataProvider' => $aptDataProvider, 'profilInstitusi' => $profilInstitusi]);
    }

    public function actionDetail($id, $fakultas, $prodi)
    {

        $modelProdi = $this->findProdi($prodi);
        $akreditasiProdi = $modelProdi->getK9AkreditasiProdis()->where(['id' => $id])->one();
        $fakultasAkademi = $modelProdi->fakultasAkademi;

        //led
        $json_kriteria = K9ProdiJsonHelper::getAllJsonLed();
        $json_eksternal = K9ProdiJsonHelper::getJsonLedKondisiEksternal();
        $json_profil = K9ProdiJsonHelper::getJsonLedProfil();
        $json_analisis = K9ProdiJsonHelper::getJsonLedAnalisis();
        $ledProdi = $akreditasiProdi->k9LedProdi;
        $dokumenLed = K9ProdiEksporDokumen::findAll(['id_led_prodi' => $ledProdi->id]);
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
            'fakultasAkademi' => $fakultasAkademi
        ]);
    }

    public function actionDetailPt($id)
    {

        $profilInstitusi = $this->getProfilInstitusi();
        $apt = K9AkreditasiInstitusi::findOne($id);

        //led
        $jsonLed = K9InstitusiJsonHelper::getAllJsonLed();
        $json_eksternal = K9InstitusiJsonHelper::getJsonLedKondisiEksternal();
        $json_profil = K9InstitusiJsonHelper::getJsonLedProfil();
        $json_analisis = K9InstitusiJsonHelper::getJsonLedAnalisis();
        $ledInstitusi = $apt->k9LedInstitusi;
        $dokumenLed = K9InstitusiEksporDokumen::findAll(['id_led_institusi' => $ledInstitusi->id]);
        $kriteriaLed = $this->getArrayKriteraLedInstitusi($ledInstitusi->id);
        $urlLed = K9InstitusiDirectoryHelper::getDokumenLedUrl($ledInstitusi->akreditasiInstitusi);

        $modelEksternal = $ledInstitusi->narasiEksternal;
        $modelProfil = $ledInstitusi->narasiProfil;
        $modelAnalisis = $ledInstitusi->narasiAnalisis;
        //lk
        $jsonLk = K9InstitusiJsonHelper::getAllJsonLk();
        $lkInstitusi = $apt->k9LkInstitusi;
        $kriteriaLk = $this->getArrayKriteriaLkInstitusi($lkInstitusi->id);

        return $this->render('detail-pt', [
            'profilInstitusi' => $profilInstitusi,
            'akreditasiInstitusi' => $apt,
            'jsonLed' => $jsonLed,
            'json_eksternal' => $json_eksternal,
            'json_profil' => $json_profil,
            'json_analisis' => $json_analisis,
            'led' => $ledInstitusi,
            'dataDokumen' => $dokumenLed,
            'modelDokumen' => null,
            'kriteriaLed' => $kriteriaLed,
            'path' => $urlLed,
            'jsonLk' => $jsonLk,
            'lkInstitusi' => $lkInstitusi,
            'kriteriaLk' => $kriteriaLk,
            'untuk' => 'lihat',
            'modelEksternal' => $modelEksternal,
            'modelAnalisis' => $modelAnalisis,
            'modelProfil' => $modelProfil,
        ]);
    }
}
