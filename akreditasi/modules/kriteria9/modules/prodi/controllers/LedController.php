<?php
/**
 * Project: mutu-v2.
 * @author Adryan Eka Vandra <adryanekavandra@gmail.com>
 *
 * Date: 9/7/2019
 * Time: 12:36 AM
 */

namespace akreditasi\modules\kriteria9\modules\prodi\controllers;


use akreditasi\models\kriteria9\forms\led\K9DetailLedProdiLinkForm;
use akreditasi\models\kriteria9\forms\led\K9DetailLedProdiTeksForm;
use akreditasi\models\kriteria9\forms\led\K9DetailLedProdiUploadForm;
use akreditasi\models\kriteria9\forms\led\K9DokumenLedProdiUploadForm;
use common\helpers\kriteria9\K9ProdiDirectoryHelper;
use common\models\Constants;
use common\models\kriteria9\akreditasi\K9Akreditasi;
use common\models\kriteria9\forms\led\K9PencarianLedProdiForm;
use common\models\kriteria9\led\prodi\K9DokumenLedProdi;
use common\models\kriteria9\led\prodi\K9LedProdi;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria1;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria2;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria3;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria4;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria5;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria6;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria7;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria8;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria9;
use common\models\ProgramStudi;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\UploadedFile;

class LedController extends Controller
{
    public $layout = 'main';

    protected function getJsonData(){
        $fileJson = 'led_prodi.json';
        $json = Json::decode(file_get_contents(Yii::getAlias('@common/required/kriteria9/aps/'.$fileJson)));
        return $json;

    }

    protected function getArrayKriteria($led){
        $kriteria1 = K9LedProdiKriteria1::findOne(['id_led_prodi'=>$led]);
        $kriteria2 = K9LedProdiKriteria2::findOne(['id_led_prodi'=>$led]);
        $kriteria3 = K9LedProdiKriteria3::findOne(['id_led_prodi'=>$led]);
        $kriteria4 = K9LedProdiKriteria4::findOne(['id_led_prodi'=>$led]);
        $kriteria5 = K9LedProdiKriteria5::findOne(['id_led_prodi'=>$led]);
        $kriteria6 = K9LedProdiKriteria6::findOne(['id_led_prodi'=>$led]);
        $kriteria7 = K9LedProdiKriteria7::findOne(['id_led_prodi'=>$led]);
        $kriteria8 = K9LedProdiKriteria8::findOne(['id_led_prodi'=>$led]);
        $kriteria9 = K9LedProdiKriteria9::findOne(['id_led_prodi'=>$led]);

        $kriteria = [$kriteria1,$kriteria2,$kriteria3,$kriteria4,$kriteria5,$kriteria6,$kriteria7,$kriteria8,$kriteria9];

        return $kriteria;
    }

    public function actionArsip($target,$prodi){

        $model = new K9PencarianLedProdiForm();
        $akreditasi = K9Akreditasi::findAll(['jenis_akreditasi'=>Constants::PRODI]);
        $progdi = ProgramStudi::findAll(['id'=>$prodi]);
        $dataProdi = ArrayHelper::map($progdi,'id','nama');
        $dataAkreditasi = ArrayHelper::map($akreditasi,'id',function ($data){
            return $data->nama." (".$data->tahun.")";
        });

        if($model->load(Yii::$app->request->post())){
            if(Yii::$app->request->isAjax){
                $url = $model->cari($target);
                $led = $model->getLed();
                $newUrl = [];
                if(!$led) $newUrl =  false;
                else $newUrl = $url;

                return $this->renderAjax('_hasil-arsip',['led'=>$led,'url'=>$newUrl]);

            }
        }
        return $this->render('arsip',[
            'model'=>$model,
            'dataAkreditasi'=>$dataAkreditasi,
            'dataProdi'=>$dataProdi
        ]);

    }

