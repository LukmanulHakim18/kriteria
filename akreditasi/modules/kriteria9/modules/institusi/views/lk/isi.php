<?php

use common\models\kriteria9\lk\institusi\K9LkInstitusi;
use yii\bootstrap4\Html;
use yii\bootstrap4\Progress;

/* @var $lkInstitusi K9LkInstitusi */
/* @var $kriteria1 [] */
/* @var $kriteria */
/* @var $institusi */

$this->title = "Isi Laporan Kinerja";
$this->params['breadcrumbs'][] = ['label' => 'Beranda', 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = ['label' => '9 Kriteria', 'url' => ['/k9/index']];
$this->params['breadcrumbs'][] = ['label' => 'Institusi', 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Form Laporan Kinerja Institusi
            </h3>
        </div>
    </div>

    <div class="kt-portlet__body">
        <div class="kt-section kt-section--first" style="margin-bottom: 0;">

            <table class="table table-striped">

                <tbody>
                <tr>
                    <th scope="row">Laporan Kinerja</th>
                    <td>Akreditasi Institusi</td>
                </tr>
                <tr>
                    <th scope="row">Nama Institusi</th>
                    <td><?= Html::encode($institusi) ?></td>
                </tr>
                <tr>
                    <td><strong>Lembaga Akreditasi</strong></td>
                    <td><?= Html::encode($lkInstitusi->akreditasiInstitusi->akreditasi->lembaga) ?></td>
                </tr>
                <tr>
                    <td><strong>Versi Akreditasi</strong></td>
                    <td><?= Html::encode($lkInstitusi->akreditasiInstitusi->akreditasi->nama) ?></td>
                </tr>
                <tr>
                    <td><strong>Jenis Akreditasi</strong></td>
                    <td><?= Html::encode($lkInstitusi->akreditasiInstitusi->akreditasi->jenis_akreditasi) ?></td>
                </tr>
                <tr>
                    <th scope="row">Keterangan</th>
                    <td>
                        -
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Isi Laporan Kinerja
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-actions">
                <strong>Kelengkapan Berkas &nbsp; : <?= Html::encode($lkInstitusi->progress) ?> %</strong>
                <div class="kt-space-10"></div>
                <?=
                Progress::widget([
                    'percent' => $lkInstitusi->progress,
                    'barOptions' => ['class' => 'progress-bar-info'],
                    'options' => ['class' => 'progress-sm']
                ]); ?>
            </div>
        </div>
    </div>

    <div class="kt-portlet__body">
        <div class="kt-section kt-section--first" style="margin-bottom: 0;">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th>No.</th>
                    <th>Kriteria Akreditasi</th>
                    <th style="width: 110px"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($json as $kriteriaJson): ?>
                    <tr>
                        <th scope="row"><?= Html::encode($kriteriaJson['kriteria']) ?></th>
                        <td>
                            <strong>Tabel <?= Html::encode($kriteriaJson['kriteria']) ?>
                                : <?= $kriteria[$kriteriaJson['kriteria'] - 1]->progress ?>%</strong><br>
                            <?= $kriteriaJson['judul'] ?>
                            <div class="kt-space-10"></div>
                            <?=
                            Progress::widget([
                                'percent' => $kriteria[$kriteriaJson['kriteria'] - 1]->progress,
                                'barOptions' => ['class' => 'progress-bar-info m-progress-lg'],
                                'options' => ['class' => 'progress-sm']
                            ]); ?>
                        </td>
                        <td style="padding-top: 15px;">
                            <?= Html::a("<i class='la la-folder-open'></i>Lihat", ['lk/isi-kriteria', 'lk' => $_GET['lk'], 'kriteria' => $kriteriaJson['kriteria']], ['class' => 'btn btn-default btn-pill btn-elevate btn-elevate-air']) ?>

                            <!--                        <button type="button" class="btn btn-danger">Lihat</button>-->
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
