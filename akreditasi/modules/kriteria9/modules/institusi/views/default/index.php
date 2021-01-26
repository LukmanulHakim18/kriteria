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

        <div class="text-center" style="margin-top: 10px">
            <img
                src="<?= \common\helpers\kriteria9\K9InstitusiDirectoryHelper::getStrukturUrl() . '/' . $modelProfil->struktur_organisasi ?>"
                alt="Gambar Struktur Organisasi Institusi Perguruan Tinggi"/>
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

<div class="kt-portlet ">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Light Style With Icons
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">

        <!--begin::Accordion-->
        <div class="accordion accordion-light  accordion-toggle-arrow" id="accordionExample5">
            <div class="card">
                <div class="card-header" id="headingOne5">
                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseOne5"
                         aria-expanded="false" aria-controls="collapseOne5">
                        <i class="flaticon-pie-chart-1"></i> Product Inventory
                    </div>
                </div>
                <div id="collapseOne5" class="collapse" aria-labelledby="headingOne5" data-parent="#accordionExample5"
                     style="">
                    <div class="card-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                        3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                        laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin
                        coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes
                        anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings
                        occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard
                        of them accusamus labore sustainable VHS.
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingTwo5">
                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseTwo5"
                         aria-expanded="false" aria-controls="collapseTwo5">
                        <i class="flaticon2-notification"></i> Order Statistics
                    </div>
                </div>
                <div id="collapseTwo5" class="collapse" aria-labelledby="headingTwo5" data-parent="#accordionExample5">
                    <div class="card-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                        3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                        laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin
                        coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes
                        anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings
                        occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard
                        of them accusamus labore sustainable VHS.
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingThree5">
                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseThree5"
                         aria-expanded="false" aria-controls="collapseThree5">
                        <i class="flaticon2-chart"></i> eCommerce Reports
                    </div>
                </div>
                <div id="collapseThree5" class="collapse" aria-labelledby="headingThree5"
                     data-parent="#accordionExample5">
                    <div class="card-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                        3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                        laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin
                        coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes
                        anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings
                        occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard
                        of them accusamus labore sustainable VHS.
                    </div>
                </div>
            </div>
        </div>

        <!--end::Accordion-->
    </div>
</div>
