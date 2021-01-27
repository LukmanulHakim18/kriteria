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
use common\models\ProgramStudi;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
use yii\bootstrap4\Progress;

$this->title = "Akreditasi: {$akreditasiProdi->akreditasi->nama} - {$modelProdi->nama}";
$this->params['breadcrumbs'][] = ['label' => 'Akreditasi Prodi', 'url' => ['index-prodi']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>


<?= $this->render('@monitoring/views/common/_prodi_progress',
    ['prodi' => $modelProdi, 'model' => $akreditasiProdi, 'jenis' => ProgramStudi::PROGRAM_STUDI]) ?>

<div class="row">
    <div class="col-lg-12">

        <?= $this->render('@akreditasi/modules/kriteria9/modules/prodi/views/led/_dokumen_led', [
            'modelDokumen' => null,
            'dataDokumen' => $dokumenLed,
            'path' => $urlLed,
            'untuk' => 'lihat',
            'prodi' => $modelProdi
        ]) ?>

        <?= $this->render('@monitoring/modules/eksekutif/modules/fakultas/views/led/_tabel_led', [
            'kriteria' => $kriteriaLed,
            'json' => $json,
            'prodi' => $modelProdi,
            'untuk' => 'lihat',
            'led' => $ledProdi,
            'json_eksternal' => $json_eksternal,
            'json_profil' => $json_profil,
            'json_analisis' => $json_analisis,
            'modelEksternal' => $modelEksternal,
            'modelAnalisis' => $modelAnalisis,
            'modelProfil' => $modelProfil,
            'fakultas' => $fakultasAkademi
        ]) ?>

    </div>
</div>

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
                <?php foreach ($dataDokumen as $key => $item) : ?>
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
                                     <?php if($type === FileTypeHelper::TYPE_IMAGE):
                                        echo Html::img("$path/{$item->nama_dokumen}", ['height' => '100%', 'width' => '100%']);
                                        break;
                                    else :?> <?php if (\common\helpers\FileTypeHelper::getType($item->bentuk_dokumen)  ===\common\helpers\FileTypeHelper::TYPE_IMAGE):
                                        echo Html::img("$path/{$item->nama_dokumen}",
                                            ['height' => '100%', 'width' => '100%']);
                                    else :?>
                                        <p><small>Jika dokumen tidak tampil, silahkan klik <?= Html::a('di sini.',
                                                    'https://docs.google.com/gview?url=' . $path . '/' . rawurlencode($item->nama_dokumen),
                                                    ['target' => '_blank']) ?></small>
                                        </p> <?php echo ' <div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://docs.google.com/gview?url=' . $path . '/' . rawurlencode($item->nama_dokumen) . '&embedded=true"></iframe></div>'; ?>
                                    <?php endif; ?>
                                    <?php Modal::end(); ?>
                                    <?= Html::a('<i class ="la la-download"></i> Unduh',
                                        ['lk' . '/download-dokumen', 'dokumen' => $item->id],
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

                        <?php foreach ($jsonLk as /* @var Lk */
                                       $kriteriaJson): ?>
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
                                        'lk/lihat-kriteria',
                                        'lk' => $lkProdi->id,
                                        'kriteria' => $kriteriaJson->kriteria,
                                        'prodi' => $modelProdi->id,
                                        'fakultas' => $fakultasAkademi->id
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
