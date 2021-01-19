<?php


namespace monitoring\modules\eksekutif\modules\fakultas\controllers;

use common\helpers\kriteria9\K9ProdiDirectoryHelper;
use common\helpers\kriteria9\K9ProdiJsonHelper;

class AkreditasiController extends BaseController
{

    public function actionIndex($fakultas)
    {
        $modelFakultas = $this->findFakultas($fakultas);
        $prodis = $modelFakultas->programStudis;

        return $this->render('index', ['prodis' => $prodis, 'modelFakultas' => $modelFakultas]);
    }

    public function actionDetail($id, $prodi, $fakultas)
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
        $dataDokumen = $lkProdi->eksporDokumen;
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
            'fakultasAkademi' => $fakultasAkademi,
            'dataDokumen' => $dataDokumen,
            'path' => K9ProdiDirectoryHelper::getDokumenLkUrl($akreditasiProdi)

        ]);
    }
}
