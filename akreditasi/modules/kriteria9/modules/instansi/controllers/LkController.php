<?php


namespace akreditasi\modules\kriteria9\modules\institusi\controllers;

use akreditasi\models\kriteria9\forms\lk\institusi\K9LinkLkInstitusiKriteriaDetailForm;
use akreditasi\models\kriteria9\forms\lk\institusi\K9LkInstitusiKriteriaDetailForm;
use akreditasi\models\kriteria9\forms\lk\institusi\K9TempLkInstitusiKriteriaDetailForm;
use akreditasi\models\kriteria9\forms\lk\institusi\K9TextLkInstitusiKriteriaDetailForm;
use common\helpers\kriteria9\K9InstitusiDirectoryHelper;
use common\models\kriteria9\akreditasi\K9Akreditasi;
use common\models\kriteria9\forms\lk\K9PencarianLkInstitusiForm;
use common\models\kriteria9\lk\institusi\K9LkInstitusi;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria1;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria1Detail;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria2;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria2Detail;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria3;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria3Detail;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria4;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria4Detail;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria5;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria5Detail;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria6;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria6Detail;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria7;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria7Detail;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria8;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria8Detail;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria9;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria9Detail;
use common\models\kriteria9\lk\K9LkTemplate;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\UploadedFile;

class LkController extends Controller
{
    public function beforeAction($action)
    {
        $this->layout="main";
        return true;
    }

    public function actionArsip($target){
        $model = new K9PencarianLkInstitusiForm();

        $idAkreditasiInstitusi = K9Akreditasi::findAll(['jenis_akreditasi'=>'institusi']);
        $dataAkreditasiInstitusi = ArrayHelper::map($idAkreditasiInstitusi,'id',function($data){
            return $data->lembaga.' - '.$data->nama.' ('.$data->tahun.')';
        });

        if ($model->load(Yii::$app->request->post())){
            if (Yii::$app->request->isAjax){
                $url = $model->cari($target);
                $lk = $model->getLk();
                $newUrl = [];
                if(!$lk){
                    $newUrl = false;
                }else{
                    $newUrl = $url;
                }
                return $this->renderAjax('_hasil-arsip',['lk'=>$lk,'url'=>$newUrl]);
            }
        }

        return $this->render('arsip',[
            'model' => $model,
            'dataAkreditasiInstitusi' => $dataAkreditasiInstitusi
        ]);
    }

