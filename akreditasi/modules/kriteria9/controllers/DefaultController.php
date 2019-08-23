<?php

namespace akreditasi\modules\kriteria9\controllers;

use yii\web\Controller;

/**
 * Default controller for the `kriteria9` module
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
