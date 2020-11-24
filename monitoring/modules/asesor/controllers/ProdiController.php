<?php


namespace monitoring\modules\asesor\controllers;

use common\helpers\kriteria9\K9ProdiJsonHelper;
use common\models\kriteria9\akreditasi\K9AkreditasiProdi;
use yii\web\NotFoundHttpException;

class ProdiController extends BaseController
{
    public function actionArsip()
    {
    }

    public function actionLihatLK()
    {
    }

    public function actionLihatLed()
    {
    }

    public function actionIndex($id)
    {
        $akreditasiProdi = $this->findAkreditasiProdi($id);
        $prodi = $akreditasiProdi->prodi;
        $jsonEksternal = K9ProdiJsonHelper::getJsonPenilaianKondisiEksternal($prodi->jenjang);
        $jsonProfil = K9ProdiJsonHelper::getJsonPenilaianProfil($prodi->jenjang);
        $jsonKriteria = K9ProdiJsonHelper::getJsonPenilaianKriteria($prodi->jenjang);
        $jsonAnalisis = K9ProdiJsonHelper::getJsonPenilaianAnalisis($prodi->jenjang);

        return $this->render('index',compact('akreditasiProdi','prodi','jsonEksternal','jsonProfil','jsonKriteria','jsonAnalisis'));

    }


    /**
     * @param $id
     * @return K9AkreditasiProdi|null
     * @throws NotFoundHttpException
     */
    protected function findAkreditasiProdi($id)
    {
        if ($model = K9AkreditasiProdi::findOne($id)) {
            return $model;
        }
        throw new NotFoundHttpException();
    }
}
