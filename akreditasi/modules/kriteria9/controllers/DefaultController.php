<?php

namespace akreditasi\modules\kriteria9\controllers;

use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Default controller for the `kriteria9` module
 */
class DefaultController extends Controller
{

    /**
     * @param $action
     * @return bool
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->layout="main";
        return parent::beforeAction($action);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
