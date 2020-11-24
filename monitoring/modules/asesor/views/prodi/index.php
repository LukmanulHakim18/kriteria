<?php
/**
 * @var $this yii\web\View
 * @var $akreditasiProdi common\models\kriteria9\akreditasi\K9AkreditasiProdi
 * @var $prodi common\models\ProgramStudi
 * @var $jsonEksternal common\models\kriteria9\penilaian\Penilaian
 * @var $jsonProfil common\models\kriteria9\penilaian\Penilaian
 * @var $jsonKriteria common\models\kriteria9\penilaian\Penilaian
 * @var $jsonAnalisis common\models\kriteria9\penilaian\Penilaian
 */

$this->title = 'Peniliaian Akreditasi Program Studi';
?>
<div class="kt-portlet">

    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h4 class="kt-port__head-title">
                <?=$this->title?>
            </h4>
        </div>
    </div>
    <div class="kt-portlet__body">

        <div id="accordion" class="accordion accordion-toggle-plus accordion-solid">

            <div class="card">
                <div class="card-header" id="heading-eksternal">
                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapse-eksternal"
                         aria-expanded="false" aria-controls="collapse-eksternal">
                        <div class="row">
                            <div class="col-lg-12">
                                <i class="flaticon-file-2"></i> <?=
                               $jsonEksternal->nomor ?>&nbsp;
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <small>&nbsp;<?= $jsonEksternal->judul ?></small>

                            </div>
                        </div>
                    </div>
                </div>
                <div id="collapse-eksternal" class="collapse" aria-labelledby="heading-eksternal">
                    <div class="card-body">
                        <div class="kt-spinner kt-spinner--center kt-spinner--primary kt-spinner--v2" id="spinner-eksternal"></div>
                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading-profil">
                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapse-profil"
                         aria-expanded="false" aria-controls="collapse-profil">
                        <div class="row">
                            <div class="col-lg-12">
                                <i class="flaticon-file-2"></i> <?=
                                $jsonProfil->nomor ?>&nbsp;
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <small>&nbsp;<?= $jsonProfil->judul ?></small>

                            </div>
                        </div>
                    </div>
                </div>
                <div id="collapse-profil" class="collapse" aria-labelledby="heading-profil">
                    <div class="card-body">
                        <div class="kt-spinner kt-spinner--center kt-spinner--primary kt-spinner--v2" id="spinner-eksternal"></div>
                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading-kriteria">
                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapse-kriteria"
                         aria-expanded="false" aria-controls="collapse-kriteria">
                        <div class="row">
                            <div class="col-lg-12">
                                <i class="flaticon-file-2"></i> <?=
                                $jsonKriteria->nomor ?>&nbsp;
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <small>&nbsp;<?= $jsonKriteria->judul ?></small>

                            </div>
                        </div>
                    </div>
                </div>
                <div id="collapse-kriteria" class="collapse" aria-labelledby="heading-kriteria">
                    <div class="card-body">
                        <div class="kt-spinner kt-spinner--center kt-spinner--primary kt-spinner--v2" id="spinner-eksternal"></div>
                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading-analisis">
                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapse-analisis"
                         aria-expanded="false" aria-controls="collapse-analisis">
                        <div class="row">
                            <div class="col-lg-12">
                                <i class="flaticon-file-2"></i> <?=
                                $jsonAnalisis->nomor ?>&nbsp;
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <small>&nbsp;<?= $jsonAnalisis->judul ?></small>

                            </div>
                        </div>
                    </div>
                </div>
                <div id="collapse-analisis" class="collapse" aria-labelledby="heading-analisis">
                    <div class="card-body">
                        <div class="kt-spinner kt-spinner--center kt-spinner--primary kt-spinner--v2" id="spinner-eksternal"></div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
