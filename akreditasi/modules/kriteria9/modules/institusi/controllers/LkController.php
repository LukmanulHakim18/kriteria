<?php


namespace akreditasi\modules\kriteria9\modules\institusi\controllers;

use akreditasi\models\kriteria9\forms\led\K9DokumenLedInstitusiUploadForm;
use akreditasi\models\kriteria9\forms\lk\institusi\K9LinkLkInstitusiKriteriaDetailForm;
use akreditasi\models\kriteria9\forms\lk\institusi\K9LkInstitusiKriteriaDetailForm;
use akreditasi\models\kriteria9\forms\lk\institusi\K9TextLkInstitusiKriteriaDetailForm;
use common\helpers\DownloadDokumenTrait;
use common\helpers\FileTypeHelper;
use common\helpers\kriteria9\K9InstitusiDirectoryHelper;
use common\helpers\kriteria9\K9InstitusiJsonHelper;
use common\helpers\NomorKriteriaHelper;
use common\models\Constants;
use common\models\kriteria9\akreditasi\K9Akreditasi;
use common\models\kriteria9\forms\lk\K9PencarianLkInstitusiForm;
use common\models\kriteria9\led\institusi\K9InstitusiEksporDokumen;
use common\models\kriteria9\lk\institusi\K9LkInstitusi;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria1;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria2;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria3;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria4;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria5;
use common\models\ProfilInstitusi;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\MethodNotAllowedHttpException;
use yii\web\UploadedFile;
use yii2mod\collection\Collection;

class LkController extends BaseController
{
    protected $lkView = '@akreditasi/modules/kriteria9/modules/institusi/views/lk/isi';
    protected $lihatLkKriteria = '@akreditasi/modules/kriteria9/modules/institusi/views/lk/isi-kriteria';
    protected $itemLkView = '@akreditasi/modules/kriteria9/modules/institusi/views/lk/_item_lk';
    use DownloadDokumenTrait;