    public function actionIsi($lk){
        $file_json = 'lkpt_institusi.json';
        $lkInstitusi = K9LkInstitusi::findOne($lk);

        $json = file_get_contents(Yii::getAlias('@common/required/kriteria9/apt/'.$file_json));
        $kriteria1 = K9LkInstitusiKriteria1::find()->where(['id_lk_institusi'=>$lk])->one();
        $kriteria2 = K9LkInstitusiKriteria2::find()->where(['id_lk_institusi'=>$lk])->one();
        $kriteria3 = K9LkInstitusiKriteria3::find()->where(['id_lk_institusi'=>$lk])->one();
        $kriteria4 = K9LkInstitusiKriteria4::find()->where(['id_lk_institusi'=>$lk])->one();
        $kriteria5 = K9LkInstitusiKriteria5::find()->where(['id_lk_institusi'=>$lk])->one();
        $kriteria6 = K9LkInstitusiKriteria6::find()->where(['id_lk_institusi'=>$lk])->one();
        $kriteria7 = K9LkInstitusiKriteria7::find()->where(['id_lk_institusi'=>$lk])->one();
        $kriteria8 = K9LkInstitusiKriteria8::find()->where(['id_lk_institusi'=>$lk])->one();
        $kriteria9 = K9LkInstitusiKriteria9::find()->where(['id_lk_institusi'=>$lk])->one();

        $decode = Json::decode($json);

        $cekisi1 = K9LkInstitusiKriteria1Detail::find()->where(['id_lk_institusi_kriteria1'=>$lk])->select('kode_dokumen')->distinct()->count();
        $cekisi2 = K9LkInstitusiKriteria2Detail::find()->where(['id_lk_institusi_kriteria2'=>$lk])->select('kode_dokumen')->distinct()->count();
        $cekisi3 = K9LkInstitusiKriteria3Detail::find()->where(['id_lk_institusi_kriteria3'=>$lk])->select('kode_dokumen')->distinct()->count();
        $cekisi4 = K9LkInstitusiKriteria4Detail::find()->where(['id_lk_institusi_kriteria4'=>$lk])->select('kode_dokumen')->distinct()->count();
        $cekisi5 = K9LkInstitusiKriteria5Detail::find()->where(['id_lk_institusi_kriteria5'=>$lk])->select('kode_dokumen')->distinct()->count();
        $cekisi6 = K9LkInstitusiKriteria6Detail::find()->where(['id_lk_institusi_kriteria6'=>$lk])->select('kode_dokumen')->distinct()->count();
        $cekisi7 = K9LkInstitusiKriteria7Detail::find()->where(['id_lk_institusi_kriteria7'=>$lk])->select('kode_dokumen')->distinct()->count();
        $cekisi8 = K9LkInstitusiKriteria8Detail::find()->where(['id_lk_institusi_kriteria8'=>$lk])->select('kode_dokumen')->distinct()->count();
        $cekisi9 = K9LkInstitusiKriteria9Detail::find()->where(['id_lk_institusi_kriteria9'=>$lk])->select('kode_dokumen')->distinct()->count();

        if ($cekisi3 > 44){
            $cekisi3 = 44;
        }
        if ($cekisi4 > 47){
            $cekisi4 = 47;
        }

        $data1 = $decode[0];
        $butir1 = $data1['butir'];
        $data2 = $decode[1];
        $butir2 = $data2['butir'];
        $data3 = $decode[2];
        $butir3 = $data3['butir'];
        $data4 = $decode[3];
        $butir4 = $data4['butir'];
        $data5 = $decode[4];
        $butir5 = $data5['butir'];
//        $data6 = $decode[5];
//        $butir6 = $data6['butir'];
//        $data7 = $decode[6];
//        $butir7 = $data7['butir'];
//        $data8 = $decode[7];
//        $butir8 = $data8['butir'];
//        $data9 = $decode[8];
//        $butir9 = $data9['butir'];

        $kriteria1json = 0;
        $kriteria2json = 0;
        $kriteria3json = 0;
        $kriteria4json = 0;
        $kriteria5json = 0;
//        $kriteria6json = 0;
//        $kriteria7json = 0;
//        $kriteria8json = 0;
//        $kriteria9json = 0;

//        foreach ($butir1 as $key => $value) {
//            if (!empty($value['template'])){
//                $kriteria1json++;
//            }
//            foreach ($value['dokumen_sumber'] as $key => $sumber) {
//                if (!empty($sumber['kode'])){
//                    $kriteria1json++;
//                }
//            }
//            foreach ($value['dokumen_pendukung'] as $key => $pendukung) {
//                if (!empty($pendukung['kode'])){
//
//                    $kriteria1json++;}
//            }
//        }
//        foreach ($butir2 as $key => $value) {
//            if (!empty($value['template'])){
//                $kriteria2json++;
//            }
//            foreach ($value['dokumen_sumber'] as $key => $sumber) {
//                if (!empty($sumber['kode'])){
//                    $kriteria2json++;
//                }
//            }
//            foreach ($value['dokumen_pendukung'] as $key => $pendukung) {
//                if (!empty($pendukung['kode'])){
//
//                    $kriteria2json++;}
//            }
//        }
//        foreach ($butir3 as $key => $value) {
//            if (!empty($value['template'])){
//                $kriteria3json++;
//            }
//            foreach ($value['dokumen_sumber'] as $key => $sumber) {
//                if (!empty($sumber['kode'])){
//                    $kriteria3json++;
//                }
//            }
//            foreach ($value['dokumen_pendukung'] as $key => $pendukung) {
//                if (!empty($pendukung['kode'])){
//
//                    $kriteria3json++;}
//            }
//        }
//        foreach ($butir4 as $key => $value) {
//            if (!empty($value['template'])){
//                $kriteria4json++;
//            }
//            foreach ($value['dokumen_sumber'] as $key => $sumber) {
//                if (!empty($sumber['kode'])){
//                    $kriteria4json++;
//                }
//            }
//            foreach ($value['dokumen_pendukung'] as $key => $pendukung) {
//                if (!empty($pendukung['kode'])){
//
//                    $kriteria4json++;}
//            }
//        }
//        foreach ($butir5 as $key => $value) {
//            if (!empty($value['template'])){
//                $kriteria5json++;
//            }
//            foreach ($value['dokumen_sumber'] as $key => $sumber) {
//                if (!empty($sumber['kode'])){
//                    $kriteria5json++;
//                }
//            }
//            foreach ($value['dokumen_pendukung'] as $key => $pendukung) {
//                if (!empty($pendukung['kode'])){
//                    $kriteria5json++;}
//            }
//        }
//        foreach ($butir6 as $key => $value) {
//            foreach ($value['dokumen_sumber'] as $key => $sumber) {
//                $kriteria6json++;
//            }
//            foreach ($value['dokumen_pendukung'] as $key => $pendukung) {
//                if (isset($pendukung['kode'])){
//
//                    $kriteria6json++;}
//            }
//        }
//        foreach ($butir7 as $key => $value) {
//            foreach ($value['dokumen_sumber'] as $key => $sumber) {
//
//                $kriteria7json++;
//            }
//            foreach ($value['dokumen_pendukung'] as $key => $pendukung) {
//                if (isset($pendukung['kode'])){
//
//                    $kriteria7json++;
//                }
//            }
//        }
//        foreach ($butir8 as $key => $value) {
//            foreach ($value['dokumen_sumber'] as $key => $sumber) {
//
//                $kriteria8json++;
//            }
//            foreach ($value['dokumen_pendukung'] as $key => $pendukung) {
//                if (isset($pendukung['kode'])){
//
//                    $kriteria8json++;
//                }
//            }
//        }
//        foreach ($butir9 as $key => $value) {
//            foreach ($value['dokumen_sumber'] as $key => $sumber) {
//
//                $kriteria9json++;
//            }
//            foreach ($value['dokumen_pendukung'] as $key => $pendukung) {
//                if (isset($pendukung['kode'])){
//
//                    $kriteria9json++;
//                }
//            }
//        }

//        $progress1 = round(($cekisi1/$kriteria1json)*100,2);
//        $progress2 = round(($cekisi2/$kriteria2json)*100,2);
//        $progress3 = round(($cekisi3/$kriteria3json)*100,2);
//        $progress4 = round(($cekisi4/$kriteria4json)*100,2);
//        $progress5 = round(($cekisi5/$kriteria5json)*100,2);
//        $progress6 = round(($cekisi6/$kriteria6json)*100,2);
//        $progress7 = round(($cekisi7/$kriteria7json)*100,2);
//        $progress8 = round(($cekisi8/$kriteria8json)*100,2);
//        $progress9 = round(($cekisi9/$kriteria9json)*100,2);

//        $progressDok = round(($progress1+$progress2+$progress3+$progress4+$progress5)/5,2);

        // simpan progress Dok
//        $lkInstitusi->progress = $progressDok;
//        $lkInstitusi->save(false);

        $ini = parse_ini_file(__DIR__.'/../../../../../../system-configuration.ini');
        $institusi = $ini['instansi'];

        return $this->render('isi',[
            'lkInstitusi'=>$lkInstitusi,
//            'progressDok'=>$progressDok,
            'kriteria1'=>$kriteria1,
//            'progress1'=>$progress1,
            'kriteria2'=>$kriteria2,
//            'progress2'=>$progress2,
            'kriteria3'=>$kriteria3,
//            'progress3'=>$progress3,
            'kriteria4'=>$kriteria4,
//            'progress4'=>$progress4,
            'kriteria5'=>$kriteria5,
//            'progress5'=>$progress5,
//            'kriteria6'=>$kriteria6,
//            'progress6'=>$progress6,
//            'kriteria7'=>$kriteria7,
//            'progress7'=>$progress7,
            'json'=>$json,
            'cari'=>'isi',
            'institusi' => $institusi
        ]);
    }

