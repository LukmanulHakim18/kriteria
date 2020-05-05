<?php

namespace akreditasi\modules\unit\controllers;

use akreditasi\modules\kriteria9\controllers\BaseController;

/**
 * Default controller for the `unit` module
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
