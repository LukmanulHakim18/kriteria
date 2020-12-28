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
use akreditasi\models\kriteria9\forms\led\K9DetailLedInstitusiNonKriteriaLinkForm;
use akreditasi\models\kriteria9\forms\led\K9DetailLedInstitusiNonKriteriaTeksForm;
use akreditasi\models\kriteria9\forms\led\K9DetailLedInstitusiNonKriteriaUploadForm;
use akreditasi\models\kriteria9\forms\led\K9DetailLedInstitusiTeksForm;
use akreditasi\models\kriteria9\forms\led\K9DetailLedInstitusiUploadForm;
use akreditasi\models\kriteria9\forms\led\K9DokumenLedInstitusiUploadForm;
use akreditasi\models\kriteria9\led\institusi\K9LedInstitusiNarasiAnalisisForm;
use akreditasi\models\kriteria9\led\institusi\K9LedInstitusiNarasiKondisiEksternalForm;
use akreditasi\models\kriteria9\led\institusi\K9LedInstitusiNarasiProfilInstitusiForm;
use common\helpers\kriteria9\K9InstitusiDirectoryHelper;
use common\helpers\kriteria9\K9InstitusiJsonHelper;
use common\helpers\NomorKriteriaHelper;
use common\models\Constants;
use common\models\kriteria9\akreditasi\K9Akreditasi;
use common\models\kriteria9\forms\led\K9PencarianLedInstitusiForm;
use common\models\kriteria9\led\institusi\K9InstitusiEksporDokumen;
use common\models\kriteria9\led\institusi\K9LedInstitusi;
use common\models\kriteria9\led\institusi\K9LedInstitusiNarasiProfilInstitusi;
use common\models\kriteria9\led\institusi\K9LedInstitusiNonKriteriaDokumen;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii2mod\collection\Collection;

class LedController extends BaseController
{
    protected $lihatLedView = '@akreditasi/modules/kriteria9/modules/institusi/views/led/led';
    protected $lihatKriteriaView = '@akreditasi/modules/kriteria9/modules/institusi/views/led/isi-kriteria';
    protected $lihatNonKriteriaView = '@akreditasi/modules/kriteria9/modules/institusi/views/led/isi-non_kriteria';

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
                if (!$led) {
                    $newUrl = false;
                } else {
                    $newUrl = $url;
                }

