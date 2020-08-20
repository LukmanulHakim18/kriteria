<?php


namespace akreditasi\modules\kriteria9\modules\institusi\controllers;

use akreditasi\models\kriteria9\forms\lk\institusi\K9LinkLkInstitusiKriteriaDetailForm;
use akreditasi\models\kriteria9\forms\lk\institusi\K9LkInstitusiKriteriaDetailForm;
use akreditasi\models\kriteria9\forms\lk\institusi\K9TextLkInstitusiKriteriaDetailForm;
use common\helpers\kriteria9\K9InstitusiDirectoryHelper;
use common\models\kriteria9\akreditasi\K9Akreditasi;
use common\models\kriteria9\forms\lk\K9PencarianLkInstitusiForm;
use common\models\kriteria9\lk\institusi\K9LkInstitusi;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria1;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria1Detail;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria2;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria3;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria4;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria5;
use common\models\kriteria9\lk\K9LkTemplate;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;

class LkController extends BaseController
{

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
        $json = $this->getJsonData();
        $kriteria = $this->getArrayKriteria($lk);
        $institusi = Yii::$app->params['institusi'];

        return $this->render('isi', [
            'lkInstitusi' => $lkInstitusi,
            'kriteria' => $kriteria,
            'institusi' => $institusi,
            'json' => $json
        ]);
    }

    protected function getJsonData()
    {
        $fileJson = 'lkpt_institusi_akademik.json';
        $json = Json::decode(file_get_contents(Yii::getAlias('@common/required/kriteria9/apt/' . $fileJson)));
        return $json;
    }

    protected function getArrayKriteria($lk)
    {
        $kriteria1 = K9LkInstitusiKriteria1::findOne(['id_lk_institusi' => $lk]);
        $kriteria2 = K9LkInstitusiKriteria2::findOne(['id_lk_institusi' => $lk]);
        $kriteria3 = K9LkInstitusiKriteria3::findOne(['id_lk_institusi' => $lk]);
        $kriteria4 = K9LkInstitusiKriteria4::findOne(['id_lk_institusi' => $lk]);
        $kriteria5 = K9LkInstitusiKriteria5::findOne(['id_lk_institusi' => $lk]);


        $kriteria = [$kriteria1, $kriteria2, $kriteria3, $kriteria4, $kriteria5];

        return $kriteria;
    }

    public function actionIsiKriteria($lk, $kriteria)
    {
        $json = $this->getJsonData();
        $dataKriteria = $json[$kriteria - 1];
        $poinKriteria = $dataKriteria['butir'];
        $lkInstitusi = K9LkInstitusi::findOne($lk);

        $modelNarasiClass = 'akreditasi\\models\\kriteria9\\lk\\institusi\\K9LkInstitusiNarasiKriteria' . $kriteria . 'Form';
        $modelNarasi = call_user_func($modelNarasiClass . '::findOne', $lk);

        $dokModel = new K9LkInstitusiKriteriaDetailForm();
        $dokTextModel = new K9TextLkInstitusiKriteriaDetailForm();
        $dokLinkModel = new K9LinkLkInstitusiKriteriaDetailForm();

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
            'lkInstitusi' => $lkInstitusi,
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
        $path = K9InstitusiDirectoryHelper::getTemplateLkPath();
        $file = $template->nama_file;

        return Yii::$app->response->sendFile("$path/$file");
    }

    public function actionDownloadDok($id)
    {
        ini_set('max_execution_time', 5 * 60);
        $template = K9LkInstitusiKriteria1Detail::findOne($id);
        $path = K9InstitusiDirectoryHelper::getDokumenLkPath($template->lkInstitusiKriteria1->lkInstitusi->akreditasiInstitusi);
        $file = $template->isi_dokumen;

        return Yii::$app->response->sendFile("$path/$file");
    }

    public function actionHapusDok()
    {
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('id');
            $kriteria = Yii::$app->request->post('kriteria');
            $lk = Yii::$app->request->post('lk');

            $namespace = 'common\\models\\kriteria9\\lk\\institusi\\K9';
            $class = $namespace . 'LkInstitusiKriteria' . $kriteria . 'Detail';
            $model = call_user_func($class . '::findOne', $id);

            $path = K9InstitusiDirectoryHelper::getDokumenLkPath($model->lkInstitusiKriteria1->lkInstitusi->akreditasiInstitusi);
            $file = $model->isi_dokumen;

            if ($model->bentuk_dokumen == 'text') {
                $model->delete();
                Yii::$app->session->setFlash('success', "Teks Tabel $model->kode_dokumen berhasil dihapus");
                return $this->redirect(['lk/isi-kriteria', 'kriteria' => $kriteria, 'lk' => $lk]);
            }
            if ($model->bentuk_dokumen == 'link') {
                $model->delete();
                Yii::$app->session->setFlash('success', "Tautan Tabel $model->kode_dokumen berhasil dihapus");
                return $this->redirect(['lk/isi-kriteria', 'kriteria' => $kriteria, 'lk' => $lk]);
            }

            if ($model->jenis_dokumen == 'lainnya') {
                unlink("$path/lainnya/$file");
                $model->delete();

                Yii::$app->session->setFlash('success', "Dokumen $model->kode_dokumen berhasil dihapus");
                return $this->redirect(['lk/isi-kriteria', 'kriteria' => $kriteria, 'lk' => $lk]);
            }
            if ($model->jenis_dokumen == 'sumber') {
                unlink("$path/sumber/$file");
                $model->delete();

                Yii::$app->session->setFlash('success', "Dokumen $model->kode_dokumen berhasil dihapus");
                return $this->redirect(['lk/isi-kriteria', 'kriteria' => $kriteria, 'lk' => $lk]);
            }
            if ($model->jenis_dokumen == 'pendukung') {
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
        throw new BadRequestHttpException('Request Harus Post');
    }

    public function actionLihatDok($kriteria, $dok, $lk)
    {
    }

    public function actionHapusKriteria()
    {
    }

    public function actoinPj($kriteria)
    {
    }

    public function actionPjKriteria($kriteria, $lk)
    {
    }

    public function actionLihat($lk)
    {
    }

    public function actionLihatKriteria($kriteria, $lk)
    {
    }
}
