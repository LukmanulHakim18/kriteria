<?php

use common\models\kriteria9\lk\institusi\K9LkInstitusi;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria1;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria2;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria3;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria4;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria5;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria6;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria7;
use yii\bootstrap4\Html;
use yii\bootstrap4\Progress;

/* @var $lkInstitusi K9LkInstitusi */
/* @var $kriteria1 K9LkInstitusiKriteria1 */
/* @var $kriteria2 K9LkInstitusiKriteria2 */
/* @var $kriteria3 K9LkInstitusiKriteria3 */
/* @var $kriteria4 K9LkInstitusiKriteria4 */
/* @var $kriteria5 K9LkInstitusiKriteria5 */
/* @var $kriteria6 K9LkInstitusiKriteria6 */
/* @var $kriteria7 K9LkInstitusiKriteria7 */
/* @var $json */
/* @var $cari */
/* @var $progressDok */
/* @var $progress1 */
/* @var $progress2 */
/* @var $progress3 */
/* @var $progress4 */
/* @var $progress5 */
/* @var $progress6 */
/* @var $progress7 */
/* @var $institusi */

$this->title = "Isi Laporan Kinerja";
$this->params['breadcrumbs'][] = ['label'=>'Beranda','url'=>['/site/index']];
$this->params['breadcrumbs'][] = ['label'=>'9 Kriteria','url'=>['/site/index']];
$this->params['breadcrumbs'][] = ['label'=>'Institusi','url'=>['/site/index']];
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
                    <td>Akreditasi Institusi</td>
                </tr>
                <tr>
                    <th scope="row">Nama Institusi</th>
                    <td><?= Html::encode($institusi) ?></td>
                </tr>
                <tr>
                    <td><strong>Lembaga Akreditasi</strong></td>
                    <td><?=Html::encode($lkInstitusi->akreditasiInstitusi->akreditasi->lembaga)?></td>
                </tr>
                <tr>
                    <td><strong>Versi Akreditasi</strong></td>
                    <td><?=Html::encode($lkInstitusi->akreditasiInstitusi->akreditasi->nama)?></td>
                </tr>
                <tr>
                    <td><strong>Jenis Akreditasi</strong></td>
                    <td><?=Html::encode($lkInstitusi->akreditasiInstitusi->akreditasi->jenis_akreditasi)?></td>
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
                <strong>Kelengkapan Berkas &nbsp; : <?=Html::encode($lkInstitusi->progress)?> %</strong>
                <div class="kt-space-10"></div>
                <?=
                Progress::widget([
                    'percent' => $lkInstitusi->progress,
                    'barOptions' => ['class' => 'progress-bar-info'],
                    'options' => ['class' => 'progress-sm']
                ]);?>
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
                        <strong>Kriteria  &nbsp;1 : <?= $kriteria1->progress ?>%</strong><br>
                        Tata Pamong, Tata Kelola dan Kerjasama
                        <div class="kt-space-10"></div>
                        <?=
                        Progress::widget([
                            'percent' => $kriteria1->progress,
                            'barOptions' => ['class' => 'progress-bar-info'],
                            'options' => ['class' => 'progress-sm']
                        ]);?>
                    </td>
                    <td style="padding-top: 15px;">
                        <?= Html::a("<i class='la la-folder-open'></i>Lihat",['lk/isi-kriteria','kriteria'=>1, 'lk'=>$lkInstitusi->id],['class'=>'btn btn-default btn-pill btn-elevate btn-elevate-air'])?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>
                        <strong>Kriteria  &nbsp;2 : <?= $kriteria2->progress ?>%</strong><br>
                        Mahasiswa
                        <div class="kt-space-10"></div>
                        <?=
                        Progress::widget([
                            'percent' => $kriteria2->progress,
                            'barOptions' => ['class' => 'progress-bar-info'],
                            'options' => ['class' => 'progress-sm']
                        ]);?>
                    </td>
                    <td style="padding-top: 15px;">
                        <?= Html::a("<i class='la la-folder-open'></i>Lihat",['lk/isi-kriteria','kriteria'=>2, 'lk'=>$lkInstitusi->id],['class'=>'btn btn-default btn-pill btn-elevate btn-elevate-air'])?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>
                        <strong>Kriteria  &nbsp;3 : <?= $kriteria3->progress ?>%</strong><br>
                        Sumber Daya Manusia
                        <div class="kt-space-10"></div>
                        <?=
                        Progress::widget([
                            'percent' => $kriteria3->progress,
                            'barOptions' => ['class' => 'progress-bar-info'],
                            'options' => ['class' => 'progress-sm']
                        ]);?>
                    </td>
                    <td style="padding-top: 15px;">
                        <?= Html::a("<i class='la la-folder-open'></i>Lihat",['lk/isi-kriteria','kriteria'=>3, 'lk'=>$lkInstitusi->id],['class'=>'btn btn-default btn-pill btn-elevate btn-elevate-air'])?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">4</th>
                    <td>
                        <strong>Kriteria  &nbsp;4 : <?= $kriteria4->progress ?>%</strong><br>
                        Keuangan, Sarana dan Prasarana
                        <div class="kt-space-10"></div>
                        <?=
                        Progress::widget([
                            'percent' => $kriteria4->progress,
                            'barOptions' => ['class' => 'progress-bar-info'],
                            'options' => ['class' => 'progress-sm']
                        ]);?>
                    </td>
                    <td style="padding-top: 15px;">
                        <?= Html::a("<i class='la la-folder-open'></i>Lihat",['lk/isi-kriteria','kriteria'=>4, 'lk'=>$lkInstitusi->id],['class'=>'btn btn-default btn-pill btn-elevate btn-elevate-air'])?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">5</th>
                    <td>
                        <strong>Kriteria  &nbsp;5 : <?= $kriteria5->progress ?>%</strong><br>
                        Luaran dan Capaian Tridharma
                        <div class="kt-space-10"></div>
                        <?=
                        Progress::widget([
                            'percent' => $kriteria5->progress,
                            'barOptions' => ['class' => 'progress-bar-info'],
                            'options' => ['class' => 'progress-sm']
                        ]);?>
                    </td>
                    <td style="padding-top: 15px;">
                        <?= Html::a("<i class='la la-folder-open'></i>Lihat",['lk/isi-kriteria','kriteria'=>5, 'lk'=>$lkInstitusi->id],['class'=>'btn btn-default btn-pill btn-elevate btn-elevate-air'])?>
                    </td>
                </tr>

                </tbody>
            </table>

        </div>
    </div>
</div>
