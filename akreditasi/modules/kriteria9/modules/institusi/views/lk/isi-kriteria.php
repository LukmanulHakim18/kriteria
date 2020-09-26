<?php

use akreditasi\models\kriteria9\forms\lk\institusi\K9LinkLkInstitusiKriteriaDetailForm;
use akreditasi\models\kriteria9\forms\lk\institusi\K9LkInstitusiKriteriaDetailForm;
use akreditasi\models\kriteria9\forms\lk\institusi\K9TextLkInstitusiKriteriaDetailForm;
use akreditasi\models\kriteria9\lk\institusi\K9LkInstitusiNarasiKriteria1Form;
use common\helpers\FileIconHelper;
use common\helpers\FileTypeHelper;
use common\models\Constants;
use common\models\kriteria9\lk\institusi\K9LkInstitusi;
use dosamigos\tinymce\TinyMce;
use kartik\file\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
use yii\bootstrap4\Progress;

/* @var $this yii\web\View */
/* @var $lkInstitusi K9LkInstitusi */
/* @var $modelNarasi K9LkInstitusiNarasiKriteria1Form */
/* @var $dokModel K9LkInstitusiKriteriaDetailForm */
/* @var $dokTextModel K9TextLkInstitusiKriteriaDetailForm */
/* @var $dokLinkModel K9LinkLkInstitusiKriteriaDetailForm */
/* @var $poinKriteria */
/* @var $path string */
/* @var $modelKriteria */

