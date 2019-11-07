<?php
/**
 * Project: kriteria.
 * @author Adryan Eka Vandra <adryanekavandra@gmail.com>
 *
 * Date: 11/7/2019
 * Time: 11:32 AM
 */

namespace akreditasi\modules\kriteria9\modules\prodi\controllers;


use akreditasi\modules\kriteria9\controllers\BaseController;
use common\models\FakultasAkademi;
use common\models\ProgramStudi;
use Yii;
use yii\helpers\ArrayHelper;

class ProfilController extends BaseController
{

    public function actionUpdate($prodi)
    {
        $model = ProgramStudi::findOne($prodi);
        $dataFakultas = ArrayHelper::map(FakultasAkademi::find()->all(), 'id', 'nama');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Berhasil mengubah ProgramStudi.');

            return $this->redirect(['default/index', 'prodi' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'dataFakultas' => $dataFakultas
        ]);

    }
}