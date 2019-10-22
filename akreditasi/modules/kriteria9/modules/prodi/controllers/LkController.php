<?php


namespace akreditasi\modules\kriteria9\modules\prodi\controllers;


use akreditasi\models\kriteria9\forms\lk\prodi\K9LinkLkProdiKriteriaDetailForm;
use akreditasi\models\kriteria9\forms\lk\prodi\K9LkProdiKriteriaDetailForm;
use akreditasi\models\kriteria9\forms\lk\prodi\K9TempLkProdiKriteriaDetailForm;
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
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria9;
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
        $lkInstitusi = K9LkProdi::findOne($lk);

        $json = file_get_contents(Yii::getAlias('@common/required/kriteria9/aps/' . $file_json));
        $kriteria1 = K9LkProdiKriteria1::find()->where(['id_lk_prodi' => $lk])->one();
        $kriteria2 = K9LkProdiKriteria2::find()->where(['id_lk_prodi' => $lk])->one();
        $kriteria3 = K9LkProdiKriteria3::find()->where(['id_lk_prodi' => $lk])->one();
        $kriteria4 = K9LkProdiKriteria4::find()->where(['id_lk_prodi' => $lk])->one();
        $kriteria5 = K9LkProdiKriteria5::find()->where(['id_lk_prodi' => $lk])->one();
        $kriteria6 = K9LkProdiKriteria6::find()->where(['id_lk_prodi' => $lk])->one();
        $kriteria7 = K9LkProdiKriteria7::find()->where(['id_lk_prodi' => $lk])->one();
        $kriteria8 = K9LkProdiKriteria8::find()->where(['id_lk_prodi' => $lk])->one();
        $kriteria9 = K9LkProdiKriteria9::find()->where(['id_lk_prodi' => $lk])->one();

        $decode = Json::decode($json);

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


        $ini = parse_ini_file(__DIR__ . '/../../../../../../system-configuration.ini');
        $institusi = $ini['institusi'];

        return $this->render('isi', [
            'lkInstitusi' => $lkInstitusi,
            'kriteria1' => $kriteria1,
            'kriteria2' => $kriteria2,
            'kriteria3' => $kriteria3,
            'kriteria4' => $kriteria4,
            'kriteria5' => $kriteria5,
            'kriteria6' => $kriteria6,
            'kriteria7' => $kriteria7,
            'kriteria8' => $kriteria8,
            'kriteria9' => $kriteria9,
            'decode' => $decode,
            'institusi' => $institusi
        ]);
    }

    public function actionIsiKriteria($lk, $kriteria, $prodi)
    {
        $file_json = 'lkps_prodi_s1.json';
        $json = file_get_contents(Yii::getAlias('@common/required/kriteria9/aps/' . $file_json));

        $lkInstitusi = K9LkProdi::findOne($lk);
        $sourceModel = 'common\\models\\kriteria9\\lk\\prodi\\K9LkProdiKriteria' . $kriteria . 'Detail';
        $sourceKriteria = 'common\\models\\kriteria9\\lk\\prodi\\K9LkProdiKriteria' . $kriteria;

        $model = call_user_func($sourceModel . '::find')->where(['id_lk_prodi_kriteria' . $kriteria => $lk])->all();
        $modelTemp = call_user_func($sourceModel . '::find')->where(['id_lk_prodi_kriteria' . $kriteria => $lk, 'jenis_dokumen' => 'template'])->all();

        $sourceCek = 'common\\models\\kriteria9\\lk\\prodi\\K9LkProdiKriteria' . $kriteria . 'Detail';
//        $cekisi = call_user_func($sourceCek.'::find')->where(['id_lk_prodi_kriteria'.$kriteria=>$lk])->select('kode_dokumen')->distinct()->count();
        $cekisiTemplate = call_user_func($sourceCek . '::find')->where(['id_lk_prodi_kriteria' . $kriteria => $lk, 'jenis_dokumen' => 'template'])->select('kode_dokumen')->distinct()->count();
        $cekisiSumber = call_user_func($sourceCek . '::find')->where(['id_lk_prodi_kriteria' . $kriteria => $lk, 'jenis_dokumen' => 'sumber'])->select('kode_dokumen')->distinct()->count();
        $cekisiPendukung = call_user_func($sourceCek . '::find')->where(['id_lk_prodi_kriteria' . $kriteria => $lk, 'jenis_dokumen' => 'pendukung'])->select('kode_dokumen')->distinct()->count();
        $modelKriteria = call_user_func($sourceKriteria . '::find')->where(['id_lk_prodi' => $lk])->one();

        $template = K9LkTemplate::find();

        $decode = Json::decode($json);
        $data = $decode[$kriteria - 1];
        $butir = $data['butir'];

        $jumlahdok = 0;
        $jumlahisidok = 0;
        //jumlah
        $nomor = [];
        $dokumen = [];

//        var_dump($butir[0]['template']);
//        exit();

        foreach ($butir as $key => $value) {
            if (!empty($value['template'])) {
                $jumlahdok++;
            }
            foreach ($value['dokumen_sumber'] as $key1 => $sumber) {
                if (!empty($sumber['kode'])) {
                    $carikode = call_user_func($sourceCek . '::find')->where(['kode_dokumen' => $sumber['kode'], 'id_lk_prodi_kriteria' . $kriteria => $lk])->all();
                    if ($carikode) {
                        $jumlahisidok++;
                    }
                    $jumlahdok++;
                }
            }
            foreach ($value['dokumen_pendukung'] as $key2 => $pendukung) {
                if (!empty($pendukung['kode'])) {
                    $carikode = call_user_func($sourceCek . '::find')->where(['kode_dokumen' => $pendukung['kode'], 'id_lk_prodi_kriteria' . $kriteria => $lk])->all();
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
        if ($kriteria == 3) {
            if ($isi > 44) {
                $isi = 44;
            }
        }
        if ($kriteria == 4) {
            if ($isi > 47) {
                $isi = 47;
            }
        }

        $progress = round(($isi / array_sum($nomor)) * 100, 2);

        $dokModel = new K9LkProdiKriteriaDetailForm();
        $dokTextModel = new K9TextLkProdiKriteriaDetailForm();
        $dokLinkModel = new K9LinkLkProdiKriteriaDetailForm();
        $dokTempModel = new K9TempLkProdiKriteriaDetailForm();

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

        if ($dokTempModel->load(Yii::$app->request->post())) {
            $dokTempModel->isiDokumen = UploadedFile::getInstance($dokTempModel, 'isiDokumen');
            if ($dokTempModel->uploadTemplate($lk, $kriteria)) {
                Yii::$app->session->setFlash('success', 'Berhasil Upload Template');
                return $this->redirect(Url::current());
            } else {
                Yii::$app->session->setFlash('error', 'Gagal Upload. Cek File');
                return $this->redirect(Url::current());
            }
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
            'model' => $model,
            'modelKriteria' => $modelKriteria,
            'modelTemp' => $modelTemp,
            'lkInstitusi' => $lkInstitusi,
            'json' => $data,
            'butir' => $butir,
            'dokModel' => $dokModel,
            'progress' => $progress,
            'cari' => 'isi',
            'nomor' => $nomor,
            'dokumen' => $dokumen,
            'dokTextModel' => $dokTextModel,
            'dokLinkModel' => $dokLinkModel,
            'dokTempModel' => $dokTempModel,
            'template' => $template
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