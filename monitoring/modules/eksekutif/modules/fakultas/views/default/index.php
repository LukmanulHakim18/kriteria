<?php
/**
 * @var $this yii\web\View
 * @var $prodis common\models\ProgramStudi[]
 * @var $model common\models\FakultasAkademi
 * @var $profil common\models\Profil
 * @var $akreditasiTerakhir common\models\kriteria9\akreditasi\K9Akreditasi
 */

use common\models\FakultasAkademi;
use yii\bootstrap4\Html;

$this->title = 'Akreditasi Program Studi';
$this->params['breadcrumbs'] = ['label' => $this->title];

echo $this->render('//common/_fakultas_progress', ['akreditasiTerakhir'=>$akreditasiTerakhir,'model'=>$model]);

?>

<?php
//foreach ($prodis as $prodi):
//    echo $this->render('@monitoring/views/common/_prodi_progress', [
//        'prodi' => $prodi,
//        'model' => $prodi->getK9AkreditasiProdis()->orderBy('id DESC')->one(),
//        'jenis' => FakultasAkademi::FAKULTAS_AKADEMI
//    ])
//    ?>
<?php //endforeach; ?>
<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Profil Fakultas Akademi
            </h3>
        </div>
    </div>

    <div class="kt-portlet__body">

        <div class="kt-section kt-section--first" style="margin-bottom: 0;">

            <div class="row">
                <div class="col-lg-12">
                    <h3>Profil</h3>
                    <div class="profil">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Visi</h5>
                                        <p class="card-text">
                                            <?= $profil->visi ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Misi</h5>
                                        <p class="card-text">
                                            <?= $profil->misi ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Tujuan</h5>
                                        <p class="card-text">
                                            <?= $profil->tujuan ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Sasaran</h5>
                                        <p class="card-text">
                                            <?= $profil->sasaran ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Motto</h5>
                                        <p class="card-text">
                                            <?= $profil->motto ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Sambutan</h5>
                                        <p class="card-text">
                                            <?= $profil->sambutan ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Struktur Organisasi</h5>
                                        <?php if ($profil->struktur_organisasi): ?>
                                            <?= Html::img(
                                                Yii::getAlias("@.uploadStruktur/{$profil->type}/{$model->id}/{$profil->struktur_organisasi}"),
                                                ['width' => '80%']
                                            ) ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
