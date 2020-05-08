<?php

namespace akreditasi\modules\fakultas\controllers;

use akreditasi\models\PencarianFakultasForm;
use common\models\AuthAssignment;
use common\models\FakultasAkademi;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ArsipController extends Controller
{

    public function actionIndex()
    {
        $identity = \Yii::$app->user->identity;
        $model = new PencarianFakultasForm();
        $role = AuthAssignment::findOne(['user_id'=>$identity->getId()]);
        if(!$role) throw new NotFoundHttpException();
        $fakultas = null;
        if($role->item_name === 'superadmin' || $role->item_name === 'lpm'){
            $fakultas = FakultasAkademi::find()->all();
        }
        elseif($role->item_name === 'fakultas' || $role->item_name === 'dekanat'){
            $fakultas = $identity->profilUser->getFakultas()->all();
        }

        $dataFakultas = ArrayHelper::map($fakultas,'id',function($item){
            return "{$item->nama} ({$item->jenisString})";
        });

        if($model->load(\Yii::$app->request->post())){
            $url = $model->cari();
            if(!$url) throw new NotFoundHttpException();
            return  $this->redirect($url);
        }

        return $this->render('index',['model'=>$model,'dataFakultas'=>$dataFakultas]);
    }
}
