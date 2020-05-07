<?php

namespace akreditasi\modules\unit\controllers;

use common\models\Unit;
use yii\web\Controller;

/**
 * Default controller for the `unit` module
 */
class DefaultController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    public function beforeAction($action)
    {
        $this->layout="main";
        return parent::beforeAction($action);
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($unit)
    {
        $unit = Unit::findOne($unit);
        return $this->render('index',['unit'=>$unit]);
    }
}
