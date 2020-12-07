<?php


namespace monitoring\modules\eksekutif\modules\prodi\controllers;

use common\helpers\kriteria9\K9ProdiJsonHelper;
use common\models\kriteria9\led\prodi\K9LedProdi;

class LedController extends \akreditasi\modules\kriteria9\modules\prodi\controllers\LedController
{
    protected $lihatKriteriaView = '@monitoring/modules/eksekutif/modules/prodi/views/led/isi-kriteria';
    protected $lihatNonKriteriaView = '@monitoring/modules/eksekutif/modules/prodi/views/led/isi-non_kriteria';

    public function actionLihatKriteria($led, $kriteria, $prodi)
    {
        $ledProdi = K9LedProdi::findOne(['id' => $led]);
        $akreditasiProdi = $ledProdi->akreditasiProdi;
        $programStudi = $akreditasiProdi->prodi;
        $attr = 'k9LedProdiKriteria' . $kriteria . 's';
        $modelLed = $ledProdi->$attr;

        $json = K9ProdiJsonHelper::getJsonKriteriaLed($kriteria);
        $poinKriteria = $json->butir;
        return $this->render($this->lihatKriteriaView, [
            'model' => $modelLed,
            'poinKriteria' => $poinKriteria,
            'untuk' => 'lihat',
            'kriteria' => $kriteria,
            'prodi' => $programStudi,
            'akreditasiProdi' => $akreditasiProdi
        ]);
    }

    public function actionLihatNonKriteria($led, $prodi, $poin)
    {
        $ledProdi = K9LedProdi::findOne($led);
        $akreditasiProdi = $ledProdi->akreditasiProdi;
        $programStudi = $akreditasiProdi->prodi;

        switch ($poin) {
            case 'A':
                $modelNarasi = $ledProdi->narasiEksternal;
                $json = K9ProdiJsonHelper::getJsonLedKondisiEksternal();
                break;
            case 'B':
                $modelNarasi = $ledProdi->narasiProfil;
                $json = K9ProdiJsonHelper::getJsonLedProfil();
                break;
            case 'D':
                $modelNarasi = $ledProdi->narasiAnalisis;
                $json = K9ProdiJsonHelper::getJsonLedAnalisis();
                break;
        }

        $poin = $json->butir;

        $detail = $modelNarasi->documents;


        $untuk = 'lihat';

        return $this->render($this->lihatNonKriteriaView, [
            'ledProdi' => $ledProdi,
            'json' => $json,
            'poin' => $poin,
            'modelNarasi' => $modelNarasi,
            'detail' => $detail,
            'untuk' => $untuk,
            'prodi' => $programStudi,
            'akreditasiProdi' => $akreditasiProdi
        ]);
    }
}
