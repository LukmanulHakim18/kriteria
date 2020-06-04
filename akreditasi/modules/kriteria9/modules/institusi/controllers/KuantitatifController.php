<?php


namespace akreditasi\modules\kriteria9\modules\institusi\controllers;


use Carbon\Carbon;
use common\helpers\kriteria9\K9InstitusiDirectoryHelper;
use common\models\kriteria9\akreditasi\K9Akreditasi;
use common\models\kriteria9\akreditasi\K9AkreditasiInstitusi;
use common\models\kriteria9\kuantitatif\institusi\K9DataKuantitatifInstitusi;
use Yii;
use yii\base\DynamicModel;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;

class KuantitatifController extends BaseController
{

    public function actionArsip()
    {
        $modelInstitusi = new DynamicModel(['akreditasi_ins']);
        $modelInstitusi->addRule(['akreditasi_ins'], 'required');

        $idAkreInstitusi = K9Akreditasi::findAll(['jenis_akreditasi' => 'institusi']);
        $dataAkreInstitusi = ArrayHelper::map($idAkreInstitusi, 'id', function ($data) {
            return $data->lembaga . ' - ' . $data->nama . ' ( ' . $data->tahun . ' )';
        });

        if ($modelInstitusi->load(Yii::$app->request->post())) {
            return $this->redirect(['kuantitatif/isi', 'id' => $modelInstitusi->akreditasi_ins]);
        }

        return $this->render('arsip', [
            'modelInstitusi' => $modelInstitusi,
            'dataAkreInstitusi' => $dataAkreInstitusi,
        ]);
    }

    public function actionIsi($id)
    {

        $id_akre_institusi = K9AkreditasiInstitusi::find()->where(['id' => $id])->one();


        $dataKuantitatifInstitusi = K9DataKuantitatifInstitusi::find()->where(['id_akreditasi_institusi' => $id_akre_institusi->id])->all();

        $model = new K9DataKuantitatifInstitusi();

        if ($model->load(Yii::$app->request->post())) {

            $carbon = Carbon::now('Asia/Jakarta');
            $tgl = $carbon->format('U');

            $file = UploadedFile::getInstance($model, 'nama_dokumen');
            $fileName = $tgl . '-' . $file->getBaseName() . '.' . $file->getExtension();
            $model->id_akreditasi_institusi = $id_akre_institusi->id;
            $model->nama_dokumen = $fileName;
            $path = K9InstitusiDirectoryHelper::getKuantitatifPath($model->akreditasiInstitusi);

            if (!$file->saveAs("$path/$fileName")) {
                throw new Exception("Gagal Mengupload File");
            }

            if (!$model->save()) {
                throw new Exception("Gagal Menyimpan Data Kuantitatif");
            }

            Yii::$app->session->setFlash('success', 'Berhasil Mengupload Dokumen Kuantitatif.');

            $this->redirect(Url::current());

        }


        return $this->render('isi', [
            'akreinstitusi' => $id_akre_institusi,
            'dataKuantitatifInstitusi' => $dataKuantitatifInstitusi,
            'model' => $model
        ]);
    }

    public function actionDownloadDokumen($dokumen)
    {
        ini_set('max_execution_time', 5 * 60);
        $template = K9DataKuantitatifInstitusi::findOne($dokumen);
        $path = K9InstitusiDirectoryHelper::getKuantitatifPath($template->akreditasiInstitusi);
        $file = $template->nama_dokumen;
        return Yii::$app->response->sendFile("$path/$file");
    }

    public function actionHapusDokumen()
    {
        if (Yii::$app->request->isPost) {

            $id = Yii::$app->request->post('id');
            $id_institusi = Yii::$app->request->post('id_institusi');

            $model = K9DataKuantitatifInstitusi::findOne($id);
            $path = K9InstitusiDirectoryHelper::getKuantitatifPath($model->akreditasiInstitusi);

            unlink("$path/$model->nama_dokumen");

            $model->delete();

            Yii::$app->session->setFlash('success', 'Berhasil Menghapus Data');
            return $this->redirect(['kuantitatif/isi', 'id' => $id_institusi]);

        }

        throw new BadRequestHttpException('Request Harus Post');
    }

    public function actionLihatDokumen($id)
    {
        $model = K9DataKuantitatifInstitusi::findOne($id);
        $path = K9InstitusiDirectoryHelper::getKuantitatifUrl($model->akreditasiInstitusi);
        return $this->redirect(Url::to("$path/$model->nama_dokumen"));
//        return $this->redirect(Url::to("@web/upload/BAN-PT/institusi/2019/institusi/matriks-kuantitatif/".$this->findModel($id)->nama_dokumen));
    }


}
