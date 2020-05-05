<?php

namespace akreditasi\modules\unit\controllers;

use akreditasi\models\unit\KegiatanDetailUploadForm;
use common\helpers\UnitDirectoryHelper;
use common\models\unit\KegiatanUnitDetail;
use Yii;
use yii\filters\AccessControl;
use common\models\unit\KegiatanUnit;
use akreditasi\models\unit\KegiatanUnitSearch;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\bootstrap4\ActiveForm;
use yii\web\UploadedFile;


/**
 * KegiatanController implements the CRUD actions for KegiatanUnit model.
 */
class KegiatanController extends Controller
{

    public $layout = 'main';
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access'=>[
                'class'=>AccessControl::className(),
                'rules'=>[
                    ['actions'=>['index','create','update','view','delete','download-detail','hapus-detail'],
                     'allow'=>true,
                     'roles'=>['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'hapus-detail'=>['POST']
                ],
            ],
        ];
    }

    /**
     * Lists all KegiatanUnit models.
     * @return mixed
     */
    public function actionIndex($unit)
    {
        $searchModel = new KegiatanUnitSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single KegiatanUnit model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($unit,$id)
    {
        $model = $this->findModel($id);
        $detailData = $model->kegiatanUnitDetails;
        $path = UnitDirectoryHelper::getUnitUrl($unit);


        return $this->render('view', [
            'model' => $model,
            'detailData'=>$detailData,
            'path'=>$path
        ]);
    }

    /**
     * Creates a new KegiatanUnit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($unit)
    {
        $model = new KegiatanUnit();
        $detailModel = new KegiatanDetailUploadForm();
        $detailData = [];
        $path = UnitDirectoryHelper::getUnitUrl($unit);

        if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())){
            $model->id_unit = $unit;
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->id_unit = $unit;
            $transaction = Yii::$app->db->beginTransaction();
            $model->save(false);
            $detailModel->load(Yii::$app->request->post());
            $detailModel->berkas = UploadedFile::getInstances($detailModel,'berkas');
            $path = UnitDirectoryHelper::getUnitPath($model->id_unit);

            $files = $detailModel->upload($path);
            if(!$files){
                $transaction->rollBack();
                Yii::$app->session->setFlash('warning','Gagal Menyimpan files');

                return $this->redirect(Url::current());
            }
            foreach ($files as $file){
                $detail = new KegiatanUnitDetail();
                $detail->id_kegiatan_unit = $model->id;
                $detail->nama_file = $file['filename'];
                $detail->bentuk_file = $file['bentuk_file'];

                $detail->save(false);
            }

            $transaction->commit();

            Yii::$app->session->setFlash('success','Berhasil menambahkan KegiatanUnit.');

            return $this->redirect(['view', 'id' => $model->id,'unit'=>$unit]);
        }

        elseif (Yii::$app->request->isAjax){
            return $this->renderAjax('_form',['model'=>$model,'detailModel'=>$detailModel,
                'detailData'=>$detailData,
            'path'=>$path]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing KegiatanUnit model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($unit, $id)
    {
        $model = $this->findModel($id);
        $detailModel = new KegiatanDetailUploadForm();
        $detailData = $model->kegiatanUnitDetails;
        $path = UnitDirectoryHelper::getUnitUrl($model->id_unit);
        if ($model->load(Yii::$app->request->post()) ) {

            $model->save();
            Yii::$app->session->setFlash('success','Berhasil mengubah KegiatanUnit.');

            return $this->redirect(['view', 'id' => $model->id,'unit'=>$unit]);
        }

        return $this->render('update', [
            'model' => $model,
            'detailModel'=>$detailModel,
            'detailData'=>$detailData,
            'path'=>$path
        ]);
    }

    /**
     * Deletes an existing KegiatanUnit model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id,$unit)
    {
        $model= $this->findModel($id);
        $model->delete();
        Yii::$app->session->setFlash('success','Berhasil menghapus KegiatanUnit.');

        return $this->redirect(['index','unit'=>$unit]);
    }

    public function actionDownloadDetail($dokumen, $unit, $id){
        ini_set('max_execution_time', 5 * 60);
        $model = KegiatanUnitDetail::findOne($dokumen);
        $fileDokumen = UnitDirectoryHelper::getUnitPath($unit). '/'.$model->nama_file;

        return Yii::$app->response->sendFile($fileDokumen);
    }

    public function actionHapusDetail(){
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $dokumenId = $data['dokumen'];
            $unitId = $data['unit'];
            $kegiatanId = $data['id'];

            $model = KegiatanUnitDetail::findOne($dokumenId);
            $nama_file = $model->nama_file;
            if($model->delete()){
                FileHelper::unlink(UnitDirectoryHelper::getUnitPath($unitId).'/'.$nama_file);
            }


            Yii::$app->session->setFlash('success','Berhasil Menghapus dokumen kegiatan');
            return $this->redirect(['kegiatan/update','unit'=>$unitId,'id'=>$kegiatanId]);
        }

        throw new MethodNotAllowedHttpException('Tidak boleh mengakses ini');
    }

    /**
     * Finds the KegiatanUnit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return KegiatanUnit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = KegiatanUnit::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
