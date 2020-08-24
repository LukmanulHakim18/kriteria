<?php


namespace monitoring\modules\eksekutif\modules\institusi\controllers;

use common\helpers\kriteria9\K9ProdiDirectoryHelper;
use common\helpers\kriteria9\K9ProdiJsonHelper;
use common\models\kriteria9\led\prodi\K9DokumenLedProdi;

class AkreditasiController extends BaseController
{

    public function actionDetail($id, $fakultas, $prodi)
    {

        $modelProdi = $this->findProdi($prodi);
        $akreditasiProdi = $modelProdi->getK9AkreditasiProdis()->where(['id' => $id])->one();

        //led
        $jsonLed = K9ProdiJsonHelper::getJson('led', '');
        $ledProdi = $akreditasiProdi->k9LedProdi;
        $dokumenLed = K9DokumenLedProdi::findAll(['id_led_prodi' => $ledProdi->id]);
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

    public function actionDetailPt($id)
    {
    }
}