    public function actionIsiKriteria($lk, $kriteria){
        $file_json = 'lkpt_institusi.json';
        $json = file_get_contents(Yii::getAlias('@common/required/kriteria9/apt/'.$file_json));

        $lkInstitusi = K9LkInstitusi::findOne($lk);
        $sourceModel = 'common\\models\\kriteria9\\lk\\institusi\\K9LkInstitusiKriteria'.$kriteria.'Detail';
        $sourceKriteria = 'common\\models\\kriteria9\\lk\\institusi\\K9LkInstitusiKriteria'.$kriteria;

        $model = call_user_func($sourceModel.'::find')->where(['id_lk_institusi_kriteria'.$kriteria=>$lk])->all();
        $modelTemp = call_user_func($sourceModel.'::find')->where(['id_lk_institusi_kriteria'.$kriteria=>$lk, 'jenis_dokumen'=>'template'])->all();

        $sourceCek = 'common\\models\\kriteria9\\lk\\institusi\\K9LkInstitusiKriteria'.$kriteria.'Detail';
//        $cekisi = call_user_func($sourceCek.'::find')->where(['id_lk_institusi_kriteria'.$kriteria=>$lk])->select('kode_dokumen')->distinct()->count();
        $cekisiTemplate = call_user_func($sourceCek.'::find')->where(['id_lk_institusi_kriteria'.$kriteria=>$lk, 'jenis_dokumen'=>'template'])->select('kode_dokumen')->distinct()->count();
        $cekisiSumber = call_user_func($sourceCek.'::find')->where(['id_lk_institusi_kriteria'.$kriteria=>$lk, 'jenis_dokumen'=>'sumber'])->select('kode_dokumen')->distinct()->count();
        $cekisiPendukung = call_user_func($sourceCek.'::find')->where(['id_lk_institusi_kriteria'.$kriteria=>$lk, 'jenis_dokumen'=>'pendukung'])->select('kode_dokumen')->distinct()->count();
        $modelKriteria = call_user_func($sourceKriteria.'::find')->where(['id_lk_institusi'=>$lk])->one();

        $template = K9LkTemplate::find();

        $decode = Json::decode($json);
        $data = $decode[$kriteria-1];
        $butir = $data['butir'];

        $jumlahdok = 0;
        $jumlahisidok = 0;
        //jumlah
        $nomor = [];
        $dokumen = [];

//        var_dump($butir[0]['template']);
//        exit();

        foreach ($butir as $key => $value) {
            if (!empty($value['template'])){
                $jumlahdok++;
            }
            foreach ($value['dokumen_sumber'] as $key1 => $sumber) {
                if (!empty($sumber['kode'])){
                    $carikode = call_user_func($sourceCek.'::find')->where(['kode_dokumen'=>$sumber['kode'], 'id_lk_institusi_kriteria'.$kriteria=>$lk ])->all();
                    if($carikode){
                        $jumlahisidok++;
                    }
                    $jumlahdok++;
                }
            }
            foreach ($value['dokumen_pendukung'] as $key2 => $pendukung) {
                if (!empty($pendukung['kode'])) {
                    $carikode = call_user_func($sourceCek . '::find')->where(['kode_dokumen' => $pendukung['kode'], 'id_lk_institusi_kriteria'.$kriteria=>$lk ])->all();
                    if ($carikode) {
                        $jumlahisidok++;
                    }
                    $jumlahdok++;
                }
            }
            $nomor[$key] = $jumlahdok;
            $dokumen[$key] = $jumlahisidok; /*jumlah dokumen yg diisi*/
            $jumlahdok = 0;
            $jumlahisidok = 0;
        }

        //cari dokumen yg belum diupload
//        var_dump($cekisi);
//        exit();
        $isi = $cekisiTemplate + $cekisiSumber + $cekisiPendukung;


//        fix dokumentasi standar 3 sementara
        if ($kriteria == 3){
            if ($isi > 44){
                $isi = 44;
            }
        }
        if ($kriteria == 4){
            if ($isi > 47){
                $isi = 47;
            }
        }

        $progress = round(($isi/array_sum($nomor))*100,2);

        $dokModel = new K9LkInstitusiKriteriaDetailForm();
        $dokTextModel = new K9TextLkInstitusiKriteriaDetailForm();
        $dokLinkModel = new K9LinkLkInstitusiKriteriaDetailForm();
        $dokTempModel = new K9TempLkInstitusiKriteriaDetailForm();

        if($dokModel->load(Yii::$app->request->post())){

            $dokModel->isiDokumen = UploadedFile::getInstance($dokModel,'isiDokumen');

            if($dokModel->uploadDokumen($lk, $kriteria)){

//              Alert jika nama sama belum selesai

                Yii::$app->session->setFlash('success','Berhasil Upload');
                return $this->redirect(Url::current());
            }
            else{
                Yii::$app->session->setFlash('error','Gagal Upload. Cek File');
                return $this->redirect(Url::current());
            }
//            return $this->redirect(Url::current());
        }

        if ($dokTempModel->load(Yii::$app->request->post())){
            $dokTempModel->isiDokumen = UploadedFile::getInstance($dokTempModel, 'isiDokumen');
            if($dokTempModel->uploadTemplate($lk, $kriteria)){
                Yii::$app->session->setFlash('success','Berhasil Upload Template');
                return $this->redirect(Url::current());
            }
            else{
                Yii::$app->session->setFlash('error','Gagal Upload. Cek File');
                return $this->redirect(Url::current());
            }
        }

        if ($dokTextModel->load(Yii::$app->request->post())){
            if ($dokTextModel->uploadText($lk, $kriteria)){
                Yii::$app->session->setFlash('success','Berhasil Tambah Teks');
                return $this->redirect(Url::current());
            }
            else{
                Yii::$app->session->setFlash('error','Gagal Tambah Teks');
                return $this->redirect(Url::current());
            }
        }

        if ($dokLinkModel->load(Yii::$app->request->post())){
            if ($dokLinkModel->uploadLink($lk, $kriteria)){
                Yii::$app->session->setFlash('success','Berhasil Tambah Tautan');
                return $this->redirect(Url::current());
            }
            else{
                Yii::$app->session->setFlash('error','Gagal Tambah Tautan');
                return $this->redirect(Url::current());
            }
        }


        return $this->render('isi-kriteria',[
            'model'=>$model,
            'modelKriteria'=>$modelKriteria,
            'modelTemp'=>$modelTemp,
            'lkInstitusi'=>$lkInstitusi,
            'json'=>$data,
            'butir'=>$butir,
            'dokModel'=>$dokModel,
            'progress'=>$progress,
            'cari'=>'isi',
            'nomor'=> $nomor,
            'dokumen'=>$dokumen,
            'dokTextModel' => $dokTextModel,
            'dokLinkModel' => $dokLinkModel,
            'dokTempModel' => $dokTempModel,
            'template' => $template
        ]);
    }

