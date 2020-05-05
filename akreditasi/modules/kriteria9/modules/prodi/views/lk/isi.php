<?php

use common\models\kriteria9\lk\prodi\K9LkProdi;
use yii\bootstrap4\Html;
use yii\bootstrap4\Progress;

/* @var $lkProdi K9LkProdi */
/* @var $kriteria1 [] */
/* @var $kriteria */
/* @var $institusi */

$prodi = Yii::$app->request->get('prodi');
$this->title = "Isi Laporan Kinerja";
$this->params['breadcrumbs'][] = ['label' => 'Beranda', 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = ['label' => '9 Kriteria', 'url' => ['/kriteria9/default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Prodi', 'url' => ['/kriteria9/k9-prodi/default/index', 'prodi' => $prodi]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Form Laporan Kinerja Program Studi
            </h3>
        </div>
    </div>

    <div class="kt-portlet__body">
        <div class="kt-section kt-section--first" style="margin-bottom: 0;">

            <table class="table table-striped">

                <tbody>
                <tr>
                    <th scope="row">Laporan Kinerja</th>
                    <td>Akreditasi Program Studi</td>
                </tr>
                <tr>
                    <th scope="row">Nama Institusi</th>
                    <td><?= Html::encode($institusi) ?></td>
                </tr>
                <tr>
                    <th scope="row">Nama Fakultas</th>
                    <td><?= Html::encode($lkProdi->akreditasiProdi->prodi->fakultasAkademi->nama) ?></td>
                </tr>
                <tr>
                    <th scope="row">Nama Program Studi</th>
                    <td><?= Html::encode($lkProdi->akreditasiProdi->prodi->nama) ?></td>
                </tr>
                <tr>
                    <td><strong>Lembaga Akreditasi</strong></td>
                    <td><?= Html::encode($lkProdi->akreditasiProdi->akreditasi->lembaga) ?></td>
                </tr>
                <tr>
                    <td><strong>Versi Akreditasi</strong></td>
                    <td><?= Html::encode($lkProdi->akreditasiProdi->akreditasi->nama) ?></td>
                </tr>
                <tr>
                    <td><strong>Jenis Akreditasi</strong></td>
                    <td><?= Html::encode($lkProdi->akreditasiProdi->akreditasi->jenis_akreditasi) ?></td>
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
                <strong>Kelengkapan Berkas &nbsp; : <?= Html::encode($lkProdi->progress) ?> %</strong>
                <div class="kt-space-10"></div>
                <?=
                Progress::widget([
                    'percent' => $lkProdi->progress,
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
                            <?= Html::a("<i class='la la-folder-open'></i>Lihat", ['lk/isi-kriteria', 'lk' => $_GET['lk'], 'kriteria' => $kriteriaJson['kriteria'], 'prodi' => $prodi], ['class' => 'btn btn-default btn-pill btn-elevate btn-elevate-air']) ?>

                            <!--                        <button type="button" class="btn btn-danger">Lihat</button>-->
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