    public function actionIsi($led,$prodi){
        $ledProdi = K9LedProdi::findOne($led);

        $modelDokumen = new K9DokumenLedProdiUploadForm();
        $dataDokumen = K9DokumenLedProdi::findAll(['id_led_prodi'=>$led]);
        $json = $this->getJsonData();
        $kriteria = $this->getArrayKriteria($led);
        $realPath = K9ProdiDirectoryHelper::getDokumenLedUrl($ledProdi->akreditasiProdi);

        if($modelDokumen->load(Yii::$app->request->post())){

            $dokumen = $this->uploadDokumenLed($led);
            if($dokumen){
                $model = new K9DokumenLedProdi();
                $model->id_led_prodi = $ledProdi->id;
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
            'led' => $ledProdi,
            'modelDokumen' => $modelDokumen,
            'dataDokumen' => $dataDokumen,
            'json' => $json,
            'kriteria' => $kriteria,
            'path' => $realPath
        ]);
    }

    public function actionHapusDokumenLed(){
        if (Yii::$app->request->isPost) {

            $data = Yii::$app->request->post();

            $idDokumenLed = $data['id'];
            $prodi = $data['prodi'];
            $dokumenLedProdi = K9DokumenLedProdi::findOne($idDokumenLed);
            $path = K9ProdiDirectoryHelper::getDokumenLedPath($dokumenLedProdi->ledProdi->akreditasiProdi);
            $deleteDokumen = FileHelper::unlink($path . "/" . $dokumenLedProdi->nama_dokumen);
            if ($deleteDokumen) {
                $dokumenLedProdi->delete();
                Yii::$app->session->setFlash('success', 'Berhasil menghapus dokumen led');
                return $this->redirect(['led/isi', 'led' => $dokumenLedProdi->ledProdi->id,'prodi'=>$prodi]);

            }
            Yii::$app->session->setFlash('success', 'Gagal menghapus dokumen led');
            return $this->redirect(['led/isi', 'led' => $dokumenLedProdi->ledProdi->id,'prodi'=>$prodi]);

        }

        return new MethodNotAllowedHttpException('Harus melalui prosedur penghapusan data.');

    }

    public function actionDownloadDokumen($dokumen)
    {
        ini_set('max_execution_time', 5 * 60);
        $model = K9DokumenLedProdi::findOne($dokumen);
        $file = K9ProdiDirectoryHelper::getDokumenLedPath($model->ledProdi->akreditasiProdi) . "/{$model->nama_dokumen}";
        return Yii::$app->response->sendFile($file);
    }

    public function actionIsiKriteria($led,$kriteria,$prodi){

        $modelLedClass = 'common\\models\\kriteria9\\led\\prodi\\K9LedProdiKriteria'.$kriteria;
        $modelLed = call_user_func($modelLedClass.'::findOne',$led);

        $modelNarasiClass = 'akreditasi\\models\\kriteria9\\led\\prodi\\K9LedProdiNarasiKriteria' . $kriteria . 'Form';
        $modelNarasi = call_user_func($modelNarasiClass . '::findOne', ['id_led_prodi_kriteria'.$kriteria => $modelLed->id]);
        $relasiNarasiAttr = 'ledProdiKriteria'.$kriteria;


        $json = $this->getJsonData();
        $dataKriteria = $json[$kriteria - 1];
        $poinKriteria = $dataKriteria['butir'];


        $detailModel = new K9DetailLedProdiUploadForm();
        $textModel = new K9DetailLedProdiTeksForm();
        $linkModel = new K9DetailLedProdiLinkForm();


        $realPath = K9ProdiDirectoryHelper::getDetailLedUrl($modelLed->ledProdi->akreditasiProdi);


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
        if($textModel->load(Yii::$app->request->post())){
            if($textModel->save($led,$kriteria)){
                Yii::$app->session->setFlash('success','Berhasil Menambahkan dokumen');
                return $this->redirect(Url::current());
            }
            Yii::$app->session->setFlash('warning','Gagal Menambahkan Dokumen');
            return $this->redirect(Url::current());

        }

        if($linkModel->load(Yii::$app->request->post())){
            if($linkModel->save($led,$kriteria)){
                Yii::$app->session->setFlash('success','Berhasil Menambahkan dokumen');
                return $this->redirect(Url::current());
            }
            Yii::$app->session->setFlash('warning','Gagal Menambahkan Dokumen');
            return $this->redirect(Url::current());

        }



        return $this->render('isi-kriteria', [
            'model'=>$modelLed,
            'modelNarasi' => $modelNarasi,
            'poinKriteria' => $poinKriteria,
            'detailModel' => $detailModel,
            'path' => $realPath,
            'textModel'=>$textModel,
            'linkModel'=>$linkModel,

        ]);
    }

