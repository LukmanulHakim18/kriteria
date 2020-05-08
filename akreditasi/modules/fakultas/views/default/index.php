<?php

/* @var $fakultas FakultasAkademi */
/* @var $profil common\models\Profil */
/* @var $prodis \common\models\ProgramStudi[] */

use common\models\FakultasAkademi;
use common\models\ProgramStudi;
use yii\bootstrap4\Html;

$this->title = $fakultas->nama;


?>
<div class="row">
    <div class="col-lg-12">
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Profil Fakultas/Akademi/Pascasarjana
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">

                            <?= Html::a('<i class=flaticon2-edit></i> Edit', ['profil/index', 'fakultas' => Yii::$app->request->get('fakultas')], ['class' => 'btn btn-info btn-elevate btn-elevate-air']); ?>
                        </div>
                    </div>
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
                                                    <?=$profil->visi?>
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
                                                    <?=$profil->misi?>
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
                                                    <?=$profil->tujuan?>
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
                                                    <?=$profil->sasaran?>
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
                                                    <?=$profil->motto?>
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
                                                    <?=$profil->sambutan?>
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
                                                <?php if($profil->struktur_organisasi):?>
                                                    <?=Html::img(Yii::getAlias("@.uploadStruktur/{$profil->type}/{$fakultas->id}/{$profil->struktur_organisasi}"),['width'=>'80%'])?>
                                                <?php endif;?>
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
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Program Studi dari <?=$fakultas->nama?>
                    </h3>
                </div>
            </div>

            <div class="kt-portlet__body">

                <div class="kt-section kt-section--first" style="margin-bottom: 0;">
                    <div class="accordion accordion-solid accordion-toggle-plus" id="prodiFakultas">
                        <?php foreach ($prodis as /** @var $prodi ProgramStudi */$prodi) :?>
                        <div class="card">
                            <div class="card-header" id="headingProdi<?=$prodi->id?>">
                                <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseProdi<?=$prodi->id?>" aria-expanded="false" aria-controls="collapseProdi<?=$prodi->id?>">
                                   <?=$prodi->nama?>
                                </div>
                            </div>
                            <div id="collapseProdi<?=$prodi->id?>" class="collapse" aria-labelledby="headingProdi<?=$prodi->id?>" data-parent="#prodiFakultas" style="">
                                <div class="card-body">
                                   <?=\yii\widgets\DetailView::widget([
                                           'model' => $prodi,
                                       'attributes' => [
                                               'nama',
                                           'jenjang',
                                           'kaprodi',
                                           'profil.visi:html',
                                           'profil.misi:html',
                                           'profil.tujuan:html',
                                           'profil.sasaran:html',
                                           'profil.sambutan:html',
                                           'profil.motto:html',
                                           ['attribute'=>'profil.struktur_organisasi',
                                               'format'=>['image',['width'=>'80%']],
                                           'value'=>function($model){
                                            return isset($model->profil->struktur_organisasi)?(Yii::getAlias("@.uploadStruktur/{$model->profil->type}/{$model->id}/{$model->profil->struktur_organisasi}")):$model->profil->struktur_organisasi;
                                           }
],
                                       ]
                                   ])?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

