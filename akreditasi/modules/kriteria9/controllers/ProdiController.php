<?php
/**
 * mutu-v2
 * @author Adryan Eka Vandra <adryanekavandra@gmail.com>
 */
/**
 * Class ProdiController
 * @package akreditasi\modules\kriteria9\controllers
 */


namespace akreditasi\modules\kriteria9\controllers;


use akreditasi\models\PencarianProdiForm;
use common\models\ProgramStudi;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ProdiController extends Controller
{

    /**
     * @param $action
     * @return bool
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->layout = "main";
        return parent::beforeAction($action);
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionArsip(){

        $model = new PencarianProdiForm();

        $idProdi = ProgramStudi::find()->all();
        $dataProdi = ArrayHelper::map($idProdi, 'id', function ($data){
            return $data->nama. '('.$data->jenjang.')';
        });


        if($model->load(Yii::$app->request->post())){

            $url = $model->cariK9();
            if(!$url){
                throw new NotFoundHttpException('Data yang anda cari tidak ditemukan');
            }

            $this->redirect($url);

        }

        return $this->render('arsip',[
            'model' => $model,
            'dataProdi' => $dataProdi
        ]);
    }

}