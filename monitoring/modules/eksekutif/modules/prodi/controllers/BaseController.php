<?php


namespace monitoring\modules\eksekutif\modules\prodi\controllers;

use common\models\ProgramStudi;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BaseController extends Controller
{

    public $layout  = 'main';

    protected function findProdi($id)
    {
        $model = ProgramStudi::findOne($id);
        if ($model) {
            return $model;
        }
        throw new NotFoundHttpException('Data yang anda cari tidak ditemukan');
    }
}
