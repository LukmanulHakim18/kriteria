<?php


namespace monitoring\modules\eksekutif\modules\prodi\controllers;

use akreditasi\models\kriteria9\forms\led\K9DetailLedProdiLinkForm;
use akreditasi\models\kriteria9\forms\led\K9DetailLedProdiTeksForm;
use akreditasi\models\kriteria9\forms\led\K9DetailLedProdiUploadForm;
use common\helpers\kriteria9\K9ProdiDirectoryHelper;
use common\helpers\kriteria9\K9ProdiJsonHelper;
use common\models\kriteria9\led\prodi\K9ProdiEksporDokumen;
use common\models\kriteria9\led\prodi\K9LedProdi;
use Yii;

class LedController extends \akreditasi\modules\kriteria9\modules\prodi\controllers\LedController
{


    public function actionLihatKriteria($led, $kriteria, $prodi)
    {
        $ledProdi = K9LedProdi::findOne(['id'=>$led]);
        $akreditasiProdi = $ledProdi->akreditasiProdi;
        $programStudi = $akreditasiProdi->prodi;
        $attr = 'k9LedProdiKriteria' . $kriteria . 's';
        $modelLed = $ledProdi->$attr;

        $json = K9ProdiJsonHelper::getJsonKriteriaLed($kriteria);
        $poinKriteria = $json->butir;
        return $this->render('isi-kriteria', [
            'model' => $modelLed,
            'poinKriteria' => $poinKriteria,
            'untuk'=>'lihat',
            'kriteria'=>$kriteria,
            'modelProdi'=>$programStudi,
            'akreditasiProdi'=>$akreditasiProdi
        ]);
    }
    public function actionLihatNonKriteria($led, $prodi, $poin)
    {
        $ledProdi = K9LedProdi::findOne($led);
        $akreditasiProdi = $ledProdi->akreditasiProdi;
        $prodi = $akreditasiProdi->prodi;

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

        return $this->render('isi-non_kriteria', compact('ledProdi', 'json', 'poin', 'modelNarasi', 'detail', 'untuk', 'prodi','akreditasiProdi'));
    }
}
