<?php


namespace akreditasi\modules\kriteria9\modules\prodi\controllers;

use akreditasi\modules\kriteria9\controllers\BaseController;
use common\models\ProfilInstitusi;
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

        $model = $this->getProdi($prodi);
        $berkasFakultas = $model->fakultasAkademi->berkas;
        $kegiatanUnit = $this->getKegiatanUnit();
        $profilInstitusi = ProfilInstitusi::find()->all();

        return $this->render('index', compact('model', 'berkasFakultas', 'kegiatanUnit', 'profilInstitusi'));
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
    protected function getKegiatanUnit()
    {
        return KegiatanUnit::find()->all();
    }

    /**
     * @param $id
     * @return ProgramStudi|null
     * @throws NotFoundHttpException
     */
    protected function getProdi($id)
    {

        if ($model = ProgramStudi::findOne($id)) {
            return $model;
        }

        throw new NotFoundHttpException('Data yang anda cari tidak ditemukan');
    }
}
