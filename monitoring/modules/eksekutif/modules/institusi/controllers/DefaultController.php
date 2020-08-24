<?php

namespace monitoring\modules\eksekutif\modules\institusi\controllers;

use common\models\FakultasAkademi;
use common\models\kriteria9\akreditasi\K9Akreditasi;
use common\models\kriteria9\akreditasi\K9AkreditasiInstitusi;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii2mod\collection\Collection;

/**
 * Default controller for the `eksekutif-institusi` module
 */
class DefaultController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        //profil
        $profil = $this->findProfil();
        $profilInstitusi = new Collection(ArrayHelper::map($this->findProfilInstitusi(), 'nama', 'isi'));

        //akreditasiInstitusi
        $akreditasiInstitusiTerakhir = K9AkreditasiInstitusi::find()->orderBy('id DESC')->one();

        //Akreditasi Prodi
        $fakultasDataProvider = new ActiveDataProvider(['query' => FakultasAkademi::find()]);


        $akreditasiTerakhir = K9Akreditasi::find()->where(['jenis_akreditasi' => 'prodi'])->orderBy('id DESC')->one();
        return $this->render('index', compact('fakultasDataProvider', 'profil', 'akreditasiTerakhir', 'profilInstitusi',
            'akreditasiInstitusiTerakhir'));
    }
}
