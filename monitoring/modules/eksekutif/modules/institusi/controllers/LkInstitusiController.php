<?php


namespace monitoring\modules\eksekutif\modules\institusi\controllers;

use akreditasi\models\kriteria9\forms\lk\institusi\K9LinkLkInstitusiKriteriaDetailForm;
use akreditasi\models\kriteria9\forms\lk\institusi\K9LkInstitusiKriteriaDetailForm;
use akreditasi\models\kriteria9\forms\lk\institusi\K9TextLkInstitusiKriteriaDetailForm;
use common\helpers\DownloadDokumenTrait;
use common\helpers\kriteria9\K9InstitusiDirectoryHelper;
use common\helpers\kriteria9\K9InstitusiJsonHelper;
use common\models\kriteria9\akreditasi\K9Akreditasi;
use common\models\kriteria9\forms\lk\K9PencarianLkInstitusiForm;
use common\models\kriteria9\lk\institusi\K9LkInstitusi;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria1;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria2;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria3;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria4;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria5;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;

class LkInstitusiController extends BaseController
{

    use DownloadDokumenTrait;

    public function actionDownloadDetail($dokumen, $kriteria, $lk)
    {
        ini_set('max_execution_time', 5 * 60);
        $detailClass = 'common\\models\\kriteria9\\lk\\institusi\\K9LkInstitusiKriteria' . $kriteria . 'Detail';
        $model = call_user_func($detailClass . '::findOne', $dokumen);
        $attribute = 'lkInstitusiKriteria' . $kriteria;

        $path = K9InstitusiDirectoryHelper::getDokumenLkPath($model->$attribute->lkInstitusi->akreditasiInstitusi);
        $file = $model->isi_dokumen;

        $this->download($model, $path, $file);

        return Yii::$app->response->sendFile("$path/$file");
    }


    public function actionLihat($kriteria, $lk)
    {
        $dataKriteria = K9InstitusiJsonHelper::getJsonKriteriaLk($kriteria);
        $poinKriteria = $dataKriteria['butir'];
        $lkInstitusi = K9LkInstitusi::findOne($lk);

        $path = K9InstitusiDirectoryHelper::getDokumenLkUrl($lkInstitusi->akreditasiInstitusi);

        $lkInstitusiKriteriaClass= 'common\\models\\kriteria9\lk\\institusi\\K9lkInstitusiKriteria' . $kriteria;
        $lkInstitusiKriteria = call_user_func($lkInstitusiKriteriaClass . '::findOne', ['id_lk_institusi'=>$lkInstitusi->id]);

        $modelNarasiClass = 'akreditasi\\models\\kriteria9\\lk\\institusi\\K9LkInstitusiNarasiKriteria' . $kriteria . 'Form';
        $modelNarasi = call_user_func($modelNarasiClass . '::findOne', ['id_lk_institusi_kriteria' . $kriteria=>$lkInstitusiKriteria->id]);

        return $this->render('lihat-kriteria', [
            'modelNarasi' => $modelNarasi,
            'lkInstitusi' => $lkInstitusi,
            'poinKriteria' => $poinKriteria,
            'modelKriteria'=>$lkInstitusiKriteria,
            'path'=>$path
        ]);
    }
}