                return $this->renderAjax('_hasil-arsip', ['led' => $led, 'url' => $newUrl]);

            }
        }
        return $this->render('arsip', [
            'model' => $model,
            'dataAkreditasi' => $dataAkreditasi
        ]);

    }

    /**
     * @param $led
     * @return string|yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionIsi($led)
    {
        $ledInstitusi = $this->findLedInstitusi($led);

        $json_eksternal = K9InstitusiJsonHelper::getJsonLedKondisiEksternal();
        $json_profil = K9InstitusiJsonHelper::getJsonLedProfil();
        $json_kriteria = K9InstitusiJsonHelper::getAllJsonLed();
        $json_analisis = K9InstitusiJsonHelper::getJsonLedAnalisis();

        $modelEksternal = K9LedInstitusiNarasiKondisiEksternalForm::findOne(['id_led_institusi' => $ledInstitusi->id]);
        $modelProfil = K9LedInstitusiNarasiProfilInstitusiForm::findOne(['id_led_institusi' => $ledInstitusi->id]);
        $modelAnalisis = K9LedInstitusiNarasiAnalisisForm::findOne(['id_led_institusi' => $ledInstitusi->id]);

        $modelDokumen = new K9DokumenLedInstitusiUploadForm();
        $dataDokumen = K9InstitusiEksporDokumen::findAll(['id_led_institusi' => $led]);
        $kriteria = $this->getArrayKriteria($led);
        $realPath = K9InstitusiDirectoryHelper::getDokumenLedUrl($ledInstitusi->akreditasiInstitusi);

        if ($modelDokumen->load(Yii::$app->request->post())) {

            $dokumen = $this->uploadDokumenLed($led);
            if ($dokumen) {
                $model = new K9InstitusiEksporDokumen();
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
            'json' => $json_kriteria,
            'json_eksternal' => $json_eksternal,
            'json_profil' => $json_profil,
            'json_analisis' => $json_analisis,
            'kriteria' => $kriteria,
            'path' => $realPath,
            'modelEksternal' => $modelEksternal,
            'modelAnalisis' => $modelAnalisis,
            'modelProfil' => $modelProfil,
            'untuk' => 'isi'
        ]);
    }

    /**
     * @param $led
     * @return K9LedInstitusi|null
     * @throws NotFoundHttpException
     */
    protected function findLedInstitusi($led)
    {
        $model = null;
        if ($model = K9LedInstitusi::findOne($led)) {
            return $model;
        }
        throw new NotFoundHttpException();
    }

    protected function getArrayKriteria($led)
    {
        $kriteria = [];
        for ($i = 1; $i <= 9; $i++) {
            $classPath = 'common\\models\\kriteria9\\led\institusi\\K9LedInstitusiKriteria' . $i;
            $kriteria[] = call_user_func($classPath . '::findOne', ['id_led_institusi' => $led]);
        }
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
            $dokumenLedInstitusi = K9InstitusiEksporDokumen::findOne($idDokumenLed);
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
        $model = K9InstitusiEksporDokumen::findOne($dokumen);
        $file = K9InstitusiDirectoryHelper::getDokumenLedPath($model->ledInstitusi->akreditasiInstitusi) . "/{$model->nama_dokumen}";
        return Yii::$app->response->sendFile($file);
    }

    public function actionIsiKriteria($led, $kriteria)
    {

        $ledInstitusi = $this->findLedInstitusi($led);
        $attr = 'k9LedInstitusiKriteria' . $kriteria . 's';
        $modelLed = $ledInstitusi->$attr;

        $json = K9InstitusiJsonHelper::getJsonKriteriaLed($kriteria);
        $poinKriteria = $json->butir;

        $modelNarasiClass = 'akreditasi\\models\\kriteria9\\led\\institusi\\K9LedInstitusiNarasiKriteria' . $kriteria . 'Form';
        $modelNarasi = call_user_func($modelNarasiClass . '::findOne',
            ['id_led_institusi_kriteria' . $kriteria => $modelLed->id]);

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


        return $this->render($this->lihatKriteriaView, [
            'model' => $modelLed,
            'modelNarasi' => $modelNarasi,
            'poinKriteria' => $poinKriteria,
            'detailModel' => $detailModel,
            'path' => $realPath,
            'textModel' => $textModel,
            'linkModel' => $linkModel,
            'kriteria' => $kriteria,
            'untuk' => 'isi'

        ]);
    }

    public function actionIsiNonKriteria($led, $poin)
    {
        $ledInstitusi = $this->findLedInstitusi($led);

        switch ($poin) {
            case 'A':
                $modelNarasi = K9LedInstitusiNarasiKondisiEksternalForm::findOne(['id_led_institusi' => $ledInstitusi->id]);
                $json = K9InstitusiJsonHelper::getJsonLedKondisiEksternal();
                break;
            case 'B':
                $modelNarasi = K9LedInstitusiNarasiProfilInstitusiForm::findOne(['id_led_insitusi' => $ledInstitusi->id]);
                $json = K9InstitusiJsonHelper::getJsonLedProfil();
                break;
            case 'D':
                $modelNarasi = K9LedInstitusiNarasiAnalisisForm::findOne(['id_led_institusi' => $ledInstitusi->id]);
                $json = K9InstitusiJsonHelper::getJsonLedAnalisis();
                break;
        }

        $poin = $json->butir;

        $modelLink = new K9DetailLedInstitusiNonKriteriaLinkForm();
        $modelUpload = new K9DetailLedInstitusiNonKriteriaUploadForm();
        $modelTeks = new K9DetailLedInstitusiNonKriteriaTeksForm();
        $untuk = 'isi';

        if ($modelNarasi->load(Yii::$app->request->post())) {
            $modelNarasi->save();
            Yii::$app->session->setFlash('success', 'Berhasil Memperbarui Entri');
            return $this->redirect(Url::current());
        }
        if ($modelUpload->load(Yii::$app->request->post())) {
            $modelUpload->berkasDokumen = UploadedFile::getInstance($modelUpload, 'berkasDokumen');

            if ($modelUpload->uploadDokumen($ledInstitusi->id)) {
                Yii::$app->session->setFlash('success', 'Berhasil Mengunggah Dokumen');
                return $this->redirect(Url::current());
            }

            Yii::$app->session->setFlash('warning', 'Gagal menunggah Dokumen');
            return $this->redirect(Url::current());
        }
        if ($modelTeks->load(Yii::$app->request->post())) {
            if ($modelTeks->save($led)) {
                Yii::$app->session->setFlash('success', 'Berhasil Menambahkan dokumen');
                return $this->redirect(Url::current());
            }
            Yii::$app->session->setFlash('warning', 'Gagal Menambahkan Dokumen');
            return $this->redirect(Url::current());
        }

        if ($modelLink->load(Yii::$app->request->post())) {
            if ($modelLink->save($led)) {
                Yii::$app->session->setFlash('success', 'Berhasil Menambahkan dokumen');
                return $this->redirect(Url::current());
            }
            Yii::$app->session->setFlash('warning', 'Gagal Menambahkan Dokumen');
            return $this->redirect(Url::current());
        }
        return $this->render($this->lihatNonKriteriaView,
            [
                'ledInstitusi' => $ledInstitusi,
                'json' => $json,
                'poin' => $poin,
                'modelNarasi' => $modelNarasi,
                'untuk' => $untuk,
            ]);
    }

    public function actionButirItem($led, $kriteria, $poin, $untuk)
    {

        $ledInstitusi = K9LedInstitusi::findOne(['id' => $led]);
        $attr = 'k9LedInstitusiKriteria' . $kriteria . 's';
        $modelLed = $ledInstitusi->$attr;
        $detailAttr = 'k9LedInstitusiKriteria' . $kriteria . 'Details';
        $detail = $modelLed->$detailAttr;

        $detailCollection = Collection::make($detail);

        $json = K9InstitusiJsonHelper::getJsonKriteriaLed($kriteria);
        $kriteriaCollection = new Collection($json->butir);
        $currentPoint = $kriteriaCollection->where('nomor', $poin)->first();

        $modelNarasiClass = 'akreditasi\\models\\kriteria9\\led\\institusi\\K9LedInstitusiNarasiKriteria' . $kriteria . 'Form';
        $modelNarasi = call_user_func($modelNarasiClass . '::findOne',
            ['id_led_institusi_kriteria' . $kriteria => $modelLed->id]);


        $detailModel = new K9DetailLedInstitusiUploadForm();
        $textModel = new K9DetailLedInstitusiTeksForm();
        $linkModel = new K9DetailLedInstitusiLinkForm();


        $realPath = K9InstitusiDirectoryHelper::getDetailLedUrl($modelLed->ledInstitusi->akreditasiInstitusi);


        return $this->renderAjax('@akreditasi/modules/kriteria9/modules/institusi/views/led/_isi_led', [
            'model' => $modelLed,
            'modelNarasi' => $modelNarasi,
            'detailModel' => $detailModel,
            'path' => $realPath,
            'textModel' => $textModel,
            'linkModel' => $linkModel,
            'detailCollection' => $detailCollection,
            'modelAttribute' => NomorKriteriaHelper::changeToDbFormat($poin),
            'item' => $currentPoint,
            'kriteria' => $kriteria,
            'untuk' => $untuk,
            'poin' => $poin
        ]);
    }

    public function actionButirItemNonKriteria($led, $poin, $nomor, $untuk)
    {

        $ledInstitusi = K9LedInstitusi::findOne($led);

        switch ($poin) {
            case 'A':
                $json = K9InstitusiJsonHelper::getJsonLedKondisiEksternal();
                $modelNarasi = K9LedInstitusiNarasiKondisiEksternalForm::findOne(['id_led_institusi' => $ledInstitusi->id]);

                break;
            case 'B':
                $json = K9InstitusiJsonHelper::getJsonLedProfil();
                $modelNarasi = K9LedInstitusiNarasiProfilInstitusiForm::findOne(['id_led_institusi' => $ledInstitusi->id]);;

                break;
            case 'D':
                $json = K9InstitusiJsonHelper::getJsonLedAnalisis();
                $modelNarasi = K9LedInstitusiNarasiAnalisisForm::findOne(['id_led_institusi' => $ledInstitusi->id]);

                break;
        }


        $detailNarasi = $modelNarasi->documents;
        $detailCollection = Collection::make($detailNarasi);
        $modelAttribute = NomorKriteriaHelper::changeToDbFormat($nomor);
        $currentPoint = $json;
        if ($json->butir) {
            $currentCollection = Collection::make($json->butir);
            $currentPoint = $currentCollection->where('nomor', $nomor)->first();
        }

        $linkModel = new K9DetailLedInstitusiNonKriteriaLinkForm();
        $uploadModel = new K9DetailLedInstitusiNonKriteriaUploadForm();
        $textModel = new K9DetailLedInstitusiNonKriteriaUploadForm();
        $realPath = K9InstitusiDirectoryHelper::getDetailLedUrl($ledInstitusi->akreditasiInstitusi);

        return $this->renderAjax('@akreditasi/modules/kriteria9/modules/institusi/views/led/_isi_led_non_kriteria', [

            'modelNarasi' => $modelNarasi,
            'item' => $currentPoint,
            'linkModel' => $linkModel,
            'uploadModel' => $uploadModel,
            'textModel' => $textModel,
            'path' => $realPath,
            'modelAttribute' => $modelAttribute,
            'detailCollection' => $detailCollection,
            'model' => $ledInstitusi,
            'poin' => $poin,
            'untuk' => $untuk
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

    public function actionHapusDetailNonKriteria()
    {
        if (Yii::$app->request->isPost) {

            $data = Yii::$app->request->post();
            $idDokumen = $data['dokumen'];
            $poin = $data['poin'];
            $idLed = $data['led'];
            $jenis = $data['jenis'];

            $model = K9LedInstitusiNonKriteriaDokumen::findOne($idDokumen);
            $led = K9LedInstitusi::findOne($idLed);
            if (!$model->bentuk_dokumen === Constants::TEXT && !$model->bentuk_dokumen === Constants::LINK) {
                $dokumenPath = K9InstitusiDirectoryHelper::getDokumenLedPath($led->akreditasiInstitusi);
                FileHelper::unlink("$dokumenPath/$jenis/$model->isi_dokumen");
            }
            $model->delete();

            Yii::$app->session->setFlash('success', 'Berhasil menghapus dokumen');
            return $this->redirect(['led/isi-non-kriteria', 'led' => $idLed, 'poin' => $poin]);
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

    public function actionDownloadDetailNonKriteria($poin, $dokumen, $led, $jenis)
    {
        ini_set('max_execution_time', 5 * 60);
        $led = K9LedInstitusi::findOne($led);
        $model = K9LedInstitusiNonKriteriaDokumen::findOne($dokumen);
        $file = K9InstitusiDirectoryHelper::getDokumenLedPath($led->akreditasiInstitusi) . "/$jenis/{$model->isi_dokumen}";
        return Yii::$app->response->sendFile($file);
    }

    public function actionLihat($led)
    {
        $ledInstitusi = K9LedInstitusi::findOne($led);

        $json_eksternal = K9InstitusiJsonHelper::getJsonLedKondisiEksternal();
        $json_profil = K9InstitusiJsonHelper::getJsonLedProfil();
        $json_kriteria = K9InstitusiJsonHelper::getAllJsonLed();
        $json_analisis = K9InstitusiJsonHelper::getJsonLedAnalisis();

        $modelEksternal = K9LedInstitusiNarasiKondisiEksternalForm::findOne(['id_led_institusi' => $ledInstitusi->id]);
        $modelProfil = K9LedInstitusiNarasiProfilInstitusi::findOne(['id_led_institusi' => $ledInstitusi->id]);
        $kriteria = $this->getArrayKriteria($led);
        $modelAnalisis = K9LedInstitusiNarasiAnalisisForm::findOne(['id_led_institusi' => $ledInstitusi->id]);

        $modelDokumen = new K9DokumenLedInstitusiUploadForm();
        $dataDokumen = K9InstitusiEksporDokumen::findAll(['id_led_institusi' => $led]);
        $realPath = K9InstitusiDirectoryHelper::getDokumenLedUrl($ledInstitusi->akreditasiInstitusi);


        return $this->render($this->lihatLedView, [
            'led' => $ledInstitusi,
            'modelDokumen' => $modelDokumen,
            'dataDokumen' => $dataDokumen,
            'json' => $json_kriteria,
            'json_eksternal' => $json_eksternal,
            'json_profil' => $json_profil,
            'json_analisis' => $json_analisis,
            'kriteria' => $kriteria,
            'path' => $realPath,
            'modelEksternal' => $modelEksternal,
            'modelAnalisis' => $modelAnalisis,
            'modelProfil' => $modelProfil,
            'untuk' => 'lihat'
        ]);
    }

    public function actionLihatKriteria($led, $kriteria)
    {

        $ledInstitusi = K9LedInstitusi::findOne(['id' => $led]);
        $attr = 'k9LedInstitusiKriteria' . $kriteria . 's';
        $modelLed = $ledInstitusi->$attr;

        $json = K9InstitusiJsonHelper::getJsonKriteriaLed($kriteria);
        $poinKriteria = $json->butir;
        return $this->render($this->lihatKriteriaView, [
            'model' => $modelLed,
            'poinKriteria' => $poinKriteria,
            'untuk' => 'lihat',
            'kriteria' => $kriteria,
            'ledInstitusi' => $ledInstitusi
        ]);
    }

    public function actionLihatNonKriteria($led, $poin)
    {
        $ledInstitusi = K9LedInstitusi::findOne($led);

        switch ($poin) {
            case 'A':
                $modelNarasi = $ledInstitusi->narasiEksternal;
                $json = K9InstitusiJsonHelper::getJsonLedKondisiEksternal();
                break;
            case 'B':
                $modelNarasi = $ledInstitusi->narasiProfil;
                $json = K9InstitusiJsonHelper::getJsonLedProfil();
                break;
            case 'D':
                $modelNarasi = $ledInstitusi->narasiAnalisis;
                $json = K9InstitusiJsonHelper::getJsonLedAnalisis();
                break;
        }

        $poin = $json->butir;

        $detail = $modelNarasi->documents;


        $untuk = 'lihat';

        return $this->render($this->lihatNonKriteriaView,
            compact('ledInstitusi', 'json', 'poin', 'modelNarasi', 'detail', 'untuk'));
    }

    protected function getKriteriaNomor($kriteria, $search)
    {
        $data = K9InstitusiJsonHelper::getJsonKriteriaLed($kriteria);
        $collection = new Collection($data->butir);
        return $collection->where('nomor', $search)->first();
    }
}
