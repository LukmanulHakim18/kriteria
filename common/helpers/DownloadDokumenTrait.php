<?php


namespace common\helpers;

use Yii;

trait DownloadDokumenTrait
{

    public function download($model, $path, $file)
    {
        if ($model->jenis_dokumen === 'lainnya') {
            return Yii::$app->response->sendFile("$path/lainnya/$file");
        }

        if ($model->jenis_dokumen === 'sumber') {
            return Yii::$app->response->sendFile("$path/sumber/$file");
        }

        if ($model->jenis_dokumen === 'pendukung') {
            return Yii::$app->response->sendFile("$path/pendukung/$file");
        }
    }
}
