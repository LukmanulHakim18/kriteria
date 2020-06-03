<?php
/**
 * Project: mutu-v2.
 * @author Adryan Eka Vandra <adryanekavandra@gmail.com>
 *
 * Date: 9/7/2019
 * Time: 12:36 AM
 */

namespace akreditasi\modules\kriteria9\modules\institusi\controllers;


use akreditasi\models\kriteria9\forms\led\K9DetailLedInstitusiLinkForm;
use akreditasi\models\kriteria9\forms\led\K9DetailLedInstitusiTeksForm;
use akreditasi\models\kriteria9\forms\led\K9DetailLedInstitusiUploadForm;
use akreditasi\models\kriteria9\forms\led\K9DokumenLedInstitusiUploadForm;
use common\helpers\kriteria9\K9InstitusiDirectoryHelper;
use common\models\Constants;
use common\models\kriteria9\akreditasi\K9Akreditasi;
use common\models\kriteria9\forms\led\K9PencarianLedInstitusiForm;
use common\models\kriteria9\led\institusi\K9DokumenLedInstitusi;
use common\models\kriteria9\led\institusi\K9LedInstitusi;
use common\models\kriteria9\led\institusi\K9LedInstitusiKriteria1;
use common\models\kriteria9\led\institusi\K9LedInstitusiKriteria2;
use common\models\kriteria9\led\institusi\K9LedInstitusiKriteria3;
use common\models\kriteria9\led\institusi\K9LedInstitusiKriteria4;
use common\models\kriteria9\led\institusi\K9LedInstitusiKriteria5;
use common\models\kriteria9\led\institusi\K9LedInstitusiKriteria6;
use common\models\kriteria9\led\institusi\K9LedInstitusiKriteria7;
use common\models\kriteria9\led\institusi\K9LedInstitusiKriteria8;
use common\models\kriteria9\led\institusi\K9LedInstitusiKriteria9;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\MethodNotAllowedHttpException;
use yii\web\UploadedFile;

class LedController extends BaseController
{

