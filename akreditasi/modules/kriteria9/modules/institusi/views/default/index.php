<?php

use common\models\FakultasAkademi;

/* @var $modelFakultas FakultasAkademi */
/* @var $modelProfil \common\models\Profil */

$this->title = 'Institusi';
$this->params['breadcrumbs'][] = ['label' => 'Beranda', 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = ['label' => '9 Kriteria', 'url' => ['/kriteria9/default/index']];
$this->params['breadcrumbs'][] = $this->title;

?>


<div class="kt-portlet">
    <div class="kt-space-30"></div>
    <h1 class="text-center"><?= Yii::$app->params['institusi'] ?></h1>

    <div class="kt-portlet__body">

        <div class="row">
            <div class="text-center col-lg-12">
                <img
                    src="<?= common\helpers\kriteria9\K9InstitusiDirectoryHelper::getStrukturUrl() . '/' . $modelProfil->struktur_organisasi ?>"
                    height="480px" width="860px">
            </div>
        </div>
    </div>

</div>

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Profil Institusi
            </h3>
        </div>
    </div>


    <div class="kt-portlet__body">
        <div class="kt-section kt-section--first" style="margin-bottom: 0;">

            <div class="clearfix"></div>
            <h4 class="text-center">Visi</h4>
            <div class="row">
                <div class="col-lg-12">
                    <p class="text-center">Visi dari universitas ini adalah Visi dari universitas ini adalah Visi dari
                        universitas ini adalah Visi dari universitas ini adalah Visi dari universitas ini adalah Visi
                        dari universitas ini adalah Visi dari universitas ini adalah Visi dari universitas ini adalah
                        Visi dari universitas ini adalah Visi dari universitas ini adalah v Visi dari universitas ini
                        adalahVisi dari universitas ini adalahVisi Visi dari universitas ini adalahVisi dari universitas
                        ini adalah v Visi dari universitas ini adalah <?= $modelProfil->visi ?></p>
                </div>
            </div>

            <div class="clearfix"></div>
            <h4 class="text-center">Misi</h4>
            <div class="row">
                <div class="col-lg-12">
                    <p class="text-center">Misi dari universitas ini adalah <?= $modelProfil->misi ?></p>
                </div>
            </div>

            <div class="clearfix"></div>
            <h4 class="text-center">Tujuan</h4>
            <div class="row">
                <div class="col-lg-12">
                    <p class="text-center">Tujuan dari universitas ini adalah <?= $modelProfil->misi ?></p>
                </div>
            </div>

            <div class="clearfix"></div>
            <h4 class="text-center">Sasaran</h4>
            <div class="row">
                <div class="col-lg-12">
                    <p class="text-center">Sasaran dari universitas ini adalah <?= $modelProfil->misi ?></p>
                </div>
            </div>

            <div class="clearfix"></div>
            <h4 class="text-center">Motto</h4>
            <div class="row">
                <div class="col-lg-12">
                    <p class="text-center">Motto dari universitas ini adalah <?= $modelProfil->misi ?></p>
                </div>
            </div>

            <div class="clearfix"></div>
            <h4 class="text-center">Sambutan</h4>
            <div class="row">
                <div class="col-lg-12">
                    <p class="text-center">Sambutan dari universitas ini adalah <?= $modelProfil->misi ?></p>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Profil Fakultas
            </h3>
        </div>
    </div>


    <div class="kt-portlet__body">
        <div class="kt-section kt-section--first" style="margin-bottom: 0;">

            <div class="clearfix"></div>
            <h4>Fakultas</h4>
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th>No.</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Dekan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1;
                            foreach ($modelFakultas as $value): ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $value['kode'] ?></td>
                                    <td><?= $value['nama'] ?></td>
                                    <td><?= $value['dekan'] ?></td>
                                </tr>
                                <?php $i++; endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

