<?php

namespace akreditasi\modules\kriteria9\modules\prodi\controllers;

use akreditasi\modules\kriteria9\controllers\BaseController;
use common\models\ProgramStudi;
use Yii;

/**
 * Default controller for the `k9-prodi` module
 */
class DefaultController extends BaseController
{
    public function actionIndex()
    {
        $id_prodi = Yii::$app->request->get('prodi');

        $modelProdi = ProgramStudi::findOne(['id' => $id_prodi]);
        $profil = $modelProdi->profil[0];

        return $this->render('index', [
            'modelProdi' => $modelProdi,
            'profil'=>$profil
        ]);
    }
}
