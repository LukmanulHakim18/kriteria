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

        $modelEksternal = $akreditasiProdi->penilaianEksternal;
        $modelProfil = $akreditasiProdi->penilaianProfil;
        $modelKriteria = $akreditasiProdi->penilaianKriteria;
        $modelAnalisis = $akreditasiProdi->penilaianAnalisis;

        if ($modelEksternal->load(\Yii::$app->request->post())) {
            $modelEksternal->save();
            \Yii::$app->session->setFlash('success', 'Berhasil mengisi penilaian Kondisi Eksternal');
        }
        if ($modelProfil->load(\Yii::$app->request->post())) {
            $modelProfil->save();
            \Yii::$app->session->setFlash('success', 'Berhasil mengisi penilaian Profil UPPS');

        }
        if ($modelKriteria->load(\Yii::$app->request->post())) {
            $modelKriteria->save();
            \Yii::$app->session->setFlash('success', 'Berhasil mengisi penilaian Kriteria');

        }
        if ($modelAnalisis->load(\Yii::$app->request->post())) {
            $modelAnalisis->save();
            \Yii::$app->session->setFlash('success', 'Berhasil mengisi penilaian Analisis');

        }
        return $this->render('index',
            compact('akreditasiProdi', 'prodi', 'jsonEksternal', 'jsonProfil', 'jsonKriteria', 'jsonAnalisis',
                'modelEksternal', 'modelProfil', 'modelKriteria', 'modelAnalisis'));

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
