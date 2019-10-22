<?php

namespace akreditasi\modules\unit\controllers;

/**
 * Default controller for the `unit` module
 */
class DefaultController extends BaseCon
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
