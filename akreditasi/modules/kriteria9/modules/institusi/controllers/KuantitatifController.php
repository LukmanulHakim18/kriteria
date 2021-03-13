<?php


namespace akreditasi\modules\kriteria9\modules\institusi\controllers;


use akreditasi\models\kriteria9\forms\K9KuantitatifUploadForm;
use common\helpers\kriteria9\K9InstitusiDirectoryHelper;
use common\jobs\KuantitatifPTAkademikExportJob;
use common\jobs\KuantitatifPTVokasiExportJob;
use common\models\kriteria9\akreditasi\K9Akreditasi;
use common\models\kriteria9\akreditasi\K9AkreditasiInstitusi;
use common\models\kriteria9\kuantitatif\institusi\K9DataKuantitatifInstitusi;
use common\models\ProfilInstitusi;
use Yii;
use yii\base\DynamicModel;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;

class KuantitatifController extends BaseController
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'export' => ['POST']
                ]
            ]
        ];
    }

    public function actionArsip()
    {
        $modelInstitusi = new DynamicModel(['akreditasi_ins']);
        $modelInstitusi->addRule(['akreditasi_ins'], 'required');

        $idAkreInstitusi = K9Akreditasi::findAll(['jenis_akreditasi' => 'institusi']);
        $dataAkreInstitusi = ArrayHelper::map($idAkreInstitusi, 'id', function ($data) {
            return $data->lembaga . ' - ' . $data->nama . ' ( ' . $data->tahun . ' )';
        });

        if ($modelInstitusi->load(Yii::$app->request->post())) {
            $akreditasiInstitusi = K9AkreditasiInstitusi::findOne(['id_akreditasi' => $modelInstitusi->akreditasi_ins]);
            return $this->redirect(['kuantitatif/isi', 'id' => $akreditasiInstitusi->id]);
        }

        return $this->render('arsip', [
            'modelInstitusi' => $modelInstitusi,
            'dataAkreInstitusi' => $dataAkreInstitusi,
        ]);
    }

    public function actionIsi($id)
    {

        $akreditasiInstitusi = K9AkreditasiInstitusi::findOne(['id' => $id]);


        $dataKuantitatifInstitusi = new ActiveDataProvider(['query' => K9DataKuantitatifInstitusi::find()->where(['id_akreditasi_institusi' => $akreditasiInstitusi->id])]);

        $model = new K9DataKuantitatifInstitusi();
        $modelUpload = new K9KuantitatifUploadForm();
        $path = K9InstitusiDirectoryHelper::getKuantitatifPath($akreditasiInstitusi);

        $model->id_akreditasi_institusi = $akreditasiInstitusi->id;
        $model->nama_dokumen = 'Matriks Kuantitatif Institusi ' . '(' . $akreditasiInstitusi->akreditasi->tahun . ')';

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', compact('model', 'modelUpload'));
        }

        if ($model->load(Yii::$app->request->post())) {

            $file = UploadedFile::getInstance($modelUpload, 'berkas');
            $modelUpload->berkas = $file;

            if (!($filename = $modelUpload->upload($path))) {
                throw new Exception("Gagal Mengupload File");
            }
            $model->isi_dokumen = $filename;
            $model->sumber = K9DataKuantitatifInstitusi::SUMBER_UNGGAH;

            if (!$model->save()) {
                throw new Exception("Gagal Menyimpan Data Kuantitatif");
            }

            Yii::$app->session->setFlash('success', 'Berhasil Mengupload Dokumen Kuantitatif.');

            $this->redirect(Url::current());
        }

        return $this->render('isi', [
            'akreinstitusi' => $akreditasiInstitusi,
            'dataKuantitatifInstitusi' => $dataKuantitatifInstitusi,
        ]);
    }

    public function actionDownloadDokumen($dokumen)
    {
        ini_set('max_execution_time', 5 * 60);
        $template = K9DataKuantitatifInstitusi::findOne($dokumen);
        $path = K9InstitusiDirectoryHelper::getKuantitatifPath($template->akreditasiInstitusi);
        $file = $template->isi_dokumen;
        return Yii::$app->response->sendFile("$path/$file");
    }

    public function actionHapusDokumen()
    {
        if (Yii::$app->request->isPost) {

            $id = Yii::$app->request->post('id');
            $model = K9DataKuantitatifInstitusi::findOne($id);
            $akreditasiInstitusi = $model->akreditasiInstitusi;
            $path = K9InstitusiDirectoryHelper::getKuantitatifPath($model->akreditasiInstitusi);

            unlink("$path/$model->isi_dokumen");

            $model->delete();

            Yii::$app->session->setFlash('success', 'Berhasil Menghapus Data');
            return $this->redirect(['kuantitatif/isi', 'id' => $akreditasiInstitusi->id]);

        }

        throw new BadRequestHttpException('Request Harus Post');
    }

    public function actionExport()
    {
        $params = Yii::$app->request->post();
        $akreditasiInstitusi = K9AkreditasiInstitusi::findOne([$params['akreditasiInstitusi']]);
        $laporanKinerja = $akreditasiInstitusi->k9LkInstitusi;
        $jenis = ArrayHelper::map(ProfilInstitusi::find()->all(), 'nama', 'isi');
        $template = K9InstitusiDirectoryHelper::getKuantitatifTemplate($jenis['bentuk']);
        $id = $jenis['bentuk'] === 'akademik' ? Yii::$app->queue->push(new KuantitatifPTAkademikExportJob([
            'template' => $template,
            'lk' => $laporanKinerja
        ])) : Yii::$app->queue->push(new KuantitatifPTVokasiExportJob([
            'template' => $template,
            'lk' => $laporanKinerja
        ]));

        if ($id) {
            Yii::$app->session->setFlash('success', 'Berhasil membuat data kuantitatif, silahkan ditunggu.');
        }

        return $this->redirect(['isi', 'id' => $akreditasiInstitusi->id]);

    }

    public function actionShow($id)
    {
        $model = K9DataKuantitatifInstitusi::findOne($id);
        $path = K9InstitusiDirectoryHelper::getKuantitatifUrl($model->akreditasiInstitusi);
        return $this->renderAjax('_document', ['model' => $model, 'path' => $path]);
    }


}
