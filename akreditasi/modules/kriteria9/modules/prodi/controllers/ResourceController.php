<?php


namespace akreditasi\modules\kriteria9\modules\prodi\controllers;

use akreditasi\modules\kriteria9\controllers\BaseController;
use common\models\Profil;
use common\models\ProgramStudi;
use common\models\unit\KegiatanUnit;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

class ResourceController extends BaseController
{
    public function behaviors()
    {
        return [];
    }

    public function actionIndex($prodi)
    {

        $profilInstitusi = $this->findProfilInstitusi();
        $model = $this->findProdi($prodi);
        $fakultas = $model->fakultasAkademi;
        $profilFakultas = $fakultas->profil;
        $berkasFakultas = $fakultas->berkas;
        $kegiatanUnit = $this->findKegiatanUnit();
        $profilUnit = $this->findProfilUnit();

        return $this->render('index', compact('model', 'berkasFakultas', 'kegiatanUnit', 'profilInstitusi','profilFakultas','profilUnit'));
    }

    public function actionPopulateLedLk()
    {
    }
    public function actionHandleBerkasFakultas()
    {
    }

    public function actionHandleKegiatanUnit()
    {
    }
    public function actionHandleProfilInstitusi()
    {
    }

    /**
     * @return array|ActiveRecord[]
     */
    protected function findKegiatanUnit()
    {
        return KegiatanUnit::find()->all();
    }

    protected function findProfilUnit(){
        if ($model = Profil::findAll(['type'=>Profil::TIPE_UNIT])) {
            return $model;
        }

        throw new NotFoundHttpException('Data yang anda cari tidak ditemukan');
    }

    /**
     * @param $id
     * @return ProgramStudi|null
     * @throws NotFoundHttpException
     */
    protected function findProdi($id)
    {

        if ($model = ProgramStudi::findOne($id)) {
            return $model;
        }

        throw new NotFoundHttpException('Data yang anda cari tidak ditemukan');
    }

    protected function findProfilInstitusi()
    {
        if ($model = Profil::findOne(['type'=>Profil::TIPE_INSTITUSI])) {
            return $model;
        }

        throw new NotFoundHttpException('Data yang anda cari tidak ditemukan');

    }
}
