<?php


namespace akreditasi\modules\kriteria9\modules\institusi\controllers;


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
use yii\web\BadRequestHttpException;

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

        $id_akre_institusi = K9AkreditasiInstitusi::findOne(['id' => $id]);


        $dataKuantitatifInstitusi = new ActiveDataProvider(['query' => K9DataKuantitatifInstitusi::find()->where(['id_akreditasi_institusi' => $id_akre_institusi->id])]);

//        $model = new K9DataKuantitatifInstitusi();
//
//        if ($model->load(Yii::$app->request->post())) {
//
//            $carbon = Carbon::now('Asia/Jakarta');
//            $tgl = $carbon->format('U');
//
//            $file = UploadedFile::getInstance($model, 'nama_dokumen');
//            $fileName = $tgl . '-' . $file->getBaseName() . '.' . $file->getExtension();
//            $model->id_akreditasi_institusi = $id_akre_institusi->id;
//            $model->nama_dokumen = $fileName;
//            $path = K9InstitusiDirectoryHelper::getKuantitatifPath($model->akreditasiInstitusi);
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
            'akreinstitusi' => $id_akre_institusi,
            'dataKuantitatifInstitusi' => $dataKuantitatifInstitusi,
//            'model' => $model
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
        $template = K9InstitusiDirectoryHelper::getKuantitatifTemplate($jenis['jenis']);
        $id = $jenis['jenis'] === 'akademik' ? Yii::$app->queue->push(new KuantitatifPTAkademikExportJob([
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


}
