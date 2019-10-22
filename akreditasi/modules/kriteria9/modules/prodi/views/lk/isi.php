<?php

use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria6;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria7;
use common\models\kriteria9\lk\prodi\K9LkProdi;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria1;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria2;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria3;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria4;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria5;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria6;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria7;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria8;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria9;
use yii\bootstrap4\Html;
use yii\bootstrap4\Progress;

/* @var $lkInstitusi K9LkProdi */
/* @var $kriteria1 K9LkProdiKriteria1 */
/* @var $kriteria2 K9LkProdiKriteria2 */
/* @var $kriteria3 K9LkProdiKriteria3 */
/* @var $kriteria4 K9LkProdiKriteria4 */
/* @var $kriteria5 K9LkProdiKriteria5 */
/* @var $kriteria6 K9LkProdiKriteria6 */
/* @var $kriteria7 K9LkProdiKriteria7 */
/* @var $kriteria8 K9LkProdiKriteria8 */
/* @var $decode */
/* @var $institusi */

$this->title = "Isi Laporan Kinerja";
$this->params['breadcrumbs'][] = ['label' => 'Beranda', 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = ['label' => '9 Kriteria', 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = ['label' => 'Prodi', 'url' => ['/site/index']];
//$this->params['breadcrumbs'][] = ['label'=>'Data Program Studi','url'=>['/standar7/s7-prodi/default']];
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
                    <td>Akreditasi Program Studi</td>
                </tr>
                <tr>
                    <th scope="row">Nama Institusi</th>
                    <td><?= Html::encode($institusi) ?></td>
                </tr>
                <tr>
                    <th scope="row">Nama Fakultas</th>
                    <td><?= Html::encode($lkInstitusi->akreditasiProdi->prodi->fakultasAkademi->nama) ?></td>
                </tr>
                <tr>
                    <th scope="row">Nama Program Studi</th>
                    <td><?= Html::encode($lkInstitusi->akreditasiProdi->prodi->nama) ?></td>
                </tr>
                <tr>
                    <td><strong>Lembaga Akreditasi</strong></td>
                    <td><?= Html::encode($lkInstitusi->akreditasiProdi->akreditasi->lembaga) ?></td>
                </tr>
                <tr>
                    <td><strong>Versi Akreditasi</strong></td>
                    <td><?= Html::encode($lkInstitusi->akreditasiProdi->akreditasi->nama) ?></td>
                </tr>
                <tr>
                    <td><strong>Jenis Akreditasi</strong></td>
                    <td><?= Html::encode($lkInstitusi->akreditasiProdi->akreditasi->jenis_akreditasi) ?></td>
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
                <tr>
                    <th scope="row">1</th>
                    <td>
                        <strong>Tabel &nbsp;1 : <?= $kriteria1->progress ?>%</strong><br>
                        <?= $decode[0]['judul'] ?>
                        <div class="kt-space-10"></div>
                        <?=
                        Progress::widget([
                            'percent' => $kriteria1->progress,
                            'barOptions' => ['class' => 'progress-bar-info'],
                            'options' => ['class' => 'progress-sm']
                        ]); ?>
                    </td>
                    <td style="padding-top: 15px;">
                        <?= Html::a("<i class='la la-folder-open'></i>Lihat", ['lk/isi-kriteria', 'kriteria' => 1, 'lk' => $lkInstitusi->id, 'prodi' => $_GET['prodi']], ['class' => 'btn btn-default btn-pill btn-elevate btn-elevate-air']) ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>
                        <strong>Kriteria &nbsp;2 : <?= $kriteria2->progress ?>%</strong><br>
                        <?= $decode[1]['judul'] ?>
                        <div class="kt-space-10"></div>
                        <?=
                        Progress::widget([
                            'percent' => $kriteria2->progress,
                            'barOptions' => ['class' => 'progress-bar-info'],
                            'options' => ['class' => 'progress-sm']
                        ]); ?>
                    </td>
                    <td style="padding-top: 15px;">
                        <?= Html::a("<i class='la la-folder-open'></i>Lihat", ['lk/isi-kriteria', 'kriteria' => 2, 'lk' => $lkInstitusi->id, 'prodi' => $_GET['prodi']], ['class' => 'btn btn-default btn-pill btn-elevate btn-elevate-air']) ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>
                        <strong>Kriteria &nbsp;3 : <?= $kriteria3->progress ?>%</strong><br>
                        <?= $decode[2]['judul'] ?>
                        <div class="kt-space-10"></div>
                        <?=
                        Progress::widget([
                            'percent' => $kriteria3->progress,
                            'barOptions' => ['class' => 'progress-bar-info'],
                            'options' => ['class' => 'progress-sm']
                        ]); ?>
                    </td>
                    <td style="padding-top: 15px;">
                        <?= Html::a("<i class='la la-folder-open'></i>Lihat", ['lk/isi-kriteria', 'kriteria' => 3, 'lk' => $lkInstitusi->id, 'prodi' => $_GET['prodi']], ['class' => 'btn btn-default btn-pill btn-elevate btn-elevate-air']) ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">4</th>
                    <td>
                        <strong>Kriteria &nbsp;4 : <?= $kriteria4->progress ?>%</strong><br>
                        <?= $decode[3]['judul'] ?>
                        <div class="kt-space-10"></div>
                        <?=
                        Progress::widget([
                            'percent' => $kriteria4->progress,
                            'barOptions' => ['class' => 'progress-bar-info'],
                            'options' => ['class' => 'progress-sm']
                        ]); ?>
                    </td>
                    <td style="padding-top: 15px;">
                        <?= Html::a("<i class='la la-folder-open'></i>Lihat", ['lk/isi-kriteria', 'kriteria' => 4, 'lk' => $lkInstitusi->id, 'prodi' => $_GET['prodi']], ['class' => 'btn btn-default btn-pill btn-elevate btn-elevate-air']) ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">5</th>
                    <td>
                        <strong>Kriteria &nbsp;5 : <?= $kriteria5->progress ?>%</strong><br>
                        <?= $decode[4]['judul'] ?>
                        <div class="kt-space-10"></div>
                        <?=
                        Progress::widget([
                            'percent' => $kriteria5->progress,
                            'barOptions' => ['class' => 'progress-bar-info'],
                            'options' => ['class' => 'progress-sm']
                        ]); ?>
                    </td>
                    <td style="padding-top: 15px;">
                        <?= Html::a("<i class='la la-folder-open'></i>Lihat", ['lk/isi-kriteria', 'kriteria' => 5, 'lk' => $lkInstitusi->id, 'prodi' => $_GET['prodi']], ['class' => 'btn btn-default btn-pill btn-elevate btn-elevate-air']) ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">5</th>
                    <td>
                        <strong>Kriteria &nbsp;6 : <?= $kriteria6->progress ?>%</strong><br>
                        <?= $decode[5]['judul'] ?>
                        <div class="kt-space-10"></div>
                        <?=
                        Progress::widget([
                            'percent' => $kriteria6->progress,
                            'barOptions' => ['class' => 'progress-bar-info'],
                            'options' => ['class' => 'progress-sm']
                        ]); ?>
                    </td>
                    <td style="padding-top: 15px;">
                        <?= Html::a("<i class='la la-folder-open'></i>Lihat", ['lk/isi-kriteria', 'kriteria' => 6, 'lk' => $lkInstitusi->id, 'prodi' => $_GET['prodi']], ['class' => 'btn btn-default btn-pill btn-elevate btn-elevate-air']) ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">5</th>
                    <td>
                        <strong>Kriteria &nbsp;7 : <?= $kriteria7->progress ?>%</strong><br>
                        <?= $decode[6]['judul'] ?>
                        <div class="kt-space-10"></div>
                        <?=
                        Progress::widget([
                            'percent' => $kriteria7->progress,
                            'barOptions' => ['class' => 'progress-bar-info'],
                            'options' => ['class' => 'progress-sm']
                        ]); ?>
                    </td>
                    <td style="padding-top: 15px;">
                        <?= Html::a("<i class='la la-folder-open'></i>Lihat", ['lk/isi-kriteria', 'kriteria' => 7, 'lk' => $lkInstitusi->id, 'prodi' => $_GET['prodi']], ['class' => 'btn btn-default btn-pill btn-elevate btn-elevate-air']) ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">5</th>
                    <td>
                        <strong>Kriteria &nbsp;8 : <?= $kriteria8->progress ?>%</strong><br>
                        <?= $decode[7]['judul'] ?>
                        <div class="kt-space-10"></div>
                        <?=
                        Progress::widget([
                            'percent' => $kriteria8->progress,
                            'barOptions' => ['class' => 'progress-bar-info'],
                            'options' => ['class' => 'progress-sm']
                        ]); ?>
                    </td>
                    <td style="padding-top: 15px;">
                        <?= Html::a("<i class='la la-folder-open'></i>Lihat", ['lk/isi-kriteria', 'kriteria' => 8, 'lk' => $lkInstitusi->id, 'prodi' => $_GET['prodi']], ['class' => 'btn btn-default btn-pill btn-elevate btn-elevate-air']) ?>
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>