    public function actionArsip($target)
    {

        $model = new K9PencarianLedInstitusiForm();
        $akreditasi = K9Akreditasi::findAll(['jenis_akreditasi' => Constants::INSTITUSI]);
        $dataAkreditasi = ArrayHelper::map($akreditasi, 'id', function ($data) {
            return $data->nama . " (" . $data->tahun . ")";
        });

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                $url = $model->cari($target);
                $led = $model->getLed();
                $newUrl = [];
                if (!$led) $newUrl = false;
                else $newUrl = $url;

                return $this->renderAjax('_hasil-arsip', ['led' => $led, 'url' => $newUrl]);

            }
        }
        return $this->render('arsip', [
            'model' => $model,
            'dataAkreditasi' => $dataAkreditasi]);

    }

    public function actionIsi($led)
    {
        $ledInstitusi = K9LedInstitusi::findOne($led);

        $modelDokumen = new K9DokumenLedInstitusiUploadForm();
        $dataDokumen = K9DokumenLedInstitusi::findAll(['id_led_institusi' => $led]);
        $json = $this->getJsonData();
        $kriteria = $this->getArrayKriteria($led);
        $realPath = K9InstitusiDirectoryHelper::getDokumenLedUrl($ledInstitusi->akreditasiInstitusi);

        if ($modelDokumen->load(Yii::$app->request->post())) {

            $dokumen = $this->uploadDokumenLed($led);
            if ($dokumen) {
                $model = new K9DokumenLedInstitusi();
                $model->id_led_institusi = $ledInstitusi->id;
                $model->nama_dokumen = $dokumen->getNamaDokumen();
                $model->bentuk_dokumen = $dokumen->getBentukDokumen();
                $model->save(false);

                Yii::$app->session->setFlash('success', 'Berhasil mengunggah Dokumen LED');
                return $this->redirect(Url::current());
            }
            Yii::$app->session->setFlash('warning', 'Gagal mengunggah Dokumen LED');
            return $this->redirect(Url::current());
        }

        return $this->render('led', [
            'led' => $ledInstitusi,
            'modelDokumen' => $modelDokumen,
            'dataDokumen' => $dataDokumen,
            'json' => $json,
            'kriteria' => $kriteria,
            'path' => $realPath
        ]);
    }

    protected function getJsonData()
    {
        $fileJson = 'led_institusi.json';
        $json = Json::decode(file_get_contents(Yii::getAlias('@common/required/kriteria9/apt/' . $fileJson)));
        return $json;

    }

    protected function getArrayKriteria($led)
    {
        $kriteria1 = K9LedInstitusiKriteria1::findOne(['id_led_institusi' => $led]);
        $kriteria2 = K9LedInstitusiKriteria2::findOne(['id_led_institusi' => $led]);
        $kriteria3 = K9LedInstitusiKriteria3::findOne(['id_led_institusi' => $led]);
        $kriteria4 = K9LedInstitusiKriteria4::findOne(['id_led_institusi' => $led]);
        $kriteria5 = K9LedInstitusiKriteria5::findOne(['id_led_institusi' => $led]);
        $kriteria6 = K9LedInstitusiKriteria6::findOne(['id_led_institusi' => $led]);
        $kriteria7 = K9LedInstitusiKriteria7::findOne(['id_led_institusi' => $led]);
        $kriteria8 = K9LedInstitusiKriteria8::findOne(['id_led_institusi' => $led]);
        $kriteria9 = K9LedInstitusiKriteria9::findOne(['id_led_institusi' => $led]);

        $kriteria = [$kriteria1, $kriteria2, $kriteria3, $kriteria4, $kriteria5, $kriteria6, $kriteria7, $kriteria8, $kriteria9];

        return $kriteria;
    }

    protected function uploadDokumenLed($led)
    {
        $ledInstitusi = K9LedInstitusi::findOne($led);

        $dokumenLed = new K9DokumenLedInstitusiUploadForm();
        $dokumenLed->dokumenLed = UploadedFile::getInstance($dokumenLed, 'dokumenLed');
        $realPath = K9InstitusiDirectoryHelper::getDokumenLedPath($ledInstitusi->akreditasiInstitusi);
        $response = null;

        if ($dokumenLed->validate()) {

            $uploaded = $dokumenLed->uploadDokumen($realPath);
            if ($uploaded) {
                $response = $dokumenLed;
            }

        }

        return $response;


    }

    public function actionHapusDokumenLed()
    {
        if (Yii::$app->request->isPost) {

            $data = Yii::$app->request->post();

            $idDokumenLed = $data['id'];
            $dokumenLedInstitusi = K9DokumenLedInstitusi::findOne($idDokumenLed);
            $path = K9InstitusiDirectoryHelper::getDokumenLedPath($dokumenLedInstitusi->ledInstitusi->akreditasiInstitusi);
            $deleteDokumen = FileHelper::unlink($path . "/" . $dokumenLedInstitusi->nama_dokumen);
            if ($deleteDokumen) {
                $dokumenLedInstitusi->delete();
                Yii::$app->session->setFlash('success', 'Berhasil menghapus dokumen led');
                return $this->redirect(['led/isi', 'led' => $dokumenLedInstitusi->ledInstitusi->id]);

            }
            Yii::$app->session->setFlash('success', 'Gagal menghapus dokumen led');
            return $this->redirect(['led/isi', 'led' => $dokumenLedInstitusi->ledInstitusi->id]);

        }

        return new MethodNotAllowedHttpException('Harus melalui prosedur penghapusan data.');

    }

    public function actionDownloadDokumen($dokumen)
    {
        ini_set('max_execution_time', 5 * 60);
        $model = K9DokumenLedInstitusi::findOne($dokumen);
        $file = K9InstitusiDirectoryHelper::getDokumenLedPath($model->ledInstitusi->akreditasiInstitusi) . "/{$model->nama_dokumen}";
        return Yii::$app->response->sendFile($file);
    }

    public function actionIsiKriteria($led, $kriteria)
    {

        $modelLedClass = 'common\\models\\kriteria9\\led\\institusi\\K9LedInstitusiKriteria' . $kriteria;
        $modelLed = call_user_func($modelLedClass . '::findOne', $led);

        $modelNarasiClass = 'akreditasi\\models\\kriteria9\\led\\institusi\\K9LedInstitusiNarasiKriteria' . $kriteria . 'Form';
        $modelNarasi = call_user_func($modelNarasiClass . '::findOne', ['id_led_institusi_kriteria' . $kriteria => $modelLed->id]);
        $relasiNarasiAttr = 'ledInstitusiKriteria' . $kriteria;


        $json = $this->getJsonData();
        $dataKriteria = $json[$kriteria - 1];
        $poinKriteria = $dataKriteria['butir'];


        $detailModel = new K9DetailLedInstitusiUploadForm();
        $textModel = new K9DetailLedInstitusiTeksForm();
        $linkModel = new K9DetailLedInstitusiLinkForm();


        $realPath = K9InstitusiDirectoryHelper::getDetailLedUrl($modelLed->ledInstitusi->akreditasiInstitusi);


        if ($modelNarasi->load(Yii::$app->request->post())) {
            $modelNarasi->save();
            Yii::$app->session->setFlash('success', 'Berhasil Memperbarui Entri');
            return $this->redirect(Url::current());

        }
        if ($detailModel->load(Yii::$app->request->post())) {
            $detailModel->berkasDokumen = UploadedFile::getInstance($detailModel, 'berkasDokumen');

            if ($detailModel->uploadDokumen($modelLed->id, $kriteria)) {
                Yii::$app->session->setFlash('success', 'Berhasil Mengunggah Dokumen');
                return $this->redirect(Url::current());

            }

            Yii::$app->session->setFlash('warning', 'Gagal menunggah Dokumen');
            return $this->redirect(Url::current());

        }
        if ($textModel->load(Yii::$app->request->post())) {
            if ($textModel->save($led, $kriteria)) {
                Yii::$app->session->setFlash('success', 'Berhasil Menambahkan dokumen');
                return $this->redirect(Url::current());
            }
            Yii::$app->session->setFlash('warning', 'Gagal Menambahkan Dokumen');
            return $this->redirect(Url::current());

        }

        if ($linkModel->load(Yii::$app->request->post())) {
            if ($linkModel->save($led, $kriteria)) {
                Yii::$app->session->setFlash('success', 'Berhasil Menambahkan dokumen');
                return $this->redirect(Url::current());
            }
            Yii::$app->session->setFlash('warning', 'Gagal Menambahkan Dokumen');
            return $this->redirect(Url::current());

        }


        return $this->render('isi-kriteria', [
            'model' => $modelLed,
            'modelNarasi' => $modelNarasi,
            'poinKriteria' => $poinKriteria,
            'detailModel' => $detailModel,
            'path' => $realPath,
            'textModel' => $textModel,
            'linkModel' => $linkModel

        ]);
    }

    public function actionHapusDetail()
    {
        if (Yii::$app->request->isPost) {

            $data = Yii::$app->request->post();
            $idDokumen = $data['dokumen'];
            $kriteria = $data['kriteria'];
            $idLed = $data['led'];
            $jenis = $data['jenis'];

            $namespace = 'common\\models\\kriteria9\\led\\institusi';
            $classPath = "$namespace\\K9LedInstitusiKriteria$kriteria" . "Detail";
            $model = call_user_func("$classPath::findOne", $idDokumen);
            $led = K9LedInstitusi::findOne($idLed);
            if (!$model->bentuk_dokumen === Constants::TEXT && !$model->bentuk_dokumen === Constants::LINK) {
                $dokumenPath = K9InstitusiDirectoryHelper::getDokumenLedPath($led->akreditasiInstitusi);
                FileHelper::unlink("$dokumenPath/$jenis/$model->isi_dokumen");
            }
            $model->delete();

            Yii::$app->session->setFlash('success', 'Berhasil menghapus dokumen');
            return $this->redirect(['led/isi-kriteria', 'led' => $idLed, 'kriteria' => $kriteria]);
        }

        return new MethodNotAllowedHttpException('Penghapusan harus sesuai prosedur.');
    }

    public function actionDownloadDetail($kriteria, $dokumen, $led, $jenis)
    {
        ini_set('max_execution_time', 5 * 60);
        $led = K9LedInstitusi::findOne($led);
        $namespace = 'common\\models\\kriteria9\\led\\institusi';
        $className = "$namespace\\K9LedInstitusiKriteria$kriteria" . "Detail";
        $model = call_user_func($className . '::findOne', $dokumen);
        $file = K9InstitusiDirectoryHelper::getDokumenLedPath($led->akreditasiInstitusi) . "/$jenis/{$model->isi_dokumen}";
        return Yii::$app->response->sendFile($file);
    }

    public function actionLihat($led)
    {
        $ledInstitusi = K9LedInstitusi::findOne($led);

        $dataDokumen = K9DokumenLedInstitusi::findAll(['id_led_institusi' => $led]);
        $json = $this->getJsonData();
        $kriteria = $this->getArrayKriteria($led);
        $realPath = K9InstitusiDirectoryHelper::getDokumenLedUrl($ledInstitusi->akreditasiInstitusi);


        return $this->render('lihat-led', [
            'led' => $ledInstitusi,
            'dataDokumen' => $dataDokumen,
            'json' => $json,
            'kriteria' => $kriteria,
            'path' => $realPath
        ]);
    }

    public function actionLihatKriteria($led, $kriteria)
    {

        $modelLedClass = 'common\\models\\kriteria9\\led\\institusi\\K9LedInstitusiKriteria' . $kriteria;
        $modelLed = call_user_func($modelLedClass . '::findOne', $led);

        $modelNarasiClass = 'akreditasi\\models\\kriteria9\\led\\institusi\\K9LedInstitusiNarasiKriteria' . $kriteria . 'Form';
        $modelNarasi = call_user_func($modelNarasiClass . '::findOne', ['id_led_institusi_kriteria' . $kriteria => $modelLed->id]);
        $relasiNarasiAttr = 'ledInstitusiKriteria' . $kriteria;


        $json = $this->getJsonData();
        $dataKriteria = $json[$kriteria - 1];
        $poinKriteria = $dataKriteria['butir'];


        $realPath = K9InstitusiDirectoryHelper::getDetailLedUrl($modelLed->ledInstitusi->akreditasiInstitusi);


        return $this->render('lihat-kriteria', [
            'model' => $modelLed,
            'modelNarasi' => $modelNarasi,
            'poinKriteria' => $poinKriteria,
            'path' => $realPath,

        ]);
    }
}