$kriteria = Yii::$app->request->get('kriteria');
$this->title = "Kriteria " . $kriteria;
$this->params['breadcrumbs'][] = ['label' => 'Beranda', 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = ['label' => '9 Kriteria', 'url' => ['/kriteria9/default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Institusi', 'url' => ['/kriteria9/k9-institusi/default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Isi Kriteria', 'url' => ['/kriteria9/k9-institusi/lk/isi', 'lk' => $lkInstitusi->id,]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                <?= $this->title ?>

            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-actions">
                <strong>Kelengkapan Berkas &nbsp; : <?= $modelKriteria->progress ?> %</strong>
                <div class="kt-space-10"></div>
                <?=
                Progress::widget([
                    'percent' => $modelKriteria->progress,
                    'barOptions' => ['class' => 'progress-bar-info'],
                    'options' => ['class' => 'progress-sm']
                ]);
                ?>
            </div>
        </div>
    </div>

    <div class="kt-portlet__body">
        <div class="kt-section kt-section--first" style="margin-bottom: 0;">

            <!--begin::Accordion-->
            <div class="accordion accordion-solid  accordion-toggle-arrow" id="accordionExample2">

                <?php foreach ($poinKriteria

                               as $key => $item) :
                    $modelAttribute = '_' . str_replace('.', '_', $item['tabel']); ?>

                    <div class="card">
                        <div class="card-header" id="heading<?= $key ?>">
                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapse<?= $key ?>"
                                 aria-expanded="false" aria-controls="collapse<?= $key ?>">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <i class="flaticon-file-2"></i> <?=
                                        $item['tabel'] ?>&nbsp;
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <small>&nbsp;<?= $item['isi'] ?></small>

                                    </div>
                                </div>
                            </div>

                            <div id="collapse<?= $key ?>" class="collapse" aria-labelledby="heading<?= $key ?>"
                                 data-parent="#accordionExample2" style="">
                                <div class="card-body">

                                    <div class="kt-portlet kt-portlet--mobile">
                                        <div class="kt-portlet__body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'id' => $modelAttribute . '-form']) ?>

                                                    <h5>Tabel <?=$item['tabel']?> <?=$item['nama']?></h5>
                                                    <p><?=$item['petunjuk']?></p>

                                                    <?= $form->field($modelNarasi, $modelAttribute)->widget(TinyMce::class, [
                                                        'options' => ['rows' => 16, 'id' => $modelAttribute . '-tinymce-kriteria'],
                                                        'language' => 'id',
                                                        'clientOptions' => [
                                                            'plugins' => [
                                                                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                                                                "searchreplace wordcount visualblocks visualchars code fullscreen",
                                                                "insertdatetime media nonbreaking save table contextmenu directionality",
                                                                "emoticons template paste textcolor colorpicker textpattern imagetools codesample toc noneditable",
                                                            ],
                                                            'toolbar' => "undo redo| styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | ltr rtl | link | image"

                                                        ]
                                                    ])->label('') ?>

                                                    <?php if(!empty($item['keterangan'])):?>
                                                        <h6>Keterangan</h6>
                                                        <?=$item['keterangan']?>
                                                    <?php endif;?>
                                                    <div class="form-group pull-right">
                                                        <?= Html::submitButton('<i class="la la-save"></i> Simpan', ['class' => 'btn btn-primary btn-pill btn-elevate btn-elevate-air ']) ?>
                                                    </div>
                                                    <?php ActiveForm::end() ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!--                            Tabel dokumen sumber-->
                                    <table class="table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th colspan="3" class="text-center">Dokumen Sumber</th>
                                        </tr>
                                        </thead>
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>Kode</th>
                                            <th colspan="2">Dokumen</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php foreach ($item['dokumen_sumber'] as $keyDoksum => $doksum) :

                                        $clear = trim($doksum['kode']);
                                        $kodeSumber = '_' . str_replace('.', '_', $clear);

                                        if (!empty($doksum['kode'])) : ?>

                                            <tr>
                                                <th scope="row"><?= $doksum['kode'] ?></th>
                                                <td>
                                                    <p style="font-size: 14px;font-weight: 400"><?= $doksum['dokumen'] ?></p>
                                                </td>
                                                <td>

                                                    <!--                                                    File-->
                                                    <?php Modal::begin([
                                                        'title' => 'Unggah Dokumen Sumber Laporan Kinerja',
                                                        'toggleButton' => ['label' => '<i class="la la-upload"></i> &nbsp;Unggah', 'class' => 'btn btn-light btn-pill btn-elevate btn-elevate-air btn-sm pull-right'],
                                                        'size' => 'modal-lg',
                                                        'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                                    ]); ?>

                                                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

                                                    <?= $form->field($dokModel, 'jenisDokumen')->textInput(['value' => 'sumber', 'readonly' => true]) ?>
                                                    <?= $form->field($dokModel, 'kodeDokumen')->textInput(['value' => $doksum['kode'], 'readonly' => true]) ?>
                                                    <?= $form->field($dokModel, 'namaDokumen')->textInput(['value' => $doksum['dokumen'], 'readonly' => true]) ?>

                                                    <?= $form->field($dokModel, 'isiDokumen')->widget(FileInput::class, [
                                                        'options' => ['id' => 'isiDokumen' . $kodeSumber],
                                                        'pluginOptions' => [
                                                            'theme' => 'explorer-fas',
                                                            'showUpload' => false,
                                                            'maxFileSize' => Constants::MAX_UPLOAD_SIZE(),
                                                            'allowedFileExtensions' => Constants::ALLOWED_EXTENSIONS,
                                                            'previewFileType' => 'any',
                                                            'fileActionSettings' => [
                                                                'showZoom' => true,
                                                                'showRemove' => false,
                                                                'showUpload' => false,
                                                            ],
                                                        ]
                                                    ]) ?>

                                                    <div class="form-group text-right">
                                                        <?= Html::submitButton("<i class='la la-save'></i> Simpan", ['class' => 'btn btn-pill btn-elevate btn-elevate-air btn-primary ']) ?>
                                                    </div>
                                                    <?php ActiveForm::end() ?>

                                                    <?php Modal::end(); ?>


                                                    <!--                                                    Text-->

                                                    <?php Modal::begin([
                                                        'title' => 'Isi Teks Dokumentasi',
                                                        'toggleButton' => ['label' => '<i class="la la-file-text"></i> &nbsp;Teks', 'class' => 'btn btn-success btn-pill btn-sm btn-elevate btn-elevate-air pull-right'],
                                                        'size' => 'modal-lg',
                                                        'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                                    ]); ?>

                                                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'id' => 'pendukung']) ?>

                                                    <?= $form->field($dokTextModel, 'jenisDokumen')->textInput(['value' => 'sumber', 'readonly' => true]) ?>
                                                    <?= $form->field($dokTextModel, 'kodeDokumen')->textInput(['value' => $doksum['kode'], 'readonly' => true]) ?>
                                                    <?= $form->field($dokTextModel, 'namaDokumen')->textInput(['value' => $doksum['dokumen'], 'readonly' => true]) ?>

                                                    <?= $form->field($dokTextModel, 'isiDokumen')->widget(TinyMce::class, [
                                                        'options' => ['rows' => 6, 'id' => 'sumber' . $kodeSumber],
                                                        'language' => 'id',
                                                        'clientOptions' => [
                                                            'plugins' => [
                                                                "advlist autolink lists link image charmap print preview hr anchor pagebreak placeholder",
                                                                "searchreplace wordcount visualblocks visualchars code fullscreen",
                                                                "insertdatetime media nonbreaking save table contextmenu directionality",
                                                                "emoticons template paste textcolor colorpicker textpattern imagetools codesample toc noneditable",
                                                            ],
                                                            'toolbar' => "undo redo| styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | ltr rtl | link | image"

                                                        ]
                                                    ])->label('Isi Dokumen') ?>

                                                    <div class="form-group text-right">
                                                        <?= Html::submitButton("<i class='la la-save'></i> Simpan", ['class' => 'btn btn-pill btn-elevate btn-elevate-air btn-primary ']) ?>
                                                    </div>
                                                    <?php ActiveForm::end() ?>

                                                    <?php Modal::end(); ?>

                                                    <!--                                                    Link-->

                                                    <?php Modal::begin([
                                                        'title' => 'Isi Tautan Dokumentasi',
                                                        'toggleButton' => ['label' => '<i class="la la-link"></i> &nbsp;Tautan', 'class' => 'btn btn-info btn-pill btn-sm btn-elevate btn-elevate-air pull-right'],
                                                        'size' => 'modal-lg',
                                                        'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                                    ]); ?>

                                                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

                                                    <?= $form->field($dokLinkModel, 'jenisDokumen')->textInput(['value' => 'sumber', 'readonly' => true]) ?>
                                                    <?= $form->field($dokLinkModel, 'kodeDokumen')->textInput(['value' => $doksum['kode'], 'readonly' => true]) ?>
                                                    <?= $form->field($dokLinkModel, 'namaDokumen')->textInput(['value' => $doksum['dokumen'], 'readonly' => true]) ?>
                                                    <?= $form->field($dokLinkModel, 'isiDokumen')->textInput(['
                                                    placeholder'=>'https://www.contoh.com'])->label('Tautan')->hint('https:// atau http:// harus dimasukkan.') ?>
                                                    <div class="form-group text-right">
                                                        <?= Html::submitButton("<i class='la la-save'></i> Simpan", ['class' => 'btn btn-pill btn-elevate btn-elevate-air btn-primary ']) ?>
                                                    </div>
                                                    <?php ActiveForm::end() ?>

                                                    <?php Modal::end(); ?>
                                                </td>
                                            </tr>


                                        <?php else :
                                            echo '<tr><td>Tidak ada dokumen</td></tr>';
                                        endif; ?>
                                        <?php

                                        $detailClass = 'common\\models\\kriteria9\\lk\\institusi\\K9LkInstitusiKriteria' . $kriteria . 'Detail';
                                        $detail = call_user_func($detailClass . "::find")->where(['id_lk_institusi_kriteria' . $kriteria => $modelKriteria->id]);

                                        $detail1 = $detail->andWhere(['kode_dokumen' => $doksum['kode'], 'jenis_dokumen' => Constants::SUMBER])->all();
                                        foreach ($detail1 as $k => $v) : ?>

                                            <tr>
                                                <td></td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-lg-12 text-center">

                                                            <?= FileIconHelper::getIconByExtension($v->bentuk_dokumen) ?>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12 text-center">
                                                            <?php $type = FileTypeHelper::getType($v->bentuk_dokumen);

                                                            if ($type === FileTypeHelper::TYPE_STATIC_TEXT || $type === FileTypeHelper::TYPE_LINK) : ?>
                                                                <?= Html::encode($v->nama_dokumen) ?>

                                                            <?php else: ?>
                                                                <?= Html::encode($v->isi_dokumen) ?>
                                                            <?php endif; ?>

                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <?php $type = FileTypeHelper::getType($v->bentuk_dokumen);
                                                            if ($type === FileTypeHelper::TYPE_IMAGE || $type === FileTypeHelper::TYPE_PDF || $type === FileTypeHelper::TYPE_STATIC_TEXT):?>

                                                                <?php Modal::begin([
                                                                    'title' => $v->nama_dokumen,
                                                                    'toggleButton' => ['label' => '<i class="la la-eye"></i> &nbsp;Lihat', 'class' => 'btn btn-info btn-sm btn-pill btn-elevate btn-elevate-air'],
                                                                    'size' => 'modal-lg',
                                                                    'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                                                ]); ?>
                                                                <?php switch ($type) {
                                                                    case FileTypeHelper::TYPE_IMAGE:
                                                                        echo Html::img("$path/sumber/{$v->isi_dokumen}", ['height' => '100%', 'width' => '100%']);
                                                                        break;
                                                                    case FileTypeHelper::TYPE_STATIC_TEXT:
                                                                        echo $v->isi_dokumen;
                                                                        break;
                                                                    case FileTypeHelper::TYPE_PDF:
                                                                        echo '<embed src="' . $path . '/sumber/' . $v->isi_dokumen . '" type="application/pdf" height="100%" width="100%">
';
                                                                        break;
                                                                } ?>
                                                                <?php Modal::end(); ?>
                                                            <?php elseif ($type === FileTypeHelper::TYPE_LINK): ?>
                                                                <?= Html::a('<i class="la la-external-link"></i> Lihat', $v->isi_dokumen, ['class' => 'btn btn-info btn-sm btn-pill btn-elevate btn-elevate-air', 'target' => '_blank']) ?>
                                                            <?php endif; ?>
                                                            <?php if ($type === FileTypeHelper::TYPE_LINK || $type === FileTypeHelper::TYPE_STATIC_TEXT): ?>

                                                            <?php else: ?>
                                                                <?= Html::a('<i class="la la-download"></i>&nbsp;Unduh', ['lk/download-detail', 'kriteria' => $kriteria, 'dokumen' => $v->id, 'lk' => $_GET['lk'], 'jenis' => Constants::SUMBER], ['class' => 'btn btn-warning btn-sm btn-pill btn-elevate btn-elevate-air']) ?>
                                                            <?php endif; ?>
                                                            <?= Html::a('<i class ="la la-trash"></i>&nbsp; Hapus', ['lk/hapus-detail'], [
                                                                'class' => 'btn btn-danger btn-sm btn-pill btn-elevate btn-elevate-air',
                                                                'data' => [
                                                                    'method' => 'POST',
                                                                    'confirm' => 'Apakah anda yakin menghapus item ini?',
                                                                    'params' => ['dokumen' => $v->id, 'kriteria' => $kriteria, 'lk' => $_GET['lk'], 'jenis' => Constants::SUMBER]
                                                                ]
                                                            ]) ?>
                                                        </div>

                                                    </div>
                                                </td>
                                            </tr>

                                        <?php
                                        endforeach;
                                        ?>

                                        </tbody>
                                        <?php endforeach; ?>
                                    </table>

                                    <!--                            Tabel dokumen pendukung-->
                                    <table class="table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th colspan="3" class="text-center">Dokumen Pendukung</th>
                                        </tr>
                                        </thead>
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>Kode</th>
                                            <th colspan="2">Dokumen</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php foreach ($item['dokumen_pendukung'] as $keyDokpen => $dokpen) {
                                            $dokpenAttr = '_' . str_replace('.', '_', $dokpen['kode']);
                                            if (!empty($dokpen['kode'])) {

                                                $kodePendukung = str_replace('.', '', trim($dokpen['kode']));
                                                ?>

                                                <tr>
                                                    <th scope="row"><?= $dokpen['kode'] ?></th>
                                                    <td>
                                                        <p style="font-size: 14px;font-weight: 400"><?= $dokpen['dokumen'] ?></p>
                                                    </td>
                                                    <td style="width: 300px;">
                                                        <!--                                            File-->
                                                        <?php Modal::begin([
                                                            'title' => 'Unggah Dokumen Dokumentasi',
                                                            'toggleButton' => ['label' => '<i class="la la-upload"></i> &nbsp;Unggah', 'class' => 'btn btn-light btn-pill btn-elevate btn-elevate-air btn-sm pull-right'],
                                                            'size' => 'modal-lg',
                                                            'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                                        ]); ?>

                                                        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

                                                        <?= $form->field($dokModel, 'jenisDokumen')->textInput(['value' => 'pendukung', 'readonly' => true]) ?>
                                                        <?= $form->field($dokModel, 'kodeDokumen')->textInput(['value' => $dokpen['kode'], 'readonly' => true]) ?>
                                                        <?= $form->field($dokModel, 'namaDokumen')->textInput(['value' => $dokpen['dokumen'], 'readonly' => true]) ?>

                                                        <?= $form->field($dokModel, 'isiDokumen')->widget(FileInput::class, [
                                                            'options' => ['id' => 'isiDokumen' . $kodePendukung],
                                                            'pluginOptions' => [
                                                                'theme' => 'explorer-fas',
                                                                'showUpload' => false,
                                                                'maxFileSize' => Constants::MAX_UPLOAD_SIZE(),
                                                                'allowedFileExtensions' => Constants::ALLOWED_EXTENSIONS,
                                                                'previewFileType' => 'any',
                                                                'fileActionSettings' => [
                                                                    'showZoom' => true,
                                                                    'showRemove' => false,
                                                                    'showUpload' => false,
                                                                ],]
                                                        ]) ?>


                                                        <div class="form-group text-right">
                                                            <?= Html::submitButton("<i class='la la-save'></i> Simpan", ['class' => 'btn btn-pill btn-elevate btn-elevate-air btn-primary ']) ?>
                                                        </div>
                                                        <?php ActiveForm::end() ?>

                                                        <?php Modal::end(); ?>


                                                        <!--                                                    Text-->

                                                        <?php Modal::begin([
                                                            'title' => 'Isi Teks Dokumentasi',
                                                            'toggleButton' => ['label' => '<i class="la la-file-text"></i> &nbsp;Teks', 'class' => 'btn btn-success btn-pill btn-sm btn-elevate btn-elevate-air pull-right'],
                                                            'size' => 'modal-lg',
                                                            'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                                        ]); ?>

                                                        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'id' => 'pendukung']) ?>

                                                        <?= $form->field($dokTextModel, 'jenisDokumen')->textInput(['value' => 'pendukung', 'readonly' => true]) ?>
                                                        <?= $form->field($dokTextModel, 'kodeDokumen')->textInput(['value' => $dokpen['kode'], 'readonly' => true]) ?>
                                                        <?= $form->field($dokTextModel, 'namaDokumen')->textInput(['value' => $dokpen['dokumen'], 'readonly' => true]) ?>

                                                        <?= $form->field($dokTextModel, 'isiDokumen')->widget(TinyMce::class, [
                                                            'options' => ['rows' => 6, 'id' => 'pendukung' . $kodePendukung],
                                                            'language' => 'id',
                                                            'clientOptions' => [
                                                                'plugins' => [
                                                                    "advlist autolink lists link image charmap print preview hr anchor pagebreak placeholder",
                                                                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                                                                    "insertdatetime media nonbreaking save table contextmenu directionality",
                                                                    "emoticons template paste textcolor colorpicker textpattern imagetools codesample toc noneditable",
                                                                ],
                                                                'toolbar' => "undo redo| styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | ltr rtl | link | image"

                                                            ]
                                                        ])->label('Isi Dokumen') ?>

                                                        <div class="form-group text-right">
                                                            <?= Html::submitButton("<i class='la la-save'></i> Simpan", ['class' => 'btn btn-pill btn-elevate btn-elevate-air btn-primary ']) ?>
                                                        </div>
                                                        <?php ActiveForm::end() ?>

                                                        <?php Modal::end(); ?>

                                                        <!--                                                    Link-->

                                                        <?php Modal::begin([
                                                            'title' => 'Isi Tautan Dokumentasi',
                                                            'toggleButton' => ['label' => '<i class="la la-link"></i> &nbsp;Tautan', 'class' => 'btn btn-info btn-pill btn-sm btn-elevate btn-elevate-air pull-right'],
                                                            'size' => 'modal-lg',
                                                            'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                                        ]); ?>

                                                        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

                                                        <?= $form->field($dokLinkModel, 'jenisDokumen')->textInput(['value' => 'pendukung', 'readonly' => true]) ?>
                                                        <?= $form->field($dokLinkModel, 'kodeDokumen')->textInput(['value' => $dokpen['kode'], 'readonly' => true]) ?>
                                                        <?= $form->field($dokLinkModel, 'namaDokumen')->textInput(['value' => $dokpen['dokumen'], 'readonly' => true]) ?>
                                                        <?= $form->field($dokLinkModel, 'isiDokumen')->textInput(['
                                                    placeholder'=>'https://www.contoh.com'])->label('Tautan')->hint('https:// atau http:// harus dimasukkan.') ?>
                                                        <div class="form-group text-right">
                                                            <?= Html::submitButton("<i class='la la-save'></i> Simpan", ['class' => 'btn btn-pill btn-elevate btn-elevate-air btn-primary ']) ?>
                                                        </div>

                                                        <?php ActiveForm::end() ?>

                                                        <?php Modal::end(); ?>
                                                    </td>

                                                </tr>


                                            <?php } else {
                                                echo '<tr><td>Tidak ada dokumen</td></tr>';
                                            } ?>


                                            <?php
                                            $detailClass = 'common\\models\\kriteria9\\lk\\institusi\\K9LkInstitusiKriteria' . $kriteria . 'Detail';
                                            $detail = call_user_func($detailClass . "::find")->where(['id_lk_institusi_kriteria' . $kriteria => $modelKriteria->id]);

                                            $detail1 = $detail->andWhere(['kode_dokumen' => $dokpen['kode'], 'jenis_dokumen' => Constants::PENDUKUNG])->all();

                                            foreach ($detail1 as $k => $v) :
                                                ?>
                                                <tr>
                                                    <td colspan="2">
                                                        <div class="row">
                                                            <div class="col-lg-12 text-center">

                                                                <?= FileIconHelper::getIconByExtension($v->bentuk_dokumen) ?>
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12 text-center">
                                                                <?php $type = FileTypeHelper::getType($v->bentuk_dokumen);

                                                                if ($type === FileTypeHelper::TYPE_STATIC_TEXT || $type === FileTypeHelper::TYPE_LINK) : ?>
                                                                    <?= Html::encode($v->nama_dokumen) ?>

                                                                <?php else: ?>
                                                                    <?= Html::encode($v->isi_dokumen) ?>
                                                                <?php endif; ?>

                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="pull-right">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <?php $type = FileTypeHelper::getType($v->bentuk_dokumen);
                                                                if ($type === FileTypeHelper::TYPE_IMAGE || $type === FileTypeHelper::TYPE_PDF || $type === FileTypeHelper::TYPE_STATIC_TEXT):?>

                                                                    <?php Modal::begin([
                                                                        'title' => $v->nama_dokumen,
                                                                        'toggleButton' => ['label' => '<i class="la la-eye"></i> &nbsp;Lihat', 'class' => 'btn btn-info btn-sm btn-pill btn-elevate btn-elevate-air'],
                                                                        'size' => 'modal-lg',
                                                                        'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                                                    ]); ?>
                                                                    <?php switch ($type) {
                                                                        case FileTypeHelper::TYPE_IMAGE:
                                                                            echo Html::img("$path/pendukung/{$v->isi_dokumen}", ['height' => '100%', 'width' => '100%']);
                                                                            break;
                                                                        case FileTypeHelper::TYPE_STATIC_TEXT:
                                                                            echo $v->isi_dokumen;
                                                                            break;
                                                                        case FileTypeHelper::TYPE_PDF:
                                                                            echo '<embed src="' . $path . '/pendukung/' . $v->isi_dokumen . '" type="application/pdf" height="100%" width="100%">
';
                                                                            break;
                                                                    } ?>
                                                                    <?php Modal::end(); ?>
                                                                <?php elseif ($type === FileTypeHelper::TYPE_LINK): ?>
                                                                    <?= Html::a('<i class="la la-external-link"></i> Lihat', $v->isi_dokumen, ['class' => 'btn btn-info btn-sm btn-pill btn-elevate btn-elevate-air', 'target' => '_blank']) ?>
                                                                <?php endif; ?>
                                                                <?php if ($type === FileTypeHelper::TYPE_LINK || $type === FileTypeHelper::TYPE_STATIC_TEXT): ?>

                                                                <?php else: ?>
                                                                    <?= Html::a('<i class="la la-download"></i>&nbsp;Unduh', ['lk/download-detail', 'kriteria' => $kriteria, 'dokumen' => $v->id, 'lk' => $_GET['lk'], 'jenis' => Constants::PENDUKUNG], ['class' => 'btn btn-warning btn-sm btn-pill btn-elevate btn-elevate-air']) ?>
                                                                <?php endif; ?>
                                                                <?= Html::a('<i class ="la la-trash"></i>&nbsp; Hapus', ['lk/hapus-detail'], [
                                                                    'class' => 'btn btn-danger btn-sm btn-pill btn-elevate btn-elevate-air',
                                                                    'data' => [
                                                                        'method' => 'POST',
                                                                        'confirm' => 'Apakah anda yakin menghapus item ini?',
                                                                        'params' => ['dokumen' => $v->id, 'kriteria' => $kriteria, 'lk' => $_GET['lk'], 'jenis' => Constants::PENDUKUNG]
                                                                    ]
                                                                ]) ?>
                                                            </div>

                                                        </div>
                                                    </td>


                                                </tr>
                                            <?php
                                            endforeach;
                                        } ?>

                                        </tbody>
                                    </table>

                                    <!--                                Tabel dokumen lainnya-->
                                    <table class="table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th colspan="2" class="text-left">Dokumen Lainnya</th>
                                            <th>
                                                <?php Modal::begin([
                                                    'title' => 'Unggah Dokumen Dokumentasi',
                                                    'toggleButton' => ['label' => '<i class="la la-upload"></i> &nbsp;Unggah', 'class' => 'btn btn-light btn-pill btn-elevate btn-elevate-air pull-right'],
                                                    'size' => 'modal-lg',
                                                    'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                                ]); ?>

                                                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

                                                <?= $form->field($dokModel, 'jenisDokumen')->textInput(['value' => 'lainnya', 'readonly' => true]) ?>
                                                <?= $form->field($dokModel, 'kodeDokumen')->textInput(['value' => $item['tabel'], 'readonly' => true]) ?>
                                                <?= $form->field($dokModel, 'namaDokumen')->textInput(['value' => 'Dokumen Lainnya ' . $item['tabel'], 'readonly' => true]) ?>

                                                <?= $form->field($dokModel, 'isiDokumen')->widget(FileInput::class, [
                                                    'options' => ['id' => 'isiDokumenLainnya' . str_replace('.', '_', $item['tabel'])],
                                                    'pluginOptions' => [
                                                        'theme' => 'explorer-fas',
                                                        'showUpload' => false,
                                                        'maxFileSize' => Constants::MAX_UPLOAD_SIZE(),
                                                        'allowedFileExtensions' => Constants::ALLOWED_EXTENSIONS,
                                                        'previewFileType' => 'any',
                                                        'fileActionSettings' => [
                                                            'showZoom' => true,
                                                            'showRemove' => false,
                                                            'showUpload' => false,
                                                        ],]
                                                ]) ?>


                                                <div class="form-group text-right">
                                                    <?= Html::submitButton("<i class='la la-save'></i> Simpan", ['class' => 'btn btn-pill btn-elevate btn-elevate-air btn-primary ']) ?>
                                                </div>
                                                <?php ActiveForm::end() ?>

                                                <?php Modal::end(); ?>
                                            </th>
                                        </tr>
                                        </thead>
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>No.</th>
                                            <th colspan="2">Dokumen</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $detailClass = 'common\\models\\kriteria9\\lk\\institusi\\K9LkInstitusiKriteria' . $kriteria . "Detail";
                                        $detail = call_user_func($detailClass . "::find")->where(['id_lk_institusi_kriteria' . $kriteria => $modelKriteria->id]);

                                        $detail1 = $detail->andWhere(['jenis_dokumen' => Constants::LAINNYA])->all();
                                        if (!empty($detail1)) {
                                            foreach ($detail1 as $k => $v) {
                                                if ( $v['jenis_dokumen'] === 'lainnya') { ?>
                                                    <tr>
                                                        <td><strong><?= $k + 1 ?></strong></td>
                                                        <td>
                                                            <div class="row">
                                                                <div class="col-lg-12 text-center">

                                                                    <?= FileIconHelper::getIconByExtension($v->bentuk_dokumen) ?>
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12 text-center">
                                                                    <?php $type = FileTypeHelper::getType($v->bentuk_dokumen);

                                                                    if ($type === FileTypeHelper::TYPE_STATIC_TEXT || $type === FileTypeHelper::TYPE_LINK) : ?>
                                                                        <?= Html::encode($v->nama_dokumen) ?>

                                                                    <?php else: ?>
                                                                        <?= Html::encode($v->isi_dokumen) ?>
                                                                    <?php endif; ?>

                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-right">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <?php $type = FileTypeHelper::getType($v->bentuk_dokumen);
                                                                    if ($type === FileTypeHelper::TYPE_IMAGE || $type === FileTypeHelper::TYPE_PDF || $type === FileTypeHelper::TYPE_STATIC_TEXT):?>

                                                                        <?php Modal::begin([
                                                                            'title' => $v->nama_dokumen,
                                                                            'toggleButton' => ['label' => '<i class="la la-eye"></i> &nbsp;Lihat', 'class' => 'btn btn-info btn-sm btn-pill btn-elevate btn-elevate-air'],
                                                                            'size' => 'modal-lg',
                                                                            'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                                                        ]); ?>
                                                                        <?php switch ($type) {
                                                                            case FileTypeHelper::TYPE_IMAGE:
                                                                                echo Html::img("$path/lainnya/{$v->isi_dokumen}", ['height' => '100%', 'width' => '100%']);
                                                                                break;
                                                                            case FileTypeHelper::TYPE_STATIC_TEXT:
                                                                                echo $v->isi_dokumen;
                                                                                break;
                                                                            case FileTypeHelper::TYPE_PDF:
                                                                                echo '<embed src="' . $path . '/lainnya/' . $v->isi_dokumen . '" type="application/pdf" height="100%" width="100%">
';
                                                                                break;
                                                                        } ?>
                                                                        <?php Modal::end(); ?>
                                                                    <?php elseif ($type === FileTypeHelper::TYPE_LINK): ?>
                                                                        <?= Html::a('<i class="la la-external-link"></i> Lihat', $v->isi_dokumen, ['class' => 'btn btn-info btn-sm btn-pill btn-elevate btn-elevate-air', 'target' => '_blank']) ?>
                                                                    <?php endif; ?>
                                                                    <?php if ($type === FileTypeHelper::TYPE_LINK || $type === FileTypeHelper::TYPE_STATIC_TEXT): ?>

                                                                    <?php else: ?>
                                                                        <?= Html::a('<i class="la la-download"></i>&nbsp;Unduh', ['lk/download-detail', 'kriteria' => $kriteria, 'dokumen' => $v->id, 'lk' => $_GET['lk'], 'jenis' => Constants::LAINNYA], ['class' => 'btn btn-warning btn-sm btn-pill btn-elevate btn-elevate-air']) ?>
                                                                    <?php endif; ?>
                                                                    <?= Html::a('<i class ="la la-trash"></i>&nbsp; Hapus', ['lk/hapus-detail'], [
                                                                        'class' => 'btn btn-danger btn-sm btn-pill btn-elevate btn-elevate-air',
                                                                        'data' => [
                                                                            'method' => 'POST',
                                                                            'confirm' => 'Apakah anda yakin menghapus item ini?',
                                                                            'params' => ['dokumen' => $v->id, 'kriteria' => $kriteria, 'lk' => $_GET['lk'], 'jenis' => Constants::LAINNYA]
                                                                        ]
                                                                    ]) ?>
                                                                </div>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            }
                                        } else {
                                            echo '<tr><td>Tidak ada dokumen</td></tr>';
                                        } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>

                <?php endforeach; ?>
                <!--end::Accordion-->
            </div>
        </div>
    </div>

