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
        $modelFakultas = $this->findFakultas($fakultas);
        $prodis = $modelFakultas->programStudis;
        $profil = $modelFakultas->profil;
        return $this->render('index', compact('modelFakultas', 'prodis', 'profil'));
    }
}
