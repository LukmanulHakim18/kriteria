<?php
/**
 * @var $this yii\web\View
 * @var $profilInstitusi yii2mod\collection\Collection
 * @var $akreditasiInstitusi common\models\kriteria9\akreditasi\K9AkreditasiInstitusi
 * @var $led common\models\kriteria9\led\institusi\K9LedInstitusi
 * @var $jsonLed array
 * @var $dokumenLed common\models\kriteria9\led\institusi\K9InstitusiEksporDokumen
 * @var $kriteriaLed array
 * @var $urlLed string
 * @var $jsonLk array
 * @var $lkInstitusi common\models\kriteria9\lk\institusi\K9LkInstitusi
 * @var $kriteriaLk array
 */

use common\helpers\FileIconHelper;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
use yii\bootstrap4\Progress;

$this->title = "Akreditasi: {$akreditasiInstitusi->akreditasi->nama} - {$profilInstitusi['nama']}";
$this->params['breadcrumbs'][] = ['label' => 'Akreditasi Perguruan Tinggi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>


<?= $this->render(
    '@monitoring/views/common/_institusi_progress',
    ['model' => $akreditasiInstitusi, 'profilInstitusi' => $profilInstitusi]
) ?>

<?= $this->render('@monitoring/modules/eksekutif/modules/institusi/views/led-institusi/_dokumen_led',
    compact('modelDokumen', 'dataDokumen', 'path', 'untuk')) ?>

<?= $this->render('@monitoring/modules/eksekutif/modules/institusi/views/led-institusi/_tabel_led', [
    'kriteria' => $kriteriaLed,
    'json' => $jsonLed,
    'untuk' => $untuk,
    'led' => $led,
    'json_eksternal' => $json_eksternal,
    'json_profil' => $json_profil,
    'json_analisis' => $json_analisis,
    'modelEksternal' => $modelEksternal,
    'modelAnalisis' => $modelAnalisis,
    'modelProfil' => $modelProfil,
]) ?>

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Dokumen Lk
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-actions">
            </div>
        </div>

    </div>

    <div class="kt-portlet__body">
        <div class="kt-section kt-section--first" style="margin-bottom: 0;">
            <table class="table table-hover table-light table-striped">
                <thead class="thead-light">
                <tr>

                    <th class="text-center">No.</th>
                    <th class="text-center">Dokumen Lk</th>
                    <th class="text-center">Dibuat Tanggal</th>
                    <th class="text-center">Jenis</th>
                    <th class="text-center">
                        Aksi
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($dataDokumenLk as $key => $item) : ?>
                    <tr>
                        <td class="text-center"><?= $key + 1 ?></td>
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
                        <td class="text-center"><?= Yii::$app->formatter->asDatetime($item->updated_at) ?></td>
                        <td class="text-center"><?= $item->kode_dokumen ?></td>
                        <td>
                            <div class="row pull-right">
                                <div class="col-lg-12">
                                    <?php Modal::begin([
                                        'title' => $item->nama_dokumen,
                                        'toggleButton' => [
                                            'label' => '<i class="la la-eye"></i> &nbsp;Lihat',
                                            'class' => 'btn btn-info btn-pill btn-elevate btn-elevate-air'
                                        ],
                                        'size' => 'modal-lg',
                                        'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                    ]); ?>
                                    <?php echo ' <div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://docs.google.com/gview?url=' . $path . '/' . rawurlencode($item->nama_dokumen) . '&embedded=true"></iframe></div>'; ?>
                                    <?php Modal::end(); ?>
                                    <?= Html::a('<i class ="la la-download"></i> Unduh',
                                        ['lk-institusi' . '/download-dokumen', 'dokumen' => $item->id],
                                        ['class' => 'btn btn-warning btn-pill btn-elevate btn-elevate-air']) ?>
                                </div>

                            </div>


                        </td>
                    </tr>

                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="kt-portlet kt-portlet--height-fluid">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Laporan Kinerja Perguruan Tinggi
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
                                <th scope="row"><?= Html::encode($kriteriaJson->kriteria) ?></th>
                                <td>
                                    <strong>Tabel <?= Html::encode($kriteriaJson->kriteria) ?>
                                        : <?= $kriteriaLk[$kriteriaJson->kriteria - 1]->progress ?>%</strong><br>
                                    <?= $kriteriaJson->judul ?>
                                    <div class="kt-space-10"></div>
                                    <?=
                                    Progress::widget([
                                        'percent' => $kriteriaLk[$kriteriaJson->kriteria - 1]->progress,
                                        'barOptions' => ['class' => 'progress-bar-info m-progress-lg'],
                                        'options' => ['class' => 'progress-sm']
                                    ]); ?>
                                </td>
                                <td style="padding-top: 15px;">
                                    <?= Html::a("<i class='la la-folder-open'></i>Lihat", [
                                        'lk-institusi/lihat-kriteria',
                                        'lk' => $_GET['id'],
                                        'kriteria' => $kriteriaJson->kriteria
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
