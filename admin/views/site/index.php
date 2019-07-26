<?php

/* @var $this yii\web\View */
/* @var $jumlahProdi integer */
/* @var $jumlahPengguna integer */
/* @var $apt integer */
/* @var $aps integer */
/* @var $persenAps float */
/* @var $persenApt float */

$this->title = 'Beranda';
$this->params['breadcrumbs'][] = $this->title;

?>
<!--Begin::Section-->
<div class="kt-portlet">
    <div class="kt-portlet__body  kt-portlet__body--fit">
        <div class="row row-no-padding row-col-separator-xl">
            <div class="col-md-12 col-lg-6 col-xl-3">

                <!--begin::Total Profit-->
                <div class="kt-widget24">
                    <div class="kt-widget24__details">
                        <div class="kt-widget24__info">
                            <h4 class="kt-widget24__title">
                                Program Studi
                            </h4>
                            <span class="kt-widget24__desc">Jumlah Program Studi</span>
                        </div>
                        <span class="kt-widget24__stats kt-font-brand">
                            <span class="counter"><?=$jumlahProdi ?></span>
                        </span>
                    </div>
                </div>

                <!--end::Total Profit-->
            </div>
            <div class="col-md-12 col-lg-6 col-xl-3">

                <!--begin::New Feedbacks-->
                <div class="kt-widget24">
                    <div class="kt-widget24__details">
                        <div class="kt-widget24__info">
                            <h4 class="kt-widget24__title">
                                Pengguna
                            </h4>
                            <span class="kt-widget24__desc">Jumlah Akun Pengguna</span>
                        </div>
                        <span class="kt-widget24__stats kt-font-warning"><span class="counter"><?= $jumlahPengguna ?></span></span>
                    </div>
                </div>

                <!--end::New Feedbacks-->
            </div>
            <div class="col-md-12 col-lg-6 col-xl-3">

                <!--begin::New Orders-->
                <div class="kt-widget24">
                    <div class="kt-widget24__details">
                        <div class="kt-widget24__info">
                            <h4 class="kt-widget24__title">Akreditasi Prodi</h4>
                            <span class="kt-widget24__desc">Akreditasi Program Studi Tahun <?=date('Y')?></span>
                        </div>
                        <span class="kt-widget24__stats kt-font-danger"><span class="counter"><?=$aps?></span></span>
                    </div>
                    <?=\yii\bootstrap4\Progress::widget([
                            'barOptions' => ['class'=>'progress-bar progress-bar-striped progress-bar-animated kt-bg-danger'],
                        'percent' => $persenAps
                    ])?>

                </div>

                <!--end::New Orders-->
            </div>
            <div class="col-md-12 col-lg-6 col-xl-3">

                <!--begin::New Users-->
                <div class="kt-widget24">
                    <div class="kt-widget24__details">
                        <div class="kt-widget24__info">
                            <h4 class="kt-widget24__title">
                                Akreditasi Perguruan Tinggi
                            </h4>
                            <span class="kt-widget24__desc">Akreditasi Insitusi Perguruan Tinggi Tahun <?=date('Y')?></span>
                        </div>
                        <span class="kt-widget24__stats kt-font-success"><span class="counter"><?=$apt?></span></span>
                    </div>
                    <?=\yii\bootstrap4\Progress::widget([
                            'barOptions' => ['class'=>'progress-bar progress-bar-striped progress-bar-animated kt-bg-success'],
                        'percent' => $persenApt
                    ])?>

                </div>

                <!--end::New Users-->
            </div>
        </div>
    </div>
</div>

<!--End::Section-->
<div class="row">
    <div class="col-lg-12">
        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
												<span class="kt-portlet__head-icon">
													<i class="flaticon2-graph-1"></i>
												</span>
                    <h3 class="kt-portlet__head-title">
                        Selamat Datang
                        <small>di Dashboard Admin</small>
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
                scrambled. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
                type and scrambled.
            </div>
        </div>

        <!--end::Portlet-->
    </div>
</div>



