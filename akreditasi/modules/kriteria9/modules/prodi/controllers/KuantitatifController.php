<?php


namespace akreditasi\modules\kriteria9\modules\prodi\controllers;


use akreditasi\modules\kriteria9\controllers\BaseController;
use common\helpers\kriteria9\K9ProdiDirectoryHelper;
use common\jobs\KuantitatifProdiExportJob;
use common\models\kriteria9\akreditasi\K9Akreditasi;
use common\models\kriteria9\akreditasi\K9AkreditasiProdi;
use common\models\kriteria9\forms\kuantitatif\K9PencarianKuantitatifForm;
use common\models\kriteria9\kuantitatif\prodi\K9DataKuantitatifProdi;
use common\models\ProgramStudi;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class KuantitatifController extends BaseController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    ['export' => 'POST']

                ]
            ]
        ];
    }

    public function actionArsip($target, $prodi)
    {
        $model = new K9PencarianKuantitatifForm();

        $idAkreditasiProdi = K9Akreditasi::findAll(['jenis_akreditasi' => 'prodi']);
        $dataAkreditasiProdi = ArrayHelper::map($idAkreditasiProdi, 'id', function ($data) {
            return $data->lembaga . ' - ' . $data->nama . ' ( ' . $data->tahun . ' )';
        });

        $idProdi = ProgramStudi::findAll(['id' => $prodi]);
        $dataProdi = ArrayHelper::map($idProdi, 'id', function ($data) {
            return $data->nama . '(' . $data->jenjang . ')';
        });

        if ($model->load(Yii::$app->request->post())) {

            $url = $model->cari($target);

            return $this->redirect($url);

        }
        return $this->render('arsip', [
            'model' => $model,
            'dataAkreditasiProdi' => $dataAkreditasiProdi,
            'dataProdi' => $dataProdi
        ]);
    }

    public function actionIsi($akreditasiprodi, $prodi)
    {

        $akreditasiProdi = K9AkreditasiProdi::findOne($akreditasiprodi);
        if (!$akreditasiProdi) {
            throw new NotFoundHttpException();
        }

        $prodi = $akreditasiProdi->prodi;

        $dataKuantitatifProdi = K9DataKuantitatifProdi::findAll(['id_akreditasi_prodi' => $akreditasiProdi->id]);
//        $model = new K9DataKuantitatifProdi();
//
//        if ($model->load(Yii::$app->request->post())) {
//
////            var_dump($model->akreditasiProdi);
////            exit();
//
//            $carbon = Carbon::now('Asia/Jakarta');
//            $tgl = $carbon->format('U');
//
//            $file = UploadedFile::getInstance($model, 'nama_dokumen');
//            $fileName = $tgl . '-' . $file->getBaseName() . '.' . $file->getExtension();
//            $model->id_akreditasi_prodi = $id_akre->id;
//            $model->nama_dokumen = $fileName;
//            $path = K9ProdiDirectoryHelper::getKuantitatifPath($model->akreditasiProdi);
//
//            if (!$file->saveAs("$path/$fileName")) {
//                throw new Exception("Gagal Mengupload File");
//            }
//
//            if (!$model->save()) {
//                throw new Exception("Gagal Menyimpan Data Kuantitatif");
//            }
//
//            Yii::$app->session->setFlash('success', 'Berhasil Mengupload Dokumen Kuantitatif.');
//
//            $this->redirect(Url::current());
//
//        }

        return $this->render('isi', [
            'akreditasiProdi' => $akreditasiProdi,
            'dataKuantitatifProdi' => $dataKuantitatifProdi,
            'prodi' => $prodi
//            'model' => $model
        ]);
    }

    public function actionExport()
    {
        $params = Yii::$app->request->post();
        $akreditasiProdi = K9AkreditasiProdi::findOne([$params['akreditasiprodi']]);
        $prodi = $akreditasiProdi->prodi;

        $laporanKinerja = $akreditasiProdi->k9LkProdi;
        $path = K9ProdiDirectoryHelper::getKuantitatifTemplate();
        $id = Yii::$app->queue->push(new KuantitatifProdiExportJob(['template' => $path, 'lk' => $laporanKinerja]));

        if ($id) {
            Yii::$app->session->setFlash('success', 'Berhasil membuat data kuantitatif, silahkan ditunggu.');
        }
        return $this->redirect(['isi', 'akreditasiprodi' => $akreditasiProdi->id, 'prodi' => $prodi->id]);
    }

    public function actionDownloadDokumen($dokumen, $prodi)
    {
        ini_set('max_execution_time', 5 * 60);
        $template = K9DataKuantitatifProdi::findOne($dokumen);
        $path = K9ProdiDirectoryHelper::getKuantitatifPath($template->akreditasiProdi);
        $file = $template->isi_dokumen;
        return Yii::$app->response->sendFile("$path/$file");
    }

    public function actionHapusDokumen()
    {
        if (Yii::$app->request->isPost) {

            $id = Yii::$app->request->post('id');
            $prodi = Yii::$app->request->post('prodi');

            $model = K9DataKuantitatifProdi::findOne($id);
            $path = K9ProdiDirectoryHelper::getKuantitatifPath($model->akreditasiProdi);
            $file = $model->nama_dokumen;

            unlink("$path/$file");

            $model->delete();

            Yii::$app->session->setFlash('success', 'Berhasil Menghapus Data');
            return $this->redirect(['kuantitatif/isi', 'prodi' => $prodi]);

        }

        throw new BadRequestHttpException('Request Harus Post');
    }

    public function actionLihatDokumen($id, $prodi)
    {
        $model = K9DataKuantitatifProdi::findOne($id);
        $path = K9ProdiDirectoryHelper::getKuantitatifUrl($model->akreditasiProdi);
//        return $this->redirect(Url::to("@web/upload/BAN-PT/prodi/2019/prodi/$prodi/matriks-kuantitatif/".$this->findModel($id)->nama_dokumen));
        return $this->redirect(Url::to("$path/$model->nama_dokumen"));
    }
}
