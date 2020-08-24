<?php

namespace monitoring\modules\eksekutif\modules\prodi\controllers;

use yii\web\Controller;

/**
 * Default controller for the `eksekutif-prodi` module
 */
class DefaultController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $id = \Yii::$app->request->get('prodi');
        $prodi = $this->findProdi($id);
        $profil = $prodi->profil;
        $akreditasiProdi = $prodi->getK9AkreditasiProdis()->orderBy('id DESC')->one();
        return $this->render('index',['prodi'=>$prodi,'akreditasiProdi'=>$akreditasiProdi,'profil'=>$profil]);
    }

}
