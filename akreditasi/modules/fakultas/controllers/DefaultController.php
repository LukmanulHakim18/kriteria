<?php

namespace akreditasi\modules\fakultas\controllers;

use common\models\FakultasAkademi;
use yii\web\Controller;

/**
 * Default controller for the `fakultas` module
 */
class DefaultController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $id = \Yii::$app->request->get('fakultas');
        $fakultas = FakultasAkademi::findOne(['id'=>$id]);
        $profil = $fakultas->profil;
        $prodi = $fakultas->programStudis;
        return $this->render('index',[
            'fakultas'=>$fakultas,
            'prodis'=>$prodi,
            'profil'=>$profil
        ]);
    }
}
