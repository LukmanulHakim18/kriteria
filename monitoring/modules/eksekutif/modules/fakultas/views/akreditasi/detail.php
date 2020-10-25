<?php
/**
 * @var $this yii\web\View
 * @var $modelProdi common\models\ProgramStudi
 * @var $akreditasiProdi common\models\kriteria9\akreditasi\K9AkreditasiProdi
 * @var $ledProdi common\models\kriteria9\led\prodi\K9LedProdi
 * @var $jsonLed array
 * @var $dokumenLed common\models\kriteria9\led\prodi\K9ProdiEksporDokumen
 * @var $kriteriaLed array
 * @var $urlLed string
 * @var $jsonLk array
 * @var $lkProdi common\models\kriteria9\lk\prodi\K9LkProdi
 * @var $kriteriaLk array
 */

use common\helpers\FileIconHelper;
use common\helpers\FileTypeHelper;
use common\models\FakultasAkademi;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
use yii\bootstrap4\Progress;

$this->title = "Akreditasi: {$akreditasiProdi->akreditasi->nama} - {$modelProdi->nama}";
$this->params['breadcrumbs'][] = ['label' => 'Akreditasi Prodi', 'url' => ['index', 'prodi' => $_GET['prodi']]];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>


<?= $this->render('@monitoring/views/common/_prodi_progress',
    ['prodi' => $modelProdi, 'model' => $akreditasiProdi, 'jenis' => FakultasAkademi::FAKULTAS_AKADEMI]) ?>

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
                        <strong>Perkembangan Pengisian &nbsp;: <?= $ledProdi->progress ?> %</strong>
                        <div class="kt-space-10"></div>
                        <?=
                        Progress::widget([
                            'percent' => $ledProdi->progress,
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
                                                        echo Html::img("$urlLed/{$item->nama_dokumen}",
                                                            ['height' => '100%', 'width' => '100%']);
                                                        break;
                                                    case FileTypeHelper::TYPE_PDF:
                                                        echo '<embed src="' . $urlLed . '/' . $item->nama_dokumen . '" type="application/pdf" height="100%" width="100%">
';
                                                        break;
                                                } ?>
                                                <?php Modal::end(); ?>
                                            <?php endif; ?>
                                            <?= Html::a('<i class ="la la-download"></i> Unduh',
                                                ['led/download-dokumen', 'dokumen' => $item->id],
                                                ['class' => 'btn btn-warning btn-pill btn-elevate btn-elevate-air']) ?>
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
                                        'led/lihat',
                                        'led' => $_GET['id'],
                                        'kriteria' => $kriteriaJson['kriteria'],
                                        'prodi' => $modelProdi->id,
                                        'fakultas' => $_GET['fakultas']
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
                        <strong>Perkembangan Pengisian &nbsp;: <?= $lkProdi->progress ?> %</strong>
                        <div class="kt-space-10"></div>
                        <?=
                        Progress::widget([
                            'percent' => $lkProdi->progress,
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
                                        'lk/lihat',
                                        'lk' => $_GET['id'],
                                        'kriteria' => $kriteriaJson['kriteria'],
                                        'prodi' => $modelProdi->id,
                                        'fakultas' => $_GET['fakultas']
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
