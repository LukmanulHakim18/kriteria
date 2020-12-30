<?php


namespace akreditasi\modules\kriteria9\modules\prodi\controllers;

use akreditasi\models\kriteria9\forms\lk\prodi\K9LinkLkProdiKriteriaDetailForm;
use akreditasi\models\kriteria9\forms\lk\prodi\K9LkProdiKriteriaDetailForm;
use akreditasi\models\kriteria9\forms\lk\prodi\K9TextLkProdiKriteriaDetailForm;
use akreditasi\modules\kriteria9\controllers\BaseController;
use common\helpers\DownloadDokumenTrait;
use common\helpers\kriteria9\K9ProdiDirectoryHelper;
use common\helpers\kriteria9\K9ProdiJsonHelper;
use common\helpers\NomorKriteriaHelper;
use common\models\kriteria9\akreditasi\K9Akreditasi;
use common\models\kriteria9\forms\lk\K9PencarianLkProdiForm;
use common\models\kriteria9\lk\prodi\K9LkProdi;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria1;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria2;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria3;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria4;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria5;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria6;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria7;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria8;
use common\models\ProgramStudi;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\MethodNotAllowedHttpException;
use yii\web\UploadedFile;
use yii2mod\collection\Collection;

class LkController extends BaseController
{

    protected $lkView = '@akreditasi/modules/kriteria9/modules/prodi/views/lk/isi';
    protected $lihatLkKriteria = '@akreditasi/modules/kriteria9/modules/prodi/views/lk/isi-kriteria';
    protected $itemLkView = '@akreditasi/modules/kriteria9/modules/prodi/views/lk/_item_lk';
    use DownloadDokumenTrait;

