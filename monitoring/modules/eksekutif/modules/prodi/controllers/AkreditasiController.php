<?php


namespace monitoring\modules\eksekutif\modules\prodi\controllers;

use common\helpers\kriteria9\K9ProdiDirectoryHelper;
use common\helpers\kriteria9\K9ProdiJsonHelper;
use common\models\kriteria9\led\prodi\K9ProdiEksporDokumen;
use common\models\kriteria9\led\prodi\K9LedProdi;
use yii\data\ActiveDataProvider;

class AkreditasiController extends BaseController
{

    public function actionIndex($prodi)
    {
        $modelProdi = $this->findProdi($prodi);
        $akreditasiDataProvider = new ActiveDataProvider(['query'=>$modelProdi->getK9AkreditasiProdis()]);

        return $this->render('index', ['prodi'=>$modelProdi,'akreditasiDataProvider'=>$akreditasiDataProvider]);
    }

    public function actionDetail($id, $prodi)
    {

        $modelProdi = $this->findProdi($prodi);
        $akreditasiProdi = $modelProdi->getK9AkreditasiProdis()->where(['id'=>$id])->one();

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
            'modelProdi'=>$modelProdi,
            'akreditasiProdi'=>$akreditasiProdi,
            'jsonLed'=>$jsonLed,
            'ledProdi'=>$ledProdi,
            'dokumenLed'=>$dokumenLed,
            'kriteriaLed'=>$kriteriaLed,
            'urlLed'=>$urlLed,
            'jsonLk'=>$jsonLk,
            'lkProdi'=>$lkProdi,
            'kriteriaLk'=>$kriteriaLk]);
    }
}
