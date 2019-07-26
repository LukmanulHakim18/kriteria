<?php

namespace admin\controllers;

use common\models\FakultasAkademi;
use common\models\forms\user\CreateUserForm;
use common\models\forms\user\UpdateUserForm;
use common\models\forms\user\UserPasswordForm;
use common\models\ProgramStudi;
use Yii;
use yii\base\InvalidArgumentException;
use yii\filters\AccessControl;
use common\models\User;
use admin\models\UserSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CreateUserForm();
        $available_role = Yii::$app->authManager->getRoles();

        $forbidden_roles = ['superadmin'];

        $roles = array_keys($available_role);

        foreach ($forbidden_roles as $role){
            $pos = array_search($role, $roles);
            ArrayHelper::remove($roles,$pos);
        }

        $dataRoles = array_combine($roles, $roles);

        $fakultas = FakultasAkademi::find()->all();
        $dataFakultas = ArrayHelper::map($fakultas,'id','nama');

        if ($model->load(Yii::$app->request->post()) ) {

            if($model->validate()){

                $user = $model->addUser();
                if($user === null){
                    throw new InvalidArgumentException('Gagal membuat user');

                }
                Yii::$app->session->setFlash('success','Berhasil menambahkan User.');

                return $this->redirect(['user/index']);

            }

            throw new InvalidArgumentException('Gagal membuat user, Validasi data gagal');

        }
        elseif (Yii::$app->request->isAjax){

            return $this->renderAjax('_create_user_form',[ 'model' => $model,
                'dataFakultas'=>$dataFakultas, 'dataRoles'=>$dataRoles]);
        }

        return $this->render('create_user_form', [
            'model' => $model,
            'dataFakultas'=>$dataFakultas,
            'dataRoles'=>$dataRoles
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = new UpdateUserForm($id);
        $modelPassword = new UserPasswordForm($id);
        $fakultas = FakultasAkademi::find()->all();
        $dataFakultas = ArrayHelper::map($fakultas,'id','nama');
        $available_role = Yii::$app->authManager->getRoles();

        $forbidden_roles = ['superadmin'];

        $roles = array_keys($available_role);

        foreach ($forbidden_roles as $role){
            $pos = array_search($role, $roles);
            ArrayHelper::remove($roles,$pos);
        }

        $dataRoles = array_combine($roles, $roles);

        if ($model->load(Yii::$app->request->post()) ) {
            if(!$model->validate()){
                throw new InvalidArgumentException('Gagal Validasi user');
            }
            $model->updateUser();
            if($model === false){
                throw new InvalidArgumentException('Gagal memperbarui user, terdapat error');

            }

            Yii::$app->session->setFlash('success','Berhasil Memperbarui User');

            return $this->redirect(['view', 'id' => $model->getUser()->id]);
        }
        if($modelPassword->load(Yii::$app->request->post())){

            if($modelPassword->validate()){
                $modelPassword->updatePassword();
                if(!$modelPassword){
                    throw new InvalidArgumentException('Gagal Mengganti Password');
                }
                Yii::$app->session->setFlash('success','Berhasil Mengganti Password');
                return $this->redirect(['view', 'id' => $model->getUser()->id]);
            }

        }

        return $this->render('update_user_form', [
            'model' => $model,
            'modelPassword'=>$modelPassword,
            'dataFakultas'=>$dataFakultas,
            'dataRoles'=>$dataRoles
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->session->setFlash('success','Berhasil menghapus User.');

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetFakultas(){
        $fakultas = FakultasAkademi::find()->all();
        return ArrayHelper::map($fakultas,'id','nama');
    }

    public function actionGetProdi(){

        $this->enableCsrfValidation = false;
        $arrayProdi = [];

        if(isset($_POST['depdrop_parents'])){
            $parent = $_POST['depdrop_parents'];
            if($parent!==null){
                $id = $parent[0];
                $dataProdi = ProgramStudi::findAll(['id_fakultas_akademi'=>$id]);
                foreach ($dataProdi as $data){
                    $id = $data->id;
                    $nama = $data->nama . '('.$data->jenjang.')';
                    $newArray = ['id'=>$id,'name'=>$nama];
                    $arrayProdi[] = $newArray;
                }

                echo Json::encode(['output'=>$arrayProdi, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
    public function beforeAction($action)
    {
        if ($this->action->id === 'get-prodi') {
            $this->enableCsrfValidation = false;
        }
        return true;
    }
}