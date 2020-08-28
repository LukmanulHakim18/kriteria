<?php

namespace monitoring\modules\eksekutif\modules\fakultas\controllers;

use yii\web\Controller;

/**
 * Default controller for the `eksekutif-fakultas` module
 */
class DefaultController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($fakultas)
    {
        $model = $this->findFakultas($fakultas);
        $prodis = $model->programStudis;
        $profil = $model->profil;

        $akreditasiTerakhir = $this->findAkreditasiProdiTerakhir();
        return $this->render('index', compact('model', 'prodis', 'profil', 'akreditasiTerakhir'));
    }
}
