<?php

namespace admin\controllers;

use common\models\Profil;
use common\models\StrukturOrganisasi;
use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;
use common\models\FakultasAkademi;
use admin\models\FakultasAkademiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FakultasAkademiController implements the CRUD actions for FakultasAkademi model.
 */
class FakultasAkademiController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access'=>[
                'class'=>AccessControl::className(),
                'rules'=>[
                    ['actions'=>['index','create','update','view','delete'],
                     'allow'=>true,
                     'roles'=>['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all FakultasAkademi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FakultasAkademiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FakultasAkademi model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new FakultasAkademi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FakultasAkademi();
        $jenis = FakultasAkademi::JENIS;

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $model->save();
                $profil = new Profil();
                $profil->external_id = $model->id;
                $profil->type = FakultasAkademi::FAKULTAS_AKADEMI;
                $profil->save(false);
                $transaction->commit();
                Yii::$app->session->setFlash('success','Berhasil menambahkan Fakultas.');

                return $this->redirect(['view', 'id' => $model->id]);
            }catch (Exception $e){
                $transaction->rollBack();
                throw $e;
            }

        }
        elseif (Yii::$app->request->isAjax){
            return $this->renderAjax('_form',['model'=>$model,'jenis'=>$jenis]);
        }

        return $this->render('create', [
            'model' => $model,
            'jenis'=>$jenis
        ]);
    }

    /**
     * Updates an existing FakultasAkademi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $jenis = FakultasAkademi::JENIS;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success','Berhasil mengubah Fakultas.');

            return $this->redirect(['view', 'id' => $model->id]);
        }


        return $this->render('update', [
            'model' => $model,
            'jenis'=>$jenis
        ]);
    }

    /**
     * Deletes an existing FakultasAkademi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->session->setFlash('success','Berhasil menghapus Fakultas.');

        return $this->redirect(['index']);
    }

    /**
     * Finds the FakultasAkademi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FakultasAkademi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FakultasAkademi::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
