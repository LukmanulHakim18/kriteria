<?php

namespace monitoring\modules\asesor\controllers;

use common\models\kriteria9\akreditasi\K9AkreditasiInstitusi;
use common\models\kriteria9\akreditasi\K9AkreditasiProdi;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

/**
 * Default controller for the `asesor` module
 */
class DefaultController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $apsDataProvider = new ActiveDataProvider(['query' => K9AkreditasiProdi::find()]);
        $aptDataProvider = new ActiveDataProvider(['query' => K9AkreditasiInstitusi::find()]);

        return $this->render('index',compact('apsDataProvider','aptDataProvider'));
    }
}
