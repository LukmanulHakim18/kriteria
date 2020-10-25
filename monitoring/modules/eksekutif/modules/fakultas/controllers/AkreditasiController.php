<?php


namespace monitoring\modules\eksekutif\modules\fakultas\controllers;

use common\helpers\kriteria9\K9ProdiDirectoryHelper;
use common\helpers\kriteria9\K9ProdiJsonHelper;
use common\models\kriteria9\led\prodi\K9ProdiEksporDokumen;

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

        //led
        $jsonLed = K9ProdiJsonHelper::getJson('led', '');
        $ledProdi = $akreditasiProdi->k9LedProdi;
        $dokumenLed = K9ProdiEksporDokumen::findAll(['id_led_prodi' => $ledProdi->id]);
        $kriteriaLed = $this->getArrayKriteraLed($ledProdi->id);
        $urlLed = K9ProdiDirectoryHelper::getDokumenLedUrl($ledProdi->akreditasiProdi);

        //lk
        $jsonLk = K9ProdiJsonHelper::getJson('lk', $modelProdi->jenjang);
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
            'kriteriaLk' => $kriteriaLk
        ]);
    }
}
