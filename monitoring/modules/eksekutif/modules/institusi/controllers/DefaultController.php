<?php

namespace monitoring\modules\eksekutif\modules\institusi\controllers;

/**
 * Default controller for the `eksekutif-institusi` module
 */
class DefaultController extends BaseController
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
