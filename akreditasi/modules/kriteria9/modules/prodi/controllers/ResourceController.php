<?php


namespace akreditasi\modules\kriteria9\modules\prodi\controllers;

use akreditasi\models\kriteria9\forms\resource\ResourceProdiForm;
use akreditasi\modules\kriteria9\controllers\BaseController;
use common\helpers\FakultasDirectoryHelper;
use common\helpers\kriteria9\K9InstitusiDirectoryHelper;
use common\helpers\UnitDirectoryHelper;
use common\models\Berkas;
use common\models\Constants;
use common\models\DetailBerkas;
use common\models\Profil;
use common\models\ProgramStudi;
use common\models\Unit;
use common\models\unit\KegiatanUnit;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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
        $berkasFakultas = new ActiveDataProvider(['query' => $fakultas->getBerkas()]);
        $kegiatanUnit = $this->findKegiatanUnit();
        $profilUnit = $this->findUnit()->all();

        return $this->renderAjax('index',
            compact('model', 'berkasFakultas', 'kegiatanUnit', 'profilInstitusi', 'profilFakultas', 'profilUnit',
                'berkasInstitusi'));
    }

    public function actionPopulateLedLk($id_prodi)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $path = \Yii::getAlias('@required/kriteria9/aps');
        $prodi =  $this->findProdi($id_prodi);
        $ledFile = "$path/led_prodi.json";
        $lkFile = "$path/lkps_prodi_{$prodi->jenjang}.json";
        $lk = Json::decode(file_get_contents($lkFile));

        $out = [];
        if(isset($_POST['depdrop_parents'])){
            $parents = $_POST['depdrop_parents'];
            if($parents !==null){
                $jenis = $parents[0];
                if(!$jenis){
                    if($jenis === Constants::LED){
                        $led = Json::decode(file_get_contents($ledFile));
                    }
                }

            }
        }

        return ['out'=>'','selected'=>''];
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

    public function actionLihatBerkasDetail($id)
    {
        $detailBerkas = $this->findDetailBerkas($id);
        $url = $this->findBerkasUrl($detailBerkas);
        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('_detail_berkas', ['model' => $detailBerkas, 'url' => $url]);
        }

        return true;
    }

    public function actionDownloadDetail($id)
    {

        $detailBerkas = $this->findDetailBerkas($id);
        $path = $this->findBerkasUrl($detailBerkas);
        return \Yii::$app->response->sendFile("$path/{$detailBerkas->isi_berkas}");
    }

    public function actionGunakan($id,$prodi)
    {
        $detail = $this->findDetailBerkas($id);
        $model = new ResourceProdiForm();
        $model->id = $detail->id;
        $model->nama = $detail->isi_berkas;
        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('_berkas_form',['model'=>$model,'detail'=>$detail,'prodi'=>$prodi]);
        }

        return 'Hello';
    }

    protected function findBerkasPath($detail)
    {
        $path = '';
        switch ($detail->berkas->type) {
            case Berkas::TYPE_UNIT:
                $path = UnitDirectoryHelper::getPath($detail->berkas->owner->id);

                break;
            case Berkas::TYPE_FAKULTAS:
                $path = FakultasDirectoryHelper::getPath($detail->berkas->owner->id);

                break;
            case Berkas::TYPE_INSTITUSI:
                $path = K9InstitusiDirectoryHelper::getPath();

                break;
        }

        return $path;
    }

    protected function findBerkasUrl($detail)
    {
        $url = '';
        switch ($detail->berkas->type) {
            case Berkas::TYPE_UNIT:
                $url = UnitDirectoryHelper::getUrl($detail->berkas->owner->id);

                break;
            case Berkas::TYPE_FAKULTAS:
                $url = FakultasDirectoryHelper::getUrl($detail->berkas->owner->id);

                break;
            case Berkas::TYPE_INSTITUSI:
                $url = K9InstitusiDirectoryHelper::getUrl();

                break;
        }

        return $url;
    }

    protected function findBerkasInstitusi()
    {
        return Berkas::find()->where(['type' => Berkas::TYPE_INSTITUSI]);
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
        if ($model = Profil::findAll(['type' => Profil::TIPE_UNIT])) {
            return $model;
        }

        throw new NotFoundHttpException('Data yang anda cari tidak ditemukan');
    }

    protected function findUnit()
    {
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
        if ($model = Profil::findOne(['type' => Profil::TIPE_INSTITUSI])) {
            return $model;
        }

        throw new NotFoundHttpException('Data yang anda cari tidak ditemukan');
    }

    protected function findDetailBerkas($id)
    {
        if ($model = DetailBerkas::findOne($id)) {
            return $model;
        }

        throw new NotFoundHttpException('Data yang anda cari tidak ditemukan');
    }
}
