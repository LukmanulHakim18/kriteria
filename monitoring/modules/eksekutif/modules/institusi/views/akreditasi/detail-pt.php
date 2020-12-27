<?php
/**
 * @var $this yii\web\View
 * @var $profilInstitusi yii2mod\collection\Collection
 * @var $akreditasiInstitusi common\models\kriteria9\akreditasi\K9AkreditasiInstitusi
 * @var $ledInstitusi common\models\kriteria9\led\institusi\K9LedInstitusi
 * @var $jsonLed array
 * @var $dokumenLed common\models\kriteria9\led\institusi\K9InstitusiEksporDokumen
 * @var $kriteriaLed array
 * @var $urlLed string
 * @var $jsonLk array
 * @var $lkInstitusi common\models\kriteria9\lk\institusi\K9LkInstitusi
 * @var $kriteriaLk array
 */

use common\helpers\FileIconHelper;
use common\helpers\FileTypeHelper;
use common\models\FakultasAkademi;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
use yii\bootstrap4\Progress;

$this->title = "Akreditasi: {$akreditasiInstitusi->akreditasi->nama} - {$profilInstitusi['nama']}";
$this->params['breadcrumbs'][] = ['label' => 'Akreditasi Prodi', 'url' => ['index-prodi']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>


<?= $this->render(
    '@monitoring/views/common/_institusi_progress',
    ['model'=>$akreditasiInstitusi,'profilInstitusi'=>$profilInstitusi]
) ?>

<div class="row">
    <div class="col-lg-12">
        <div class="kt-portlet kt-portlet--height-fluid">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Laporan Evaluasi Diri Program Studi
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-actions">
                        <strong>Perkembangan Pengisian &nbsp;: <?= $ledInstitusi->progress ?> %</strong>
                        <div class="kt-space-10"></div>
                        <?=
                        Progress::widget([
                            'percent' => $ledInstitusi->progress,
                            'barOptions' => ['class' => 'progress-bar-info m-progress-lg'],
                            'options' => ['class' => 'progress-sm']
                        ]); ?>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-section kt-section--first">
                    <h3>Dokumen LED</h3>
                    <table class="table table-hover table-light table-striped">
                        <thead class="thead-light">
                        <tr>

                            <th>No.</th>
                            <th>Dokumen Led</th>
                            <th>
                                Aksi
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($dokumenLed as $key => $item): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-12 text-center">
                                            <?= FileIconHelper::getIconByExtension($item->bentuk_dokumen) ?>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 text-center">
                                            <?= Html::encode($item->nama_dokumen) ?>

                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="row pull-right">
                                        <div class="col-lg-12">
                                            <?php $type = FileTypeHelper::getType($item->bentuk_dokumen);
                                            if ($type === FileTypeHelper::TYPE_IMAGE || $type === FileTypeHelper::TYPE_PDF):?>
                                                <?php Modal::begin([
                                                    'title' => $item->nama_dokumen,
                                                    'toggleButton' => [
                                                        'label' => '<i class="la la-eye"></i> &nbsp;Lihat',
                                                        'class' => 'btn btn-info btn-pill btn-elevate btn-elevate-air'
                                                    ],
                                                    'size' => 'modal-lg',
                                                    'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                                ]); ?>
                                                <?php switch ($type) {
                                                    case FileTypeHelper::TYPE_IMAGE:
                                                        echo Html::img(
                                                            "$urlLed/{$item->nama_dokumen}",
                                                            ['height' => '100%', 'width' => '100%']
                                                        );
                                                        break;
                                                    case FileTypeHelper::TYPE_PDF:
                                                        echo '<embed src="' . $urlLed . '/' . $item->nama_dokumen . '" type="application/pdf" height="100%" width="100%">
';
                                                        break;
                                                } ?>
                                                <?php Modal::end(); ?>
                                            <?php endif; ?>
                                            <?= Html::a(
                                                '<i class ="la la-download"></i> Unduh',
                                                ['led/download-dokumen', 'dokumen' => $item->id],
                                                ['class' => 'btn btn-warning btn-pill btn-elevate btn-elevate-air']
                                            ) ?>
                                        </div>

                                    </div>


                                </td>
                            </tr>

                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="kt-section">
                    <table class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Kriteria Akreditasi</th>
                            <th style="width: 110px"></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($jsonLed as $kriteriaJson): ?>
                            <tr>
                                <th scope="row"><?= Html::encode($kriteriaJson['kriteria']) ?></th>
                                <td>
                                    <strong>Kriteria <?= Html::encode($kriteriaJson['kriteria']) ?>
                                        : <?= $kriteriaLed[$kriteriaJson['kriteria'] - 1]->progress ?>%</strong><br>
                                    <?= $kriteriaJson['judul'] ?>
                                    <div class="kt-space-10"></div>
                                    <?=
                                    Progress::widget([
                                        'percent' => $kriteriaLed[$kriteriaJson['kriteria'] - 1]->progress,
                                        'barOptions' => ['class' => 'progress-bar-info m-progress-lg'],
                                        'options' => ['class' => 'progress-sm']
                                    ]); ?>
                                </td>
                                <td style="padding-top: 15px;">
                                    <?= Html::a("<i class='la la-folder-open'></i>Lihat", [
                                        'led-institusi/lihat',
                                        'led' => $_GET['id'],
                                        'kriteria' => $kriteriaJson['kriteria'],
                                    ], ['class' => 'btn btn-default btn-pill btn-elevate btn-elevate-air']) ?>

                                    <!--                        <button type="button" class="btn btn-danger">Lihat</button>-->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="kt-portlet kt-portlet--height-fluid">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Laporan Kinerja Program Studi
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-actions">
                        <strong>Perkembangan Pengisian &nbsp;: <?= $lkInstitusi->progress ?> %</strong>
                        <div class="kt-space-10"></div>
                        <?=
                        Progress::widget([
                            'percent' => $lkInstitusi->progress,
                            'barOptions' => ['class' => 'progress-bar-info m-progress-lg'],
                            'options' => ['class' => 'progress-sm']
                        ]); ?>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-section">
                    <table class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Kriteria Akreditasi</th>
                            <th style="width: 110px"></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($jsonLk as $kriteriaJson): ?>
                            <tr>
                                <th scope="row"><?= Html::encode($kriteriaJson['kriteria']) ?></th>
                                <td>
                                    <strong>Tabel <?= Html::encode($kriteriaJson['kriteria']) ?>
                                        : <?= $kriteriaLk[$kriteriaJson['kriteria'] - 1]->progress ?>%</strong><br>
                                    <?= $kriteriaJson['judul'] ?>
                                    <div class="kt-space-10"></div>
                                    <?=
                                    Progress::widget([
                                        'percent' => $kriteriaLk[$kriteriaJson['kriteria'] - 1]->progress,
                                        'barOptions' => ['class' => 'progress-bar-info m-progress-lg'],
                                        'options' => ['class' => 'progress-sm']
                                    ]); ?>
                                </td>
                                <td style="padding-top: 15px;">
                                    <?= Html::a("<i class='la la-folder-open'></i>Lihat", [
                                        'lk-institusi/lihat',
                                        'lk' => $_GET['id'],
                                        'kriteria' => $kriteriaJson['kriteria']
                                    ], ['class' => 'btn btn-default btn-pill btn-elevate btn-elevate-air']) ?>

                                    <!--                        <button type="button" class="btn btn-danger">Lihat</button>-->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>
