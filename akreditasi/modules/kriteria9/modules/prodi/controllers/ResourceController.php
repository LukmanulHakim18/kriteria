<?php


namespace akreditasi\modules\kriteria9\modules\prodi\controllers;

use akreditasi\modules\kriteria9\controllers\BaseController;
use common\models\Berkas;
use common\models\DetailBerkas;
use common\models\Profil;
use common\models\ProgramStudi;
use common\models\Unit;
use common\models\unit\KegiatanUnit;
use yii\data\ActiveDataProvider;
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
        $berkasInstitusi = new ActiveDataProvider(['query' => $this->findBerkasInstitusi()]);
        $model = $this->findProdi($prodi);
        $fakultas = $model->fakultasAkademi;
        $profilFakultas = $fakultas->profil;
        $berkasFakultas = new ActiveDataProvider(['query' =>$fakultas->getBerkas() ]);
        $kegiatanUnit = $this->findKegiatanUnit();
        $profilUnit = $this->findUnit()->all();

        return $this->render('index', compact('model', 'berkasFakultas', 'kegiatanUnit', 'profilInstitusi', 'profilFakultas', 'profilUnit', 'berkasInstitusi'));
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

    public function actionBerkasDetail()
    {
        if (isset($_POST['expandRowKey'])) {
            $model = new ActiveDataProvider(['query' => DetailBerkas::find()->where(['id_berkas'=>$_POST['expandRowKey']])->indexBy('id')]);
            return $this->renderPartial('_detail_berkas', ['model'=>$model]);
        }

        return '<div class="alert alert-danger">No data found</div>';
    }
    protected function findBerkasInstitusi()
    {
        return Berkas::find()->where(['type'=>Berkas::TYPE_INSTITUSI]);
    }
    /**
     * @return array|ActiveRecord[]
     */
    protected function findKegiatanUnit()
    {
        return KegiatanUnit::find()->all();
    }

    protected function findProfilUnit()
    {
        if ($model = Profil::findAll(['type'=>Profil::TIPE_UNIT])) {
            return $model;
        }

        throw new NotFoundHttpException('Data yang anda cari tidak ditemukan');
    }

    protected function findUnit(){
        if ($model = Unit::find()) {
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