    public function actionArsip($target)
    {
        $model = new K9PencarianLkInstitusiForm();

        $idAkreditasiInstitusi = K9Akreditasi::findAll(['jenis_akreditasi' => 'institusi']);
        $dataAkreditasiInstitusi = ArrayHelper::map($idAkreditasiInstitusi, 'id', function ($data) {
            return $data->lembaga . ' - ' . $data->nama . ' (' . $data->tahun . ')';
        });

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                $url = $model->cari($target);
                $lk = $model->getLk();
                $newUrl = [];
                if (!$lk) {
                    $newUrl = false;
                } else {
                    $newUrl = $url;
                }
                return $this->renderAjax('_hasil-arsip', ['lk' => $lk, 'url' => $newUrl]);
            }
        }

        return $this->render('arsip', [
            'model' => $model,
            'dataAkreditasiInstitusi' => $dataAkreditasiInstitusi
        ]);
    }

    public function actionIsi($lk)
    {
        $lkInstitusi = K9LkInstitusi::findOne($lk);

        $arrayProfil = $this->getProfilInstitusi();
        $json = K9InstitusiJsonHelper::getAllJsonLk($arrayProfil['jenis']);
        $kriteria = $this->getArrayKriteria($lk);
        $institusi = Yii::$app->params['institusi'];
        $dataDokumen = $lkInstitusi->getEksporDokumen()->orderBy('kode_dokumen')->all();

        $modelDokumen = new K9DokumenLedInstitusiUploadForm();
        if ($modelDokumen->load(Yii::$app->request->post())) {
            $dokumen = $this->uploadDokumenLed($lk);
            if ($dokumen) {
                $model = new K9InstitusiEksporDokumen();
                $model->external_id = $lkInstitusi->id;
                $model->type = K9InstitusiEksporDokumen::TYPE_LK;
                $model->nama_dokumen = $dokumen->getNamaDokumen();
                $model->bentuk_dokumen = $dokumen->getBentukDokumen();
                $model->kode_dokumen = 'uploaded';
                $model->save(false);

                Yii::$app->session->setFlash('success', 'Berhasil mengunggah Dokumen LED');
                return $this->redirect(Url::current());
            }
            Yii::$app->session->setFlash('warning', 'Gagal mengunggah Dokumen LED');
            return $this->redirect(Url::current());
        }

        return $this->render('isi', [
            'lkInstitusi' => $lkInstitusi,
            'kriteria' => $kriteria,
            'institusi' => $institusi,
            'json' => $json,
            'untuk' => 'isi',
            'modelDokumen' => $modelDokumen,
            'dataDokumen' => $dataDokumen,
            'path' => K9InstitusiDirectoryHelper::getDokumenLkUrl($lkInstitusi->akreditasiInstitusi)
        ]);
    }

    protected function getProfilInstitusi()
    {
        return ArrayHelper::map(ProfilInstitusi::find()->all(), 'nama', 'isi');
    }

    protected function getArrayKriteria($lk)
    {
        $kriteria1 = K9LkInstitusiKriteria1::findOne(['id_lk_institusi' => $lk]);
        $kriteria2 = K9LkInstitusiKriteria2::findOne(['id_lk_institusi' => $lk]);
        $kriteria3 = K9LkInstitusiKriteria3::findOne(['id_lk_institusi' => $lk]);
        $kriteria4 = K9LkInstitusiKriteria4::findOne(['id_lk_institusi' => $lk]);
        $kriteria5 = K9LkInstitusiKriteria5::findOne(['id_lk_institusi' => $lk]);

        return [$kriteria1, $kriteria2, $kriteria3, $kriteria4, $kriteria5];
    }

    protected function uploadDokumenLed($led)
    {
        $lkInstitusi = K9LkInstitusi::findOne($led);

        $dokumenLed = new K9DokumenLedInstitusiUploadForm();
        $dokumenLed->dokumenLed = UploadedFile::getInstance($dokumenLed, 'dokumenLed');
        $realPath = K9InstitusiDirectoryHelper::getDokumenLkPath($lkInstitusi->akreditasiInstitusi);
        $response = null;

        if ($dokumenLed->validate()) {

            $uploaded = $dokumenLed->uploadDokumen($realPath);
            if ($uploaded) {
                $response = $dokumenLed;
            }

        }

        return $response;


    }

    public function actionIsiKriteria($lk, $kriteria)
    {
        $profil = $this->getProfilInstitusi();
        $json = K9InstitusiJsonHelper::getJsonKriteriaLk($kriteria, $profil['jenis']);
        $poinKriteria = $json->butir;
        $lkInstitusi = K9LkInstitusi::findOne($lk);

        $path = K9InstitusiDirectoryHelper::getDokumenLkUrl($lkInstitusi->akreditasiInstitusi);

        $attrKriteria = 'k9LkInstitusiKriteria' . $kriteria . 's';
        $lkInstitusiKriteria = $lkInstitusi->$attrKriteria;

        $modelNarasiClass = 'akreditasi\\models\\kriteria9\\lk\\institusi\\K9LkInstitusiNarasiKriteria' . $kriteria . 'Form';
        $modelNarasi = call_user_func($modelNarasiClass . '::findOne',
            ['id_lk_institusi_kriteria' . $kriteria => $lkInstitusiKriteria->id]);

        $dokModel = new K9LkInstitusiKriteriaDetailForm();
        $dokTextModel = new K9TextLkInstitusiKriteriaDetailForm();
        $dokLinkModel = new K9LinkLkInstitusiKriteriaDetailForm();

        if ($dokModel->load(Yii::$app->request->post())) {
            $dokModel->isiDokumen = UploadedFile::getInstance($dokModel, 'isiDokumen');

            if ($dokModel->uploadDokumen($lkInstitusiKriteria->id, $kriteria)) {
//              Alert jika nama sama belum selesai

                Yii::$app->session->setFlash('success', 'Berhasil Upload');
                return $this->redirect(Url::current());
            } else {
                Yii::$app->session->setFlash('error', 'Gagal Upload. Cek File');
                return $this->redirect(Url::current());
            }
//            return $this->redirect(Url::current());
        }

        if ($modelNarasi->load(Yii::$app->request->post())) {
            $modelNarasi->save();
            Yii::$app->session->setFlash('success', 'Berhasil Memperbarui Entri');
            return $this->redirect(Url::current());
        }


        if ($dokTextModel->load(Yii::$app->request->post())) {
            if ($dokTextModel->uploadText($lkInstitusiKriteria->id, $kriteria)) {
                Yii::$app->session->setFlash('success', 'Berhasil Tambah Teks');
                return $this->redirect(Url::current());
            } else {
                Yii::$app->session->setFlash('error', 'Gagal Tambah Teks');
                return $this->redirect(Url::current());
            }
        }

        if ($dokLinkModel->load(Yii::$app->request->post())) {
            if ($dokLinkModel->uploadLink($lkInstitusiKriteria->id, $kriteria)) {
                Yii::$app->session->setFlash('success', 'Berhasil Tambah Tautan');
                return $this->redirect(Url::current());
            } else {
                Yii::$app->session->setFlash('error', 'Gagal Tambah Tautan');
                return $this->redirect(Url::current());
            }
        }


        return $this->render($this->lihatLkKriteria, [
            'modelNarasi' => $modelNarasi,
            'lkInstitusi' => $lkInstitusi,
            'poinKriteria' => $poinKriteria,
            'modelKriteria' => $lkInstitusiKriteria,
            'path' => $path,
            'untuk' => 'isi',
            'kriteria' => $kriteria
        ]);
    }

    public function actionDownloadDetail($dokumen, $kriteria, $lk)
    {
        ini_set('max_execution_time', 5 * 60);
        $detailClass = 'common\\models\\kriteria9\\lk\\institusi\\K9LkInstitusiKriteria' . $kriteria . 'Detail';
        $model = call_user_func($detailClass . '::findOne', $dokumen);
        $attribute = 'lkInstitusiKriteria' . $kriteria;

        $path = K9InstitusiDirectoryHelper::getDokumenLkPath($model->$attribute->lkInstitusi->akreditasiInstitusi);
        $file = $model->isi_dokumen;


        $url = $this->download($model, $path, $file);
        return Yii::$app->response->sendFile($url);
    }

    public function actionHapusDetail()
    {
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('dokumen');
            $kriteria = Yii::$app->request->post('kriteria');
            $lk = Yii::$app->request->post('lk');

            $namespace = 'common\\models\\kriteria9\\lk\\institusi\\K9';
            $class = $namespace . 'LkInstitusiKriteria' . $kriteria . 'Detail';
            $model = call_user_func($class . '::findOne', $id);
            $attr = 'lkInstitusiKriteria' . $kriteria;

            $path = K9InstitusiDirectoryHelper::getDokumenLkPath($model->$attr->lkInstitusi->akreditasiInstitusi);
            $file = $model->isi_dokumen;

            if ($model->bentuk_dokumen === FileTypeHelper::TYPE_STATIC_TEXT) {
                $model->delete();
                Yii::$app->session->setFlash('success', "Teks Tabel $model->kode_dokumen berhasil dihapus");
                return $this->redirect(['lk/isi-kriteria', 'kriteria' => $kriteria, 'lk' => $lk]);
            }
            if ($model->bentuk_dokumen === FileTypeHelper::TYPE_LINK) {
                $model->delete();
                Yii::$app->session->setFlash('success', "Tautan Tabel $model->kode_dokumen berhasil dihapus");
                return $this->redirect(['lk/isi-kriteria', 'kriteria' => $kriteria, 'lk' => $lk]);
            }

            if ($model->jenis_dokumen === Constants::LAINNYA) {
                unlink("$path/lainnya/$file");
                $model->delete();

                Yii::$app->session->setFlash('success', "Dokumen $model->kode_dokumen berhasil dihapus");
                return $this->redirect(['lk/isi-kriteria', 'kriteria' => $kriteria, 'lk' => $lk]);
            }
            if ($model->jenis_dokumen === Constants::SUMBER) {
                unlink("$path/sumber/$file");
                $model->delete();

                Yii::$app->session->setFlash('success', "Dokumen $model->kode_dokumen berhasil dihapus");
                return $this->redirect(['lk/isi-kriteria', 'kriteria' => $kriteria, 'lk' => $lk]);
            }
            if ($model->jenis_dokumen === Constants::PENDUKUNG) {
                unlink("$path/pendukung/$file");
                $model->delete();

                Yii::$app->session->setFlash('success', "Dokumen $model->kode_dokumen berhasil dihapus");
                return $this->redirect(['lk/isi-kriteria', 'kriteria' => $kriteria, 'lk' => $lk]);
            }

            unlink("$path/$file");
            $model->delete();

            Yii::$app->session->setFlash('success', "Dokumen $model->kode_dokumen berhasil dihapus");
            return $this->redirect(['lk/isi-kriteria', 'kriteria' => $kriteria, 'lk' => $lk]);
        }
        throw new MethodNotAllowedHttpException('Request Harus Post');
    }

    public function actionLihat($lk)
    {
        $lkInstitusi = K9LkInstitusi::findOne($lk);
        $profil = $this->getProfilInstitusi();
        $json = K9InstitusiJsonHelper::getAllJsonLk($profil['jenis']);
        $kriteria = $this->getArrayKriteria($lk);
        $institusi = Yii::$app->params['institusi'];

        $dataDokumen = $lkInstitusi->getEksporDokumen()->orderBy('kode_dokumen')->all();

        $modelDokumen = new K9DokumenLedInstitusiUploadForm();

        return $this->render($this->lkView, [
            'lkInstitusi' => $lkInstitusi,
            'kriteria' => $kriteria,
            'institusi' => $institusi,
            'json' => $json,
            'untuk' => 'lihat',
            'dataDokumen' => $dataDokumen,
            'modelDokumen' => $modelDokumen,
            'path' => K9InstitusiDirectoryHelper::getDokumenLkUrl($lkInstitusi->akreditasiInstitusi)
        ]);
    }


    public function actionLihatKriteria($kriteria, $lk)
    {
        $profil = $this->getProfilInstitusi();
        $json = K9InstitusiJsonHelper::getJsonKriteriaLk($kriteria, $profil['jenis']);
        $poinKriteria = $json->butir;
        $lkInstitusi = K9LkInstitusi::findOne($lk);
        $akreditasiInstitusi = $lkInstitusi->akreditasiInstitusi;
        $profilInstitusi = ArrayHelper::map(ProfilInstitusi::find()->all(), 'nama', 'isi');

        $path = K9InstitusiDirectoryHelper::getDokumenLkUrl($lkInstitusi->akreditasiInstitusi);

        $attrKriteria = 'k9LkInstitusiKriteria' . $kriteria . 's';
        $lkInstitusiKriteria = $lkInstitusi->$attrKriteria;

        $modelNarasiClass = 'akreditasi\\models\\kriteria9\\lk\\institusi\\K9LkInstitusiNarasiKriteria' . $kriteria . 'Form';
        $modelNarasi = call_user_func($modelNarasiClass . '::findOne',
            ['id_lk_institusi_kriteria' . $kriteria => $lkInstitusiKriteria->id]);

        return $this->render($this->lihatLkKriteria, [
            'modelNarasi' => $modelNarasi,
            'lkInstitusi' => $lkInstitusi,
            'poinKriteria' => $poinKriteria,
            'modelKriteria' => $lkInstitusiKriteria,
            'path' => $path,
            'kriteria' => $kriteria,
            'untuk' => 'lihat',
            'akreditasiInstitusi' => $akreditasiInstitusi,
            'profilInstitusi' => $profilInstitusi
        ]);
    }

    public function actionButirItem($lk, $kriteria, $untuk, $poin)
    {
        $lkInstitusi = K9LkInstitusi::findOne($lk);
        $profil = $this->getProfilInstitusi();
        $currentPoint = $this->getKriteriaNomor($kriteria, $poin, $profil['jenis']);

        $path = K9InstitusiDirectoryHelper::getDokumenLkUrl($lkInstitusi->akreditasiInstitusi);

        $lkInstitusiKriteriaClass = 'common\\models\\kriteria9\\lk\\institusi\\K9LkInstitusiKriteria' . $kriteria;
        $lkInstitusiKriteria = call_user_func($lkInstitusiKriteriaClass . '::findOne',
            ['id_lk_institusi' => $lkInstitusi->id]);
        $detailAttr = 'k9LkInstitusiKriteria' . $kriteria . 'Details';
        $detail = $lkInstitusiKriteria->$detailAttr;
        $lkCollection = Collection::make($detail);
        $modelNarasiClass = 'akreditasi\\models\\kriteria9\\lk\\institusi\\K9LkInstitusiNarasiKriteria' . $kriteria . 'Form';
        $modelNarasi = call_user_func($modelNarasiClass . '::findOne',
            ['id_lk_institusi_kriteria' . $kriteria => $lkInstitusiKriteria->id]);

        $dokUploadModel = new K9LkInstitusiKriteriaDetailForm();
        $dokTextModel = new K9TextLkInstitusiKriteriaDetailForm();
        $dokLinkModel = new K9LinkLkInstitusiKriteriaDetailForm();

        return $this->renderAjax($this->itemLkView, [
            'lkInstitusi' => $lkInstitusi,
            'item' => $currentPoint,
            'path' => $path,
            'modelKriteria' => $lkInstitusiKriteria,
            'modelNarasi' => $modelNarasi,
            'dokUploadModel' => $dokUploadModel,
            'dokTextModel' => $dokTextModel,
            'dokLinkModel' => $dokLinkModel,
            'modelAttribute' => NomorKriteriaHelper::changeToDbFormat($poin),
            'kriteria' => $kriteria,
            'poin' => $poin,
            'lkCollection' => $lkCollection,
            'untuk' => $untuk
        ]);
    }

    protected function getKriteriaNomor($kriteria, $item, $jenis)
    {
        $data = K9InstitusiJsonHelper::getJsonKriteriaLk($kriteria, $jenis);
        return Collection::make($data->butir)->where('tabel', $item)->first();
    }

    public function actionDownloadDokumen($dokumen)
    {
        ini_set('max_execution_time', 5 * 60);
        $model = K9InstitusiEksporDokumen::findOne($dokumen);
        $file = K9InstitusiDirectoryHelper::getDokumenLkPath($model->lkInstitusi->akreditasiInstitusi) . "/{$model->nama_dokumen}";
        return Yii::$app->response->sendFile($file);
    }

    public function actionHapusDokumenLk()
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();

            $idDokumenLed = $data['id'];
            $dokumenLkInstitusi = K9InstitusiEksporDokumen::findOne($idDokumenLed);
            $path = K9InstitusiDirectoryHelper::getDokumenLkPath($dokumenLkInstitusi->lkInstitusi->akreditasiInstitusi);
            $deleteDokumen = FileHelper::unlink($path . '/' . $dokumenLkInstitusi->nama_dokumen);
            if ($deleteDokumen) {
                $dokumenLkInstitusi->delete();
                Yii::$app->session->setFlash('success', 'Berhasil menghapus dokumen lk');
                return $this->redirect(['lk/isi', 'lk' => $dokumenLkInstitusi->lkInstitusi->id]);
            }
            Yii::$app->session->setFlash('success', 'Gagal menghapus dokumen lk');
            return $this->redirect(['lk/isi', 'lk' => $dokumenLkInstitusi->lkInstitusi->id]);
        }

        return new MethodNotAllowedHttpException('Harus melalui prosedur penghapusan data.');
    }
}
