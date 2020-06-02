<?php

namespace akreditasi\modules\fakultas\controllers;

use akreditasi\models\fakultas\BerkasUploadForm;
use common\helpers\FakultasDirectoryHelper;
use common\models\DetailBerkas;
use common\models\FakultasAkademi;
use Yii;
use yii\filters\AccessControl;
use common\models\Berkas;
use akreditasi\models\fakultas\BerkasSearch;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\bootstrap4\ActiveForm;
use yii\web\UploadedFile;

/**
 * BerkasController implements the CRUD actions for Berkas model.
 */
class BerkasController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'delete-berkas'=>['POST']
                ],
            ],
        ];
    }

    /**
     * Lists all Berkas models.
     * @return mixed
     */
    public function actionIndex($fakultas)
    {
        $searchModel = new BerkasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Berkas model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($fakultas, $id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Berkas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($fakultas)
    {
        $model = new Berkas();
        $detailModel = new BerkasUploadForm();
        $path = FakultasDirectoryHelper::getPath($fakultas);
        $urlPath = FakultasDirectoryHelper::getUrl($fakultas);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $detailModel->berkas = UploadedFile::getInstances($detailModel, 'berkas');

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->external_id = $fakultas;
                $model->type = FakultasAkademi::FAKULTAS_AKADEMI;
                $model->save();

                if ($files = $detailModel->upload($path)) {
                    foreach ($files as $file) {
                        $detail = new DetailBerkas();
                        $detail->id_berkas =$model->id;
                        $detail->isi_berkas = $file['isi_berkas'];
                        $detail->bentuk_berkas = $file['bentuk_berkas'];
                        $detail->save(false);
                    }
                }

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Berhasil menambahkan Berkas.');

                return $this->redirect(['view', 'id' => $model->id,'fakultas'=>$fakultas]);
            } catch (\Exception $exception) {
                $transaction->rollBack();
                throw $exception;
            }
        } elseif (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', ['model'=>$model,'detailModel'=>$detailModel,'urlPath'=>$urlPath]);
        }

        return $this->render('create', [
            'model' => $model,
            'detailModel'=>$detailModel,
            'urlPath'=>$urlPath
        ]);
    }

    /**
     * Updates an existing Berkas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($fakultas, $id)
    {
        $model = $this->findModel($id);
        $detailModel = new BerkasUploadForm();
        $path = FakultasDirectoryHelper::getPath($fakultas);
        $urlPath=  FakultasDirectoryHelper::getUrl($fakultas);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            $detailModel->berkas = UploadedFile::getInstances($detailModel, 'berkas');

            try {
                $model->save();

                if ($files = $detailModel->upload($path)) {
                    foreach ($files as $file) {
                        $detail = new DetailBerkas();
                        $detail->id_berkas = $model->id;
                        $detail->isi_berkas = $file['isi_berkas'];
                        $detail->bentuk_berkas = $file['bentuk_berkas'];
                        $detail->save(false);
                    }
                }

                $transaction->commit();


                Yii::$app->session->setFlash('success', 'Berhasil mengubah Berkas.');

                return $this->redirect(['view', 'id' => $model->id]);
            } catch (\Exception $exception) {
                $transaction->rollBack();
                throw $exception;
            }
        }

        return $this->render('update', [
            'model' => $model,
            'detailModel'=>$detailModel,
            'urlPath'=>$urlPath
        ]);
    }

    /**
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteBerkas()
    {
        $id = Yii::$app->request->post('id');
        $detail = $this->findDetail($id);
        $berkas = $detail->berkas;
        $fakultas = $berkas->external_id;
        $path = FakultasDirectoryHelper::getPath($fakultas);
        FileHelper::unlink("$path/{$detail->isi_berkas}");
        $detail->delete();
        return $this->redirect(['berkas/update','fakultas'=>$fakultas,'id'=>$berkas->id]);
    }

    /**
     * @param $id
     * @return \yii\console\Response|Response
     * @throws NotFoundHttpException
     */
    public function actionDownloadBerkas($id)
    {
        $detail = $this->findDetail($id);
        $berkas = $detail->berkas;
        $fakultas = $berkas->external_id;
        $path = FakultasDirectoryHelper::getPath($fakultas);
        return Yii::$app->response->sendFile("$path/{$detail->isi_berkas}");
    }

    /**
     * Deletes an existing Berkas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param $fakultas
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($fakultas, $id)
    {
        $this->findModel($id)->delete();

        Yii::$app->session->setFlash('success', 'Berhasil menghapus Berkas.');

        return $this->redirect(['index','fakultas'=>$fakultas]);
    }

    /**
     * Finds the Berkas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Berkas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Berkas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param $id
     * @return DetailBerkas|null
     * @throws NotFoundHttpException
     */
    protected function findDetail($id)
    {
        if (($model = DetailBerkas::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Data yang anda cari tidak ditemukan');
    }
}
