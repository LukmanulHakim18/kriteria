<?php


namespace akreditasi\modules\kriteria9\modules\prodi\controllers;

use akreditasi\models\kriteria9\forms\resource\ResourceProdiForm;
use akreditasi\modules\kriteria9\controllers\BaseController;
use common\helpers\FakultasDirectoryHelper;
use common\helpers\kriteria9\K9InstitusiDirectoryHelper;
use common\helpers\kriteria9\K9ProdiDirectoryHelper;
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
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ResourceController extends BaseController
{
    public function behaviors()
    {
        return ['verbs'=>[
            'class'=>'yii\filters\VerbFilter',
            'actions' => [
                'gunakan'=>['POST']
            ]
        ]];
    }

    public function actionIndex($prodi, $kriteria, $kode, $jenis, $id_led_lk,$jenis_dokumen)
    {

        $profilInstitusi = $this->findProfilInstitusi();
        $berkasInstitusi = new ActiveDataProvider(['query' => $this->findBerkasInstitusi()]);
        $model = $this->findProdi($prodi);
        $fakultas = $model->fakultasAkademi;
        $profilFakultas = $fakultas->profil;
        $berkasFakultas = new ActiveDataProvider(['query' => $fakultas->getBerkas()]);
        $kegiatanUnit = $this->findKegiatanUnit();
        $profilUnit = $this->findUnit()->all();

        return $this->renderAjax(
            'index',
            compact(
                'model',
                'berkasFakultas',
                'kegiatanUnit',
                'profilInstitusi',
                'profilFakultas',
                'profilUnit',
                'berkasInstitusi',
                'kode',
                'jenis',
                'id_led_lk',
                'kriteria',
                'jenis_dokumen'

            )
        );
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

    public function actionGunakan()
    {
        $params = \Yii::$app->request->post();
        $detail = $this->findDetailBerkas($params['id']);
        $prodi = $this->findProdi($params['prodi']);
        $kode = $params['kode'];
        $jenis = $params['jenis'];
        $id_led_lk = $params['id_led_lk'];
        $kriteria = $params['kriteria'];
        $jenis_dokumen = $params['jenis_dokumen'];
        $pathDetail = $this->findBerkasPath($detail);
        $transaction = \Yii::$app->db->beginTransaction();

//        $model = new ResourceProdiForm();
//        $model->id = $detail->id;
//        $model->nama = $detail->isi_berkas;
        try{
            if ($jenis === Constants::LED) {
                $detailClass = 'common\\models\\kriteria9\\led\\prodi\\K9LedProdiKriteria' . $kriteria . 'Detail';
                $detailAttr = 'id_led_prodi_kriteria' . $kriteria;
                $detailRelation = 'ledProdiKriteria' . $kriteria;
                $detailLedModel = new $detailClass;

                $detailLedModel->$detailAttr = $id_led_lk;
                $detailLedModel->kode_dokumen = $kode;
                $detailLedModel->nama_dokumen = $detail->berkas->nama_berkas;
                $detailLedModel->isi_dokumen = $detail->isi_berkas;
                $detailLedModel->jenis_dokumen = $jenis_dokumen;
                $detailLedModel->bentuk_dokumen = $detail->bentuk_berkas;

                if(!$detailLedModel->save(false)){
                    throw new Exception('Gagal menyimpan detail');
                }
                $pathProdi = K9ProdiDirectoryHelper::getDetailLedPath($detailLedModel->$detailRelation->ledProdi->akreditasiProdi);
                copy("$pathDetail/$detail->isi_berkas", "$pathProdi/{$jenis_dokumen}/{$detail->isi_berkas}");
                $transaction->commit();


            } elseif ($jenis === Constants::LK) {
                $detailClass = 'common\\models\\kriteria9\\lk\\prodi\\K9LkProdiKriteria'.$kriteria.'Detail';
                $detailAttrLk = 'id_lk_prodi_kriteria'.$kriteria;
                $detailLkModel= new $detailClass;
                $detailLkRelation = 'lkProdiKriteria'.$kriteria;

                $detailLkModel->$detailAttrLk = $id_led_lk;
                $detailLkModel->kode_dokumen = $kode;
                $detailLkModel->nama_dokumen = $detail->berkas->nama_berkas;
                $detailLkModel->isi_dokumen = $detail->isi_berkas;
                $detailLkModel->jenis_dokumen = $jenis_dokumen;
                $detailLkModel->bentuk_dokumen = $detail->bentuk_berkas;
                if(!$detailLkModel->save(false)){
                    throw new Exception('Gagal menyimpan detail');
                }
                $pathProdi = K9ProdiDirectoryHelper::getDetailLkPath($detailLkModel->$detailLkRelation->lkProdi->akreditasiProdi);
                copy("$pathDetail/{$detail->isi_berkas}","$pathProdi/$jenis_dokumen/{$detail->isi_berkas}");
                $transaction->commit();
            }
        }catch (Exception $e){
            $transaction->rollBack();
            throw $e;
        }


        \Yii::$app->session->setFlash('success','Berhasil Menggunakan Berkas');

        return $this->redirect(['led/isi-kriteria','kriteria'=>$kriteria,'led'=>$id_led_lk,'prodi'=>$prodi->id]);
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
