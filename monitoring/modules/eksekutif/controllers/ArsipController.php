<?php


namespace monitoring\modules\eksekutif\controllers;

use common\models\AuthAssignment;
use common\models\FakultasAkademi;
use common\models\ProgramStudi;
use monitoring\models\forms\PencarianFakultasForm;
use monitoring\models\forms\PencarianProdiForm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class ArsipController extends BaseController
{

    public function actionProdi()
    {
        $model = new PencarianProdiForm();
        //cek akses sesuai data
        $role = AuthAssignment::findOne(['user_id'=>Yii::$app->user->identity->getId()]);
        if ($role->item_name === 'prodi' || $role->item_name === 'kaprodi') {
            $idProdi = Yii::$app->user->identity->profilUser->getProdi()->all();
        } elseif ($role->item_name === 'fakultas' || $role->item_name === 'dekanat') {
            $idProdi = Yii::$app->user->identity->profilUser->fakultas->programStudis;
        } else {
            $idProdi = ProgramStudi::find()->all();
        }


        $dataProdi = ArrayHelper::map($idProdi, 'id', function ($data) {
            return $data->nama . ' (' . $data->jenjang . ')';
        });


        if ($model->load(Yii::$app->request->post())) {
            $url = $model->cariK9();
            if (!$url) {
                throw new NotFoundHttpException('Data yang anda cari tidak ditemukan');
            }

            $this->redirect($url);
        }

        return $this->render('prodi', [
            'model' => $model,
            'dataProdi' => $dataProdi
        ]);
    }

    public function actionFakultas()
    {

        $identity = Yii::$app->user->identity;
        $model = new PencarianFakultasForm();
        $role = AuthAssignment::findOne(['user_id'=>$identity->getId()]);
        if (!$role) {
            throw new NotFoundHttpException();
        }
        $fakultas = null;
        if ($role->item_name === 'superadmin' || $role->item_name === 'lpm') {
            $fakultas = FakultasAkademi::find()->all();
        } elseif ($role->item_name === 'fakultas' || $role->item_name === 'dekanat') {
            $fakultas = $identity->profilUser->getFakultas()->all();
        }

        $dataFakultas = ArrayHelper::map($fakultas, 'id', function ($item) {
            return "{$item->nama} ({$item->jenisString})";
        });

        if ($model->load(Yii::$app->request->post())) {
            $url = $model->cari();
            if (!$url) {
                throw new NotFoundHttpException();
            }
            return $this->redirect($url);
        }

        return $this->render('fakultas', ['model' => $model, 'dataFakultas' => $dataFakultas]);
    }

    public function actionInstitusi()
    {
        return $this->redirect(['/eksekutif/eksekutif-institusi/default/index']);
    }
}
