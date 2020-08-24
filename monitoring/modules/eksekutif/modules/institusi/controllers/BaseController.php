<?php


namespace monitoring\modules\eksekutif\modules\institusi\controllers;

use common\models\Constants;
use common\models\FakultasAkademi;
use common\models\kriteria9\akreditasi\K9Akreditasi;
use common\models\kriteria9\akreditasi\K9AkreditasiInstitusi;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria1;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria2;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria3;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria4;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria5;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria6;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria7;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria8;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria9;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria1;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria2;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria3;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria4;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria5;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria6;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria7;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria8;
use common\models\Profil;
use common\models\ProfilInstitusi;
use common\models\ProgramStudi;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BaseController extends Controller
{

    public $layout = 'main';

    protected function findAkreditasiInstitusiById($id)
    {

        if ($model = K9AkreditasiInstitusi::findOne($id)) {
            return $model;
        }

        throw new NotFoundHttpException('Data yang anda cari tidak ditemukan');
    }

    protected function findAllAkreditasi()
    {
        if ($model = K9AkreditasiInstitusi::find()->all()) {
            return $model;
        }

        throw new NotFoundHttpException('Data yang anda cari tidak ditemukan.');
    }

    protected function findProfil()
    {
        return Profil::findOne(['type'=>Profil::TIPE_INSTITUSI]);
    }

    protected function findProfilInstitusi()
    {
        return ProfilInstitusi::find()->all();
    }

    protected function findFakultas($id)
    {

        if ($model = FakultasAkademi::findOne($id)) {
            return $model;
        }

        throw new NotFoundHttpException('Data yang anda cari tidak ditemukan');
    }

    protected function findProdi($id)
    {
        if ($model = ProgramStudi::findOne($id)) {
            return $model;
        }

        throw new NotFoundHttpException('Data yang anda cari tidak ditemukan');
    }

    protected function getArrayKriteraLed($led)
    {
        $kriteria1 = K9LedProdiKriteria1::findOne(['id_led_prodi' => $led]);
        $kriteria2 = K9LedProdiKriteria2::findOne(['id_led_prodi' => $led]);
        $kriteria3 = K9LedProdiKriteria3::findOne(['id_led_prodi' => $led]);
        $kriteria4 = K9LedProdiKriteria4::findOne(['id_led_prodi' => $led]);
        $kriteria5 = K9LedProdiKriteria5::findOne(['id_led_prodi' => $led]);
        $kriteria6 = K9LedProdiKriteria6::findOne(['id_led_prodi' => $led]);
        $kriteria7 = K9LedProdiKriteria7::findOne(['id_led_prodi' => $led]);
        $kriteria8 = K9LedProdiKriteria8::findOne(['id_led_prodi' => $led]);
        $kriteria9 = K9LedProdiKriteria9::findOne(['id_led_prodi' => $led]);

        return [
            $kriteria1,
            $kriteria2,
            $kriteria3,
            $kriteria4,
            $kriteria5,
            $kriteria6,
            $kriteria7,
            $kriteria8,
            $kriteria9
        ];
    }

    protected function getArrayKriteriaLk($lk)
    {
        $kriteria1 = K9LkProdiKriteria1::findOne(['id_lk_prodi' => $lk]);
        $kriteria2 = K9LkProdiKriteria2::findOne(['id_lk_prodi' => $lk]);
        $kriteria3 = K9LkProdiKriteria3::findOne(['id_lk_prodi' => $lk]);
        $kriteria4 = K9LkProdiKriteria4::findOne(['id_lk_prodi' => $lk]);
        $kriteria5 = K9LkProdiKriteria5::findOne(['id_lk_prodi' => $lk]);
        $kriteria6 = K9LkProdiKriteria6::findOne(['id_lk_prodi' => $lk]);
        $kriteria7 = K9LkProdiKriteria7::findOne(['id_lk_prodi' => $lk]);
        $kriteria8 = K9LkProdiKriteria8::findOne(['id_lk_prodi' => $lk]);

        return [$kriteria1, $kriteria2, $kriteria3, $kriteria4, $kriteria5, $kriteria6, $kriteria7, $kriteria8];
    }

    protected function findAkreditasiProdiTerakhir()
    {
        return K9Akreditasi::find()->where(['jenis_akreditasi'=>Constants::PRODI])->orderBy('id DESC')->one();
    }
}
