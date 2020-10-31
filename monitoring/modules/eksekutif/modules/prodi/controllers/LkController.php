<?php


namespace monitoring\modules\eksekutif\modules\prodi\controllers;

use common\helpers\DownloadDokumenTrait;
use common\helpers\kriteria9\K9ProdiDirectoryHelper;
use common\helpers\kriteria9\K9ProdiJsonHelper;
use common\models\kriteria9\lk\K9LkTemplate;
use common\models\kriteria9\lk\prodi\K9LkProdi;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria1Detail;
use Yii;

class LkController extends \akreditasi\modules\kriteria9\modules\prodi\controllers\LkController
{
    public function actionLihatKriteria($lk, $kriteria, $prodi)
    {
        $lkProdi = K9LkProdi::findOne($lk);
        $akreditasiProdi = $lkProdi->akreditasiProdi;
        $programStudi = $akreditasiProdi->prodi;
        $json = K9ProdiJsonHelper::getJsonKriteriaLk($kriteria,$programStudi->jenjang);
        $poinKriteria = $json->butir;
        $attrKriteria = 'k9LkProdiKriteria'.$kriteria.'s';
        $lkProdiKriteria = $lkProdi->$attrKriteria;
        return $this->render('isi-kriteria', [
            'lkProdi' => $lkProdi,
            'poinKriteria' => $poinKriteria,
            'modelKriteria'=>$lkProdiKriteria,
            'untuk'=>'lihat',
            'prodi'=>$programStudi,
            'kriteria'=>$kriteria,
            'akreditasiProdi'=>$akreditasiProdi
        ]);
    }
}
