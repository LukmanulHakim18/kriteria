<?php


namespace monitoring\modules\eksekutif\modules\institusi\controllers;

use common\helpers\kriteria9\K9ProdiJsonHelper;
use common\models\kriteria9\led\prodi\K9LedProdi;

class LedController extends \monitoring\modules\eksekutif\modules\prodi\controllers\LedController
{

    public function actionLihatKriteria($led, $kriteria, $prodi)
    {
        $ledProdi = K9LedProdi::findOne(['id'=>$led]);
        $akreditasiProdi = $ledProdi->akreditasiProdi;
        $programStudi = $akreditasiProdi->prodi;
        $fakultasAkademi = $programStudi->fakultasAkademi;
        $attr = 'k9LedProdiKriteria' . $kriteria . 's';
        $modelLed = $ledProdi->$attr;
        $_GET['fakultas'] = \Yii::$app->request->get('fakultas') ?? $fakultasAkademi->id;
        $json = K9ProdiJsonHelper::getJsonKriteriaLed($kriteria);
        $poinKriteria = $json->butir;
        return $this->render('isi-kriteria', [
            'model' => $modelLed,
            'poinKriteria' => $poinKriteria,
            'untuk'=>'lihat',
            'kriteria'=>$kriteria,
            'prodi'=>$programStudi,
            'akreditasiProdi'=>$akreditasiProdi,
            'fakultasAkademi'=>$fakultasAkademi
        ]);
    }
    public function actionLihatNonKriteria($led, $prodi, $poin)
    {
        $ledProdi = K9LedProdi::findOne($led);
        $akreditasiProdi = $ledProdi->akreditasiProdi;
        $programStudi = $akreditasiProdi->prodi;
        $fakultasAkademi = $programStudi->fakultasAkademi;
        $_GET['fakultas'] = \Yii::$app->request->get('fakultas') ??$fakultasAkademi->id;


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

        $points = $json->butir;
        $untuk = 'lihat';

        return $this->render('isi-non_kriteria',[
            'ledProdi'=>$ledProdi,
            'json'=>$json,
            'poin'=>$points,
            'modelNarasi'=>$modelNarasi,
            'untuk'=>$untuk,
            'prodi'=>$programStudi,
            'akreditasiProdi'=>$akreditasiProdi,
            'fakultasAkademi'=>$fakultasAkademi
        ]);
    }

}
