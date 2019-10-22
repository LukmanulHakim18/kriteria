<?php

namespace akreditasi\modules\kriteria9\modules\prodi\controllers;

use common\models\ProgramStudi;
use Yii;
use yii\web\Controller;

/**
 * Default controller for the `k9-prodi` module
 */
class DefaultController extends Controller
{
    public $layout = 'main';
    public function actionIndex()
    {
        $id_prodi = Yii::$app->request->get('prodi');

        $modelProdi = ProgramStudi::findOne(['id'=>$id_prodi]);

        return $this->render('index',[
            'modelProdi' => $modelProdi
        ]);
    }
}
