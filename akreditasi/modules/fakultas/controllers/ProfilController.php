<?php


namespace akreditasi\modules\fakultas\controllers;


use akreditasi\models\kriteria9\forms\StrukturOrganisasiUploadForm;
use common\models\FakultasAkademi;
use common\models\Profil;
use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class ProfilController extends BaseController
{

    public function behaviors()
    {
        return[
            'verbs'=>[
                'class'=>'yii\filters\VerbFilter',
                'actions' => [
                    'hapus-struktur'=>['POST']
                ]
            ]
        ];
    }

    public function actionIndex($fakultas)
    {
        $fakultasAkademi = FakultasAkademi::findOne($fakultas);

        return $this->render('index',['fakultasAkademi'=>$fakultasAkademi]);
    }
    public function actionUpdate($fakultas)
    {
        $model = FakultasAkademi::findOne($fakultas);
        $jenis = FakultasAkademi::JENIS;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Berhasil mengubah FakultasAkademi.');

            return $this->redirect(['default/index', 'fakultas' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'jenis' => $jenis
        ]);

    }

    public function actionUpdateProfil($fakultas){
        $model = FakultasAkademi::findOne($fakultas);
        /** @var Profil $profil */
        $profil = $model->profil;
        $strukturModel = new StrukturOrganisasiUploadForm();

        if($profil->load(Yii::$app->request->post()) && $strukturModel->load(Yii::$app->request->post())){

            $strukturModel->struktur = UploadedFile::getInstance($strukturModel,'struktur');
            if(isset($strukturModel->struktur)){
                $save = $strukturModel->upload($profil->type,$model->id);
                if(!$save) throw new \Exception('Error upload data');
                $profil->struktur_organisasi = $save;
            }

            if(!$profil->save(false)) throw new Exception('Gagal mengupdate profil');
            Yii::$app->session->setFlash('success','Berhasil mengupdate profil');
            return $this->redirect(['profil/index','fakultas'=>$model->id]);

        }

        return $this->render('update-profil',compact('model','profil','strukturModel'));
    }

    public function actionHapusStruktur(){

        $nama = Yii::$app->request->post('nama');
        $id = Yii::$app->request->post('id');

        $fakultas = FakultasAkademi::findOne($id);
        $profil = $fakultas->profil;
        FileHelper::unlink(Yii::getAlias("@uploadStruktur/{$profil->type}/$id/$nama"));
        $profil->struktur_organisasi = '';


        return $profil->save(false);
    }
}