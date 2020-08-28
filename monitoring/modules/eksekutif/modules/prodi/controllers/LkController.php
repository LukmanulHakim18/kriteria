<?php


namespace monitoring\modules\eksekutif\modules\prodi\controllers;

use common\helpers\kriteria9\K9ProdiDirectoryHelper;
use common\helpers\kriteria9\K9ProdiJsonHelper;
use common\models\kriteria9\lk\K9LkTemplate;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria1Detail;
use Yii;

class LkController extends BaseController
{

    public function actionLihat($lk, $kriteria, $prodi)
    {

        $modelProdi = $this->findProdi($prodi);
        $json = K9ProdiJsonHelper::getJson('lk', $modelProdi->jenjang);
        $dataKriteria = $json[$kriteria - 1];
        $poinKriteria = $dataKriteria['butir'];
        $lkKriteriaClass = 'common\\models\\kriteria9\\lk\\prodi\\K9LkProdiKriteria'.$kriteria;
        $modelKriteria = call_user_func($lkKriteriaClass.'::findOne',['id_lk_prodi'=>$lk]);
        $modelNarasiClass = 'akreditasi\\models\\kriteria9\\lk\\prodi\\K9LkProdiNarasiKriteria' . $kriteria . 'Form';
        $modelNarasi = call_user_func($modelNarasiClass . '::findOne', ['id_lk_prodi_kriteria'.$kriteria=>$modelKriteria->id]);

        $akreditasiProdi = $modelNarasi->lkProdi->akreditasiProdi;
        return $this->render('lihat-kriteria', [
            'akreditasiProdi' => $akreditasiProdi,
            'modelProdi' => $modelProdi,
            'modelNarasi' => $modelNarasi,
            'poinKriteria' => $poinKriteria,
            'modelKriteria'=>$modelKriteria
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

        if ($model->jenis_dokumen === 'lainnya') {
            return Yii::$app->response->sendFile("$path/lainnya/$file");
        } elseif ($model->jenis_dokumen === 'sumber') {
            return Yii::$app->response->sendFile("$path/sumber/$file");
        } elseif ($model->jenis_dokumen === 'pendukung') {
            return Yii::$app->response->sendFile("$path/pendukung/$file");
        } else {
            return Yii::$app->response->sendFile("$path/$file");
        }
    }
}