    public function actionDownloadTemplate($id){
        ini_set('max_execution_time', 5*60);
        $template = K9LkTemplate::findOne($id);
        $path = K9InstitusiDirectoryHelper::getTemplateLkPath();
        $file = $template->nama_file;

        return Yii::$app->response->sendFile("$path/$file");
    }

    public function actionDownloadDok($id){
        ini_set('max_execution_time', 5*60);
        $template = K9LkInstitusiKriteria1Detail::findOne($id);
        $path = K9InstitusiDirectoryHelper::getDokumenLkPath($template->lkInstitusiKriteria1->lkInstitusi->akreditasiInstitusi);
        $file = $template->isi_dokumen;

        return Yii::$app->response->sendFile("$path/$file");
    }

    public function actionHapusDok(){
        if(Yii::$app->request->isPost){
            $id = Yii::$app->request->post('id');
            $kriteria = Yii::$app->request->post('kriteria');
            $lk = Yii::$app->request->post('lk');

            $namespace = 'common\\models\\kriteria9\\lk\\institusi\\K9';
            $class = $namespace.'LkInstitusiKriteria'.$kriteria.'Detail';
            $model = call_user_func($class.'::findOne',$id);

            $path = K9InstitusiDirectoryHelper::getDokumenLkPath($model->lkInstitusiKriteria1->lkInstitusi->akreditasiInstitusi);
            $file = $model->isi_dokumen;

            if ($model->bentuk_dokumen == 'text'){
                $model->delete();
                Yii::$app->session->setFlash('success',"Teks Tabel $model->kode_dokumen berhasil dihapus");
                return $this->redirect(['lk/isi-kriteria','kriteria'=>$kriteria,'lk'=>$lk]);
            }
            if ($model->bentuk_dokumen == 'link'){
                $model->delete();
                Yii::$app->session->setFlash('success',"Tautan Tabel $model->kode_dokumen berhasil dihapus");
                return $this->redirect(['lk/isi-kriteria','kriteria'=>$kriteria,'lk'=>$lk]);
            }

            if ($model->jenis_dokumen == 'lainnya'){
                unlink("$path/lainnya/$file");
                $model->delete();

                Yii::$app->session->setFlash('success',"Dokumen $model->kode_dokumen berhasil dihapus");
                return $this->redirect(['lk/isi-kriteria','kriteria'=>$kriteria,'lk'=>$lk]);
            }
            if ($model->jenis_dokumen == 'sumber'){
                unlink("$path/sumber/$file");
                $model->delete();

                Yii::$app->session->setFlash('success',"Dokumen $model->kode_dokumen berhasil dihapus");
                return $this->redirect(['lk/isi-kriteria','kriteria'=>$kriteria,'lk'=>$lk]);
            }
            if ($model->jenis_dokumen == 'pendukung'){
                unlink("$path/pendukung/$file");
                $model->delete();

                Yii::$app->session->setFlash('success',"Dokumen $model->kode_dokumen berhasil dihapus");
                return $this->redirect(['lk/isi-kriteria','kriteria'=>$kriteria,'lk'=>$lk]);
            }

            unlink("$path/$file");
            $model->delete();

            Yii::$app->session->setFlash('success',"Dokumen $model->kode_dokumen berhasil dihapus");
            return $this->redirect(['lk/isi-kriteria','kriteria'=>$kriteria,'lk'=>$lk]);
        }
        throw new BadRequestHttpException('Request Harus Post');
    }

    public function actionLihatDok($kriteria, $dok, $lk){

    }

    public function actionHapusKriteria(){

    }

    public function actoinPj($kriteria){

    }

    public function actionPjKriteria($kriteria, $lk){

    }

    public function actionLihat($lk){

    }

    public function actionLihatKriteria($kriteria, $lk){

    }
}