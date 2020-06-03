<?php

namespace akreditasi\modules\kriteria9\modules\institusi\controllers;

use common\models\FakultasAkademi;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Default controller for the `k9-institusi` module
 */
class DefaultController extends BaseController
{

      /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $modelFakultas = FakultasAkademi::find()->all();

        return $this->render('index',[
            'modelFakultas'=>$modelFakultas
        ]);
    }
}
