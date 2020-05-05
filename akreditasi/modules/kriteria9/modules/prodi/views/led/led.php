<?php
/**
 * Project: mutu-v2.
 * @author Adryan Eka Vandra <adryanekavandra@gmail.com>
 *
 * Date: 8/26/2019
 * Time: 1:54 PM
 */
/**
 * @var $this View
 * @var $led K9LedProdi
 * @var $modelDokumen K9DokumenLedProdiUploadForm;
 * @var $dataDokumen [];
 * @var $json array;
 * @var $kriteria [];
 */
$prodi = $_GET['prodi'];

$this->title = "Isi LED";
$this->params['breadcrumbs'][] = ['label' => 'Beranda', 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = ['label' => '9 Kriteria', 'url' => ['/kriteria9/default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Prodi', 'url' => ['/kriteria9/k9-prodi/default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Led', 'url' => ['/kriteria9/k9-prodi/led/arsip', 'target' => 'isi','prodi'=>$prodi]];
$this->params['breadcrumbs'][] = $this->title;

use akreditasi\models\kriteria9\forms\led\K9DokumenLedProdiUploadForm;
use common\helpers\FileIconHelper;
use common\helpers\FileTypeHelper;
use common\models\Constants;
use common\models\kriteria9\led\prodi\K9LedProdi;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria1;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria2;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria3;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria4;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria5;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria6;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria7;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria8;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria9;
use common\models\kriteria9\led\prodi\K9DokumenLedProdi;
use kartik\file\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
use yii\bootstrap4\Progress;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\web\View;

?>


<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Form
                LED <?= Html::encode(StringHelper::mb_ucfirst($led->akreditasiProdi->akreditasi->jenis_akreditasi)) ?>
            </h3>
        </div>
    </div>

    <div class="kt-portlet__body">
        <div class="kt-section kt-section--first" style="margin-bottom: 0;">

            <table class="table table-striped">

                <tbody>
                <tr>
                    <th scope="row">Laporan Evaluasi Diri</th>
                    <td>Akreditasi Program Studi</td>
                </tr>
                <tr>
                    <th scope="row">Lembaga Akreditasi</th>
                    <td><?= Html::encode($led->akreditasiProdi->akreditasi->lembaga) ?></td>
                </tr>
                <tr>
                    <th scope="row">Tahun Akreditasi</th>
                    <td><?= Html::encode($led->akreditasiProdi->akreditasi->tahun) ?></td>
                </tr>
                <tr>
                    <th scope="row">Jenis Akreditasi</th>
                    <td><?= Html::encode(StringHelper::mb_ucfirst($led->akreditasiProdi->akreditasi->jenis_akreditasi)) ?></td>
                </tr>
                <tr>
                    <th scope="row">LED Untuk</th>
                    <td>Program Studi</td>
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
                Dokumen LED
                <small>Silahkan unggah dokumen led yang telah disusun.</small>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-actions">
                <?php Modal::begin([
                    'title' => 'Unggah Dokumen Led',
                    'toggleButton' => ['label' => '<i class="la la-upload"></i> &nbsp;Unggah', 'class' => 'btn btn-primary btn-pill btn-elevate btn-elevate-air'],
                    'size' => 'modal-lg',
                    'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                ]); ?>

                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'id'=>'dokumen-led-form']) ?>

                <?= $form->field($modelDokumen, 'dokumenLed')->widget(FileInput::class, [
                    'pluginOptions' => [
                        'theme' => 'explorer-fas',
                        'maxFileSize' => Constants::MAX_UPLOAD_SIZE,
                        'allowedFileExtensions' => Constants::ALLOWED_EXTENSIONS,
                        'showUpload' => false,
                        'previewFileType' => 'any',
                        'fileActionSettings' => [
                            'showZoom' => true,
                            'showRemove' => false,
                            'showUpload' => false,
                        ],
                    ]
                ]) ?>

                <div class="form-group pull-right">
                    <?= Html::submitButton('<i class="la la-save"></i> Simpan', ['class' => 'btn btn-primary btn-pill btn-elevate btn-elevate-air']) ?>
                </div>
                <?php ActiveForm::end() ?>

                <?php Modal::end(); ?>
            </div>
        </div>

    </div>

    <div class="kt-portlet__body">
        <div class="kt-section kt-section--first" style="margin-bottom: 0;">
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
                <?php foreach ($dataDokumen as $key => $item) : ?>
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
                                            'toggleButton' => ['label' => '<i class="la la-eye"></i> &nbsp;Lihat', 'class' => 'btn btn-info btn-pill btn-elevate btn-elevate-air'],
                                            'size' => 'modal-lg',
                                            'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                        ]); ?>
                                        <?php switch ($type) {
                                            case FileTypeHelper::TYPE_IMAGE:
                                                echo Html::img("$path/{$item->nama_dokumen}", ['height' => '100%', 'width' => '100%']);
                                                break;
                                            case FileTypeHelper::TYPE_PDF:
                                                echo '<embed src="' . $path . '/' . $item->nama_dokumen . '" type="application/pdf" height="100%" width="100%">
';
                                                break;
                                        } ?>
                                        <?php Modal::end(); ?>
                                    <?php endif; ?>
                                    <?= Html::a('<i class ="la la-download"></i> Unduh', ['led/download-dokumen', 'dokumen' => $item->id], ['class' => 'btn btn-warning btn-pill btn-elevate btn-elevate-air']) ?>
                                    <?= Html::a('<i class ="la la-trash"></i> Hapus', ['led/hapus-dokumen-led'], ['class' => 'btn btn-danger btn-pill btn-elevate btn-elevate-air', 'data' => [
                                        'method' => 'POST',
                                        'confirm' => 'Apakah anda yakin menghapus item ini?',
                                        'params' => ['id' => $item->id,'prodi'=>$prodi]
                                    ]]) ?>
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


<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Isi Led
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-actions">
                <strong>Kelengkapan Berkas:&nbsp;<?= Html::encode($led->progress) ?> %</strong>
                <div class="kt-space-10"></div>
                <?=
                Progress::widget([
                    'percent' => $led->progress,
                    'barOptions' => ['class' => 'progress-bar-info m-progress-lg'],
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
                            <strong>Kriteria <?= Html::encode($kriteriaJson['kriteria']) ?>
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
                            <?= Html::a("<i class='la la-folder-open'></i>Lihat", ['led/isi-kriteria', 'led' => $_GET['led'], 'kriteria' => $kriteriaJson['kriteria'],'prodi'=>$prodi], ['class' => 'btn btn-default btn-pill btn-elevate btn-elevate-air']) ?>

                            <!--                        <button type="button" class="btn btn-danger">Lihat</button>-->
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

