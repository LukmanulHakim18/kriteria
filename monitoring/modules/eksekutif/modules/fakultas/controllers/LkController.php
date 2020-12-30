<?php


namespace monitoring\modules\eksekutif\modules\fakultas\controllers;

use common\helpers\kriteria9\K9ProdiJsonHelper;
use common\models\kriteria9\lk\prodi\K9LkProdi;

class LkController extends \monitoring\modules\eksekutif\modules\prodi\controllers\LkController
{

    public function actionLihatKriteria($lk, $kriteria, $prodi)
    {
        $lkProdi = K9LkProdi::findOne($lk);
        $akreditasiProdi = $lkProdi->akreditasiProdi;
        $programStudi = $akreditasiProdi->prodi;
        $fakultasAkademi = $programStudi->fakultasAkademi;
        $_GET['fakultas'] = \Yii::$app->request->get('fakultas') ?? $fakultasAkademi->id;
        $json = K9ProdiJsonHelper::getJsonKriteriaLk($kriteria, $programStudi->jenjang);
        $poinKriteria = $json->butir;
        $attrKriteria = 'k9LkProdiKriteria' . $kriteria . 's';
        $lkProdiKriteria = $lkProdi->$attrKriteria;
        return $this->render('isi-kriteria', [
            'lkProdi' => $lkProdi,
            'poinKriteria' => $poinKriteria,
            'modelKriteria'=>$lkProdiKriteria,
            'untuk'=>'lihat',
            'prodi'=>$programStudi,
            'kriteria'=>$kriteria,
            'akreditasiProdi'=>$akreditasiProdi,
            'fakultasAkademi'=>$fakultasAkademi
        ]);
    }
}