    public function actionArsip($target, $prodi)
    {

        $model = new K9PencarianLkProdiForm();

        $idAkreditasiProdi = K9Akreditasi::findAll(['jenis_akreditasi' => 'prodi']);
        $dataAkreditasiProdi = ArrayHelper::map($idAkreditasiProdi, 'id', function ($data) {
            return $data->lembaga . ' - ' . $data->nama . '(' . $data->tahun . ')';
        });

        $idProdi = ProgramStudi::findAll(['id' => $prodi]);
        $dataProdi = ArrayHelper::map($idProdi, 'id', function ($data) {
            return $data->nama . '(' . $data->jenjang . ')';
        });


        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                $url = $model->cari($target);
                $lk = $model->getLk();
                $newUrl = [];
                if (!$lk) {
                    $newUrl = false;
                } else {
                    $newUrl = [$url, 'lk' => $lk->id, 'prodi' => $prodi];
                }
                return $this->renderAjax('_hasil-arsip', ['lk' => $lk, 'url' => $newUrl]);
            }
        }
        return $this->render('arsip', [
            'model' => $model,
            'dataAkreditasiProdi' => $dataAkreditasiProdi,
            'dataProdi' => $dataProdi
        ]);
    }

    public function actionIsi($lk, $prodi)
    {
        $lkProdi = K9LkProdi::findOne($lk);
        $programStudi = $lkProdi->akreditasiProdi->prodi;
        $json = K9ProdiJsonHelper::getAllJsonLk($programStudi->jenjang);
        $kriteria = $this->getArrayKriteria($lk);
        $institusi = Yii::$app->params['institusi'];

        return $this->render('isi', [
            'lkProdi' => $lkProdi,
            'kriteria' => $kriteria,
            'institusi' => $institusi,
            'json' => $json,
            'prodi' => $programStudi,
            'untuk' => 'isi'
        ]);
    }

    protected function getArrayKriteria($lk)
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

    public function actionLihat($lk, $prodi)
    {
        $lkProdi = K9LkProdi::findOne($lk);
        $programStudi = $lkProdi->akreditasiProdi->prodi;
        $json = K9ProdiJsonHelper::getAllJsonLk($programStudi->jenjang);
        $kriteria = $this->getArrayKriteria($lk);
        $institusi = Yii::$app->params['institusi'];

        return $this->render($this->lkView, [
            'lkProdi' => $lkProdi,
            'kriteria' => $kriteria,
            'institusi' => $institusi,
            'json' => $json,
            'prodi' => $programStudi,
            'untuk' => 'lihat'
        ]);
    }

    public function actionIsiKriteria($lk, $kriteria, $prodi)
    {
        $lkProdi = K9LkProdi::findOne($lk);

        $programStudi = $lkProdi->akreditasiProdi->prodi;
        $json = K9ProdiJsonHelper::getJsonKriteriaLk($kriteria, $programStudi->jenjang);

        $poinKriteria = $json->butir;

        $path = K9ProdiDirectoryHelper::getDokumenLkUrl($lkProdi->akreditasiProdi);
        $attrKriteria = 'k9LkProdiKriteria' . $kriteria . 's';
        $lkProdiKriteria = $lkProdi->$attrKriteria;

        $modelNarasiClass = 'akreditasi\\models\\kriteria9\\lk\\prodi\\K9LkProdiNarasiKriteria' . $kriteria . 'Form';
        $modelNarasi = call_user_func($modelNarasiClass . '::findOne',
            ['id_lk_prodi_kriteria' . $kriteria => $lkProdiKriteria->id]);

        $dokModel = new K9LkProdiKriteriaDetailForm();
        $dokTextModel = new K9TextLkProdiKriteriaDetailForm();
        $dokLinkModel = new K9LinkLkProdiKriteriaDetailForm();

        if ($dokModel->load(Yii::$app->request->post())) {
            $dokModel->isiDokumen = UploadedFile::getInstance($dokModel, 'isiDokumen');

            if ($dokModel->uploadDokumen($lkProdiKriteria->id, $kriteria)) {
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
            if ($dokTextModel->uploadText($lkProdiKriteria->id, $kriteria)) {
                Yii::$app->session->setFlash('success', 'Berhasil Tambah Teks');
                return $this->redirect(Url::current());
            } else {
                Yii::$app->session->setFlash('error', 'Gagal Tambah Teks');
                return $this->redirect(Url::current());
            }
        }

        if ($dokLinkModel->load(Yii::$app->request->post())) {
            if ($dokLinkModel->uploadLink($lkProdiKriteria->id, $kriteria)) {
                Yii::$app->session->setFlash('success', 'Berhasil Tambah Tautan');
                return $this->redirect(Url::current());
            } else {
                Yii::$app->session->setFlash('error', 'Gagal Tambah Tautan');
                return $this->redirect(Url::current());
            }
        }


        return $this->render($this->lihatLkKriteria, [
            'modelNarasi' => $modelNarasi,
            'lkProdi' => $lkProdi,
            'poinKriteria' => $poinKriteria,
            'modelKriteria' => $lkProdiKriteria,
            'path' => $path,
            'prodi' => $programStudi,
            'untuk' => 'isi',
            'kriteria' => $kriteria
        ]);
    }

    public function actionButirItem($lk, $prodi, $kriteria, $untuk, $poin)
    {
        $lkProdi = K9LkProdi::findOne($lk);
        $programStudi = $lkProdi->akreditasiProdi->prodi;
        //json
        $currentPoint = $this->getKriteriaNomor($kriteria, $poin, $programStudi->jenjang);

        $path = K9ProdiDirectoryHelper::getDokumenLkUrl($lkProdi->akreditasiProdi);
        $lkProdiKriteriaClass = 'common\\models\\kriteria9\\lk\\prodi\\K9LkProdiKriteria' . $kriteria;
        $lkProdiKriteria = call_user_func($lkProdiKriteriaClass . '::findOne', ['id_lk_prodi' => $lkProdi->id]);
        $detailAttr = 'k9LkProdiKriteria' . $kriteria . 'Details';
        $detail = $lkProdiKriteria->$detailAttr;
        $lkCollection = Collection::make($detail);
        $modelNarasiClass = 'akreditasi\\models\\kriteria9\\lk\\prodi\\K9LkProdiNarasiKriteria' . $kriteria . 'Form';
        $modelNarasi = call_user_func($modelNarasiClass . '::findOne',
            ['id_lk_prodi_kriteria' . $kriteria => $lkProdiKriteria->id]);

        $dokUploadModel = new K9LkProdiKriteriaDetailForm();
        $dokTextModel = new K9TextLkProdiKriteriaDetailForm();
        $dokLinkModel = new K9LinkLkProdiKriteriaDetailForm();

        return $this->renderAjax($this->itemLkView, [
            'lkProdi' => $lkProdi,
            'prodi' => $programStudi,
            'item' => $currentPoint,
            'path' => $path,
            'modelKriteria' => $lkProdiKriteria,
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
        $data = K9ProdiJsonHelper::getJsonKriteriaLk($kriteria, $jenis);
        return Collection::make($data->butir)->where('tabel', $item)->first();
    }

    public function actionLihatKriteria($lk, $kriteria, $prodi)
    {
        $lkProdi = K9LkProdi::findOne($lk);

        $programStudi = $lkProdi->akreditasiProdi->prodi;
        $json = K9ProdiJsonHelper::getJsonKriteriaLk($kriteria, $programStudi->jenjang);

        $poinKriteria = $json->butir;

        $path = K9ProdiDirectoryHelper::getDokumenLkUrl($lkProdi->akreditasiProdi);
        $attrKriteria = 'k9LkProdiKriteria' . $kriteria . 's';
        $lkProdiKriteria = $lkProdi->$attrKriteria;


        $modelNarasiClass = 'akreditasi\\models\\kriteria9\\lk\\prodi\\K9LkProdiNarasiKriteria' . $kriteria . 'Form';
        $modelNarasi = call_user_func($modelNarasiClass . '::findOne',
            ['id_lk_prodi_kriteria' . $kriteria => $lkProdiKriteria->id]);

        return $this->render($this->lihatLkKriteria, [
            'modelNarasi' => $modelNarasi,
            'lkProdi' => $lkProdi,
            'poinKriteria' => $poinKriteria,
            'modelKriteria' => $lkProdiKriteria,
            'untuk' => 'lihat',
            'prodi' => $programStudi,
            'kriteria' => $kriteria
        ]);
    }

    public function actionDownloadDetail($dokumen, $kriteria, $lk, $prodi, $jenis)
    {
        ini_set('max_execution_time', 5 * 60);

        $detailClass = 'common\\models\\kriteria9\\lk\\prodi\\K9LkProdiKriteria' . $kriteria . 'Detail';

        $model = call_user_func($detailClass . '::findOne', $dokumen);
        $attribute = 'lkProdiKriteria' . $kriteria;

        $path = K9ProdiDirectoryHelper::getDokumenLkPath($model->$attribute->lkProdi->akreditasiProdi);
        $file = $model->isi_dokumen;

        $path = $this->download($model, $path, $file);


        return Yii::$app->response->sendFile($path);
    }

    public function actionHapusDetail()
    {
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('dokumen');
            $kriteria = Yii::$app->request->post('kriteria');
            $lk = Yii::$app->request->post('lk');
            $prodi = Yii::$app->request->post('prodi');

            $namespace = 'common\\models\\kriteria9\\lk\\prodi';
            $class = $namespace . '\\K9LkProdiKriteria' . $kriteria . 'Detail';
            $model = call_user_func($class . '::findOne', $id);
            $attr = 'lkProdiKriteria' . $kriteria;


            $path = K9ProdiDirectoryHelper::getDokumenLkPath($model->$attr->lkProdi->akreditasiProdi);
            $file = $model->isi_dokumen;

            if ($model->bentuk_dokumen === 'text') {
                $model->delete();
                Yii::$app->session->setFlash('success', "Teks Tabel $model->kode_dokumen berhasil dihapus");
                return $this->redirect(['lk/isi-kriteria', 'kriteria' => $kriteria, 'lk' => $lk, 'prodi' => $prodi]);
            }
            if ($model->bentuk_dokumen === 'link') {
                $model->delete();
                Yii::$app->session->setFlash('success', "Tautan Tabel $model->kode_dokumen berhasil dihapus");
                return $this->redirect(['lk/isi-kriteria', 'kriteria' => $kriteria, 'lk' => $lk, 'prodi' => $prodi]);
            }

            if ($model->jenis_dokumen === 'lainnya') {
                unlink("$path/lainnya/$file");
                $model->delete();

                Yii::$app->session->setFlash('success', "Dokumen Tabel $model->kode_dokumen berhasil dihapus");
                return $this->redirect(['lk/isi-kriteria', 'kriteria' => $kriteria, 'lk' => $lk, 'prodi' => $prodi]);
            }
            if ($model->jenis_dokumen === 'sumber') {
                unlink("$path/sumber/$file");
                $model->delete();

                Yii::$app->session->setFlash('success', "Dokumen Tabel $model->kode_dokumen berhasil dihapus");
                return $this->redirect(['lk/isi-kriteria', 'kriteria' => $kriteria, 'lk' => $lk, 'prodi' => $prodi]);
            }
            if ($model->jenis_dokumen === 'pendukung') {
                unlink("$path/pendukung/$file");
                $model->delete();

                Yii::$app->session->setFlash('success', "Dokumen Tabel $model->kode_dokumen berhasil dihapus");
                return $this->redirect(['lk/isi-kriteria', 'kriteria' => $kriteria, 'lk' => $lk, 'prodi' => $prodi]);
            }

            unlink("$path/$file");
            $model->delete();

            Yii::$app->session->setFlash('success', "Dokumen Tabel $model->kode_dokumen berhasil dihapus");
            return $this->redirect(['lk/isi-kriteria', 'kriteria' => $kriteria, 'lk' => $lk, 'prodi' => $prodi]);
        }
        throw new MethodNotAllowedHttpException('Request Harus Post');
    }

    protected function getJsonData()
    {
        $fileJson = 'lkps_prodi_Sarjana.json';
        $json = Json::decode(file_get_contents(Yii::getAlias('@common/required/kriteria9/aps/' . $fileJson)));
        return $json;
    }
}
