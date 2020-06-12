<?php

namespace monitoring\modules\eksekutif\modules\prodi\controllers;

use yii\web\Controller;

/**
 * Default controller for the `eksekutif-prodi` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
