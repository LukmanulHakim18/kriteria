<?php


namespace akreditasi\modules\kriteria9\modules\prodi\controllers;


use akreditasi\models\kriteria9\forms\lk\prodi\K9LinkLkProdiKriteriaDetailForm;
use akreditasi\models\kriteria9\forms\lk\prodi\K9LkProdiKriteriaDetailForm;
use akreditasi\models\kriteria9\forms\lk\prodi\K9TextLkProdiKriteriaDetailForm;
use akreditasi\modules\kriteria9\controllers\BaseController;
use common\helpers\kriteria9\K9ProdiDirectoryHelper;
use common\models\kriteria9\akreditasi\K9Akreditasi;
use common\models\kriteria9\forms\lk\K9PencarianLkProdiForm;
use common\models\kriteria9\lk\K9LkTemplate;
use common\models\kriteria9\lk\prodi\K9LkProdi;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria1;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria1Detail;
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
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;

class LkController extends BaseController
{

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
        $file_json = 'lkps_prodi_s1.json';
        $lkProdi = K9LkProdi::findOne($lk);

        $json = $this->getJsonData();
        $kriteria = $this->getArrayKriteria($lk);
        $institusi = Yii::$app->params['institusi'];

        return $this->render('isi', [
            'lkProdi' => $lkProdi,
            'kriteria' => $kriteria,
            'institusi' => $institusi,
            'json' => $json
        ]);
    }

    protected function getJsonData()
    {
        $fileJson = 'lkps_prodi_s1.json';
        $json = Json::decode(file_get_contents(Yii::getAlias('@common/required/kriteria9/aps/' . $fileJson)));
        return $json;

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

        $kriteria = [$kriteria1, $kriteria2, $kriteria3, $kriteria4, $kriteria5, $kriteria6, $kriteria7, $kriteria8];

        return $kriteria;
    }

    public function actionIsiKriteria($lk, $kriteria, $prodi)
    {

        $json = $this->getJsonData();
        $dataKriteria = $json[$kriteria - 1];
        $poinKriteria = $dataKriteria['butir'];
        $lkProdi = K9LkProdi::findOne($lk);

        $modelNarasiClass = 'akreditasi\\models\\kriteria9\\lk\\prodi\\K9lkProdiNarasiKriteria' . $kriteria . 'Form';
        $modelNarasi = call_user_func($modelNarasiClass . '::findOne', $lk);

        $dokModel = new K9LkProdiKriteriaDetailForm();
        $dokTextModel = new K9TextLkProdiKriteriaDetailForm();
        $dokLinkModel = new K9LinkLkProdiKriteriaDetailForm();

        if ($dokModel->load(Yii::$app->request->post())) {

            $dokModel->isiDokumen = UploadedFile::getInstance($dokModel, 'isiDokumen');

            if ($dokModel->uploadDokumen($lk, $kriteria)) {

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
            if ($dokTextModel->uploadText($lk, $kriteria)) {
                Yii::$app->session->setFlash('success', 'Berhasil Tambah Teks');
                return $this->redirect(Url::current());
            } else {
                Yii::$app->session->setFlash('error', 'Gagal Tambah Teks');
                return $this->redirect(Url::current());
            }
        }

        if ($dokLinkModel->load(Yii::$app->request->post())) {
            if ($dokLinkModel->uploadLink($lk, $kriteria)) {
                Yii::$app->session->setFlash('success', 'Berhasil Tambah Tautan');
                return $this->redirect(Url::current());
            } else {
                Yii::$app->session->setFlash('error', 'Gagal Tambah Tautan');
                return $this->redirect(Url::current());
            }
        }


        return $this->render('isi-kriteria', [
            'modelNarasi' => $modelNarasi,
            'lkProdi' => $lkProdi,
            'json' => $json,
            'dokModel' => $dokModel,
            'dokTextModel' => $dokTextModel,
            'dokLinkModel' => $dokLinkModel,
            'dataKriteria' => $dataKriteria,
            'poinKriteria' => $poinKriteria
        ]);
    }

    public function actionDownloadTemplate($id)
    {
        ini_set('max_execution_time', 5 * 60);
        $template = K9LkTemplate::findOne($id);
        $path = K9ProdiDirectoryHelper::getTemplateLkPath();
        $file = $template->nama_file;

        return Yii::$app->response->sendFile("$path/$file");
    }

    public function actionDownloadDok($id)
    {
        ini_set('max_execution_time', 5 * 60);
        $model = K9LkProdiKriteria1Detail::findOne($id);
        $path = K9ProdiDirectoryHelper::getDokumenLkPath($model->lkProdiKriteria1->lkProdi->akreditasiProdi);
        $file = $model->isi_dokumen;

        if ($model->jenis_dokumen == 'lainnya') {
            return Yii::$app->response->sendFile("$path/lainnya/$file");
        } elseif ($model->jenis_dokumen == 'sumber') {
            return Yii::$app->response->sendFile("$path/sumber/$file");
        } elseif ($model->jenis_dokumen == 'pendukung') {
            return Yii::$app->response->sendFile("$path/pendukung/$file");
        } else {
            return Yii::$app->response->sendFile("$path/$file");
        }

    }

    public function actionHapusDok()
    {
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('id');
            $kriteria = Yii::$app->request->post('kriteria');
            $lk = Yii::$app->request->post('lk');
            $prodi = Yii::$app->request->post('prodi');

            $namespace = 'common\\models\\kriteria9\\lk\\prodi\\K9';
            $class = $namespace . 'LkProdiKriteria' . $kriteria . 'Detail';
            $model = call_user_func($class . '::findOne', $id);

            $path = K9ProdiDirectoryHelper::getDokumenLkPath($model->lkProdiKriteria1->lkProdi->akreditasiProdi);
            $file = $model->isi_dokumen;

            if ($model->bentuk_dokumen == 'text') {
                $model->delete();
                Yii::$app->session->setFlash('success', "Teks Tabel $model->kode_dokumen berhasil dihapus");
                return $this->redirect(['lk/isi-kriteria', 'kriteria' => $kriteria, 'lk' => $lk, 'prodi' => $prodi]);
            }
            if ($model->bentuk_dokumen == 'link') {
                $model->delete();
                Yii::$app->session->setFlash('success', "Tautan Tabel $model->kode_dokumen berhasil dihapus");
                return $this->redirect(['lk/isi-kriteria', 'kriteria' => $kriteria, 'lk' => $lk, 'prodi' => $prodi]);
            }

            if ($model->jenis_dokumen == 'lainnya') {
                unlink("$path/lainnya/$file");
                $model->delete();

                Yii::$app->session->setFlash('success', "Dokumen Tabel $model->kode_dokumen berhasil dihapus");
                return $this->redirect(['lk/isi-kriteria', 'kriteria' => $kriteria, 'lk' => $lk, 'prodi' => $prodi]);
            }
            if ($model->jenis_dokumen == 'sumber') {
                unlink("$path/sumber/$file");
                $model->delete();

                Yii::$app->session->setFlash('success', "Dokumen Tabel $model->kode_dokumen berhasil dihapus");
                return $this->redirect(['lk/isi-kriteria', 'kriteria' => $kriteria, 'lk' => $lk, 'prodi' => $prodi]);
            }
            if ($model->jenis_dokumen == 'pendukung') {
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
        throw new BadRequestHttpException('Request Harus Post');
    }

}