    public function actionLihat($led,$prodi){
        $ledProdi = K9LedProdi::findOne($led);

        $dataDokumen = K9DokumenLedProdi::findAll(['id_led_prodi'=>$led]);
        $json = $this->getJsonData();
        $kriteria = $this->getArrayKriteria($led);
        $realPath = K9ProdiDirectoryHelper::getDokumenLedUrl($ledProdi->akreditasiProdi);


        return $this->render('lihat-led', [
            'led' => $ledProdi,
            'dataDokumen' => $dataDokumen,
            'json' => $json,
            'kriteria' => $kriteria,
            'path' => $realPath
        ]);
    }

    public function actionLihatKriteria($led,$kriteria,$prodi){

        $modelLedClass = 'common\\models\\kriteria9\\led\\prodi\\K9LedProdiKriteria'.$kriteria;
        $modelLed = call_user_func($modelLedClass.'::findOne',$led);

        $modelNarasiClass = 'akreditasi\\models\\kriteria9\\led\\prodi\\K9LedProdiNarasiKriteria' . $kriteria . 'Form';
        $modelNarasi = call_user_func($modelNarasiClass . '::findOne', ['id_led_prodi_kriteria'.$kriteria => $modelLed->id]);
        $relasiNarasiAttr = 'ledProdiKriteria'.$kriteria;


        $json = $this->getJsonData();
        $dataKriteria = $json[$kriteria - 1];
        $poinKriteria = $dataKriteria['butir'];

        $realPath = K9ProdiDirectoryHelper::getDetailLedUrl($modelLed->ledProdi->akreditasiProdi);




        return $this->render('lihat-kriteria', [
            'model'=>$modelLed,
            'modelNarasi' => $modelNarasi,
            'poinKriteria' => $poinKriteria,
            'path' => $realPath,
        ]);
    }

    public function actionHapusDetail(){
        if (Yii::$app->request->isPost) {

            $data = Yii::$app->request->post();
            $idDokumen = $data['dokumen'];
            $kriteria = $data['kriteria'];
            $idLed = $data['led'];
            $jenis = $data['jenis'];
            $prodi = $data['prodi'];

            $namespace = 'common\\models\\kriteria9\\led\\prodi';
            $classPath = "$namespace\\K9LedProdiKriteria$kriteria"."Detail";
            $model = call_user_func("$classPath::findOne", $idDokumen);
            $led = K9LedProdi::findOne($idLed);
            if(!$model->bentuk_dokumen === Constants::TEXT && !$model->bentuk_dokumen === Constants::LINK){
                $dokumenPath = K9ProdiDirectoryHelper::getDokumenLedPath($led->akreditasiProdi);
                FileHelper::unlink("$dokumenPath/$jenis/$model->isi_dokumen");
            }
            $model->delete();

            Yii::$app->session->setFlash('success', 'Berhasil menghapus dokumen');
            return $this->redirect(['led/isi-kriteria', 'led' => $idLed, 'kriteria' => $kriteria,'prodi'=>$prodi]);
        }

        return new MethodNotAllowedHttpException('Penghapusan harus sesuai prosedur.');
    }

    public function actionDownloadDetail($kriteria, $dokumen, $led,$jenis){
        ini_set('max_execution_time', 5 * 60);
        $led = K9LedProdi::findOne($led);
        $namespace = 'common\\models\\kriteria9\\led\\prodi';
        $className = "$namespace\\K9LedProdiKriteria$kriteria"."Detail";
        $model = call_user_func($className . '::findOne', $dokumen);
        $file = K9ProdiDirectoryHelper::getDokumenLedPath($led->akreditasiProdi) . "/$jenis/{$model->isi_dokumen}";
        return Yii::$app->response->sendFile($file);
    }
    protected function uploadDokumenLed($led)
    {
        $ledProdi = K9LedProdi::findOne($led);

        $dokumenLed = new K9DokumenLedProdiUploadForm();
        $dokumenLed->dokumenLed = UploadedFile::getInstance($dokumenLed, 'dokumenLed');
        $realPath = K9ProdiDirectoryHelper::getDokumenLedPath($ledProdi->akreditasiProdi);
        $response = null;

        if ($dokumenLed->validate()) {

            $uploaded = $dokumenLed->uploadDokumen($realPath);
            if ($uploaded) {
                $response = $dokumenLed;
            }

        }

        return $response;


    }
}