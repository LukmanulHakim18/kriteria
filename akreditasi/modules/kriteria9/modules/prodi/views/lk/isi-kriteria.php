<?php

use akreditasi\models\kriteria9\forms\lk\institusi\K9LinkLkInstitusiKriteriaDetailForm;
use akreditasi\models\kriteria9\forms\lk\institusi\K9LkInstitusiKriteriaDetailForm;
use akreditasi\models\kriteria9\forms\lk\institusi\K9TempLkInstitusiKriteriaDetailForm;
use akreditasi\models\kriteria9\forms\lk\institusi\K9TextLkInstitusiKriteriaDetailForm;
use akreditasi\models\kriteria9\lk\prodi\K9LkProdiNarasiKriteria1Form;
use common\helpers\FileIconHelper;
use common\models\Constants;
use common\models\kriteria9\lk\prodi\K9LkProdi;
use dosamigos\tinymce\TinyMce;
use kartik\file\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
use yii\bootstrap4\Progress;

/* @var $this yii\web\View */
/* @var $lkProdi K9LkProdi */
/* @var $modelNarasi K9LkProdiNarasiKriteria1Form */
/* @var $dokModel K9LkInstitusiKriteriaDetailForm */
/* @var $dokTextModel K9TextLkInstitusiKriteriaDetailForm */
/* @var $dokLinkModel K9LinkLkInstitusiKriteriaDetailForm */
/* @var $dokTempModel K9TempLkInstitusiKriteriaDetailForm */
/* @var $dataKriteria */
/* @var $poinKriteria */

$prodi = Yii::$app->request->get('prodi');
$kriteria = Yii::$app->request->get('kriteria');
$this->title = "Kriteria " . $kriteria;
$this->params['breadcrumbs'][] = ['label' => 'Beranda', 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = ['label' => '9 Kriteria', 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = ['label' => 'Program Studi', 'url' => ['/site/index']];
//$this->params['breadcrumbs'][] = ['label'=>'Data Program Studi','url'=>['/standar7/s7-prodi/default']];
$this->params['breadcrumbs'][] = ['label' => 'Isi Kriteria', 'url' => ['/kriteria9/k9-prodi/lk/isi', 'lk' => $lkProdi->id, 'prodi' => $_GET['prodi']]];
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
                <strong>Kelengkapan Berkas &nbsp; : <?= $modelNarasi->progress; ?> %</strong>
                <div class="kt-space-10"></div>
                <?=
                Progress::widget([
                    'percent' => $modelNarasi->progress,
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
                                        <div class="kt-portlet__head">
                                            <div class="kt-portlet__head-label">
                                                <h3 class="kt-portlet__head-title">
                                                    Template <small>Berikut adalah referensi template</small>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="kt-portlet__body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'id' => $modelAttribute . '-form']) ?>

                                                    <?= $form->field($modelNarasi, $modelAttribute)->widget(TinyMce::class, [
                                                        'options' => ['rows' => 6, 'id' => $modelAttribute . '-tinymce-kriteria'],
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
                                                    ])->label('') ?>

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

                                        if (!empty($sumber['kode'])) : ?>

                                            <tr>
                                                <th scope="row"><?= $sumber['kode'] ?></th>
                                                <td>
                                                    <p style="font-size: 14px;font-weight: 400"><?= $sumber['dokumen'] ?></p>
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
                                                    <?= $form->field($dokModel, 'kodeDokumen')->textInput(['value' => $sumber['kode'], 'readonly' => true]) ?>
                                                    <?= $form->field($dokModel, 'namaDokumen')->textInput(['value' => $sumber['dokumen'], 'readonly' => true]) ?>

                                                    <?= $form->field($dokModel, 'isiDokumen')->widget(FileInput::class, [
                                                        'options' => ['id' => 'isiDokumen' . $kodeSumber],
                                                        'pluginOptions' => [
                                                            'theme' => 'explorer-fas',
                                                            'showUpload' => false,
                                                            'maxFileSize' => Constants::MAX_UPLOAD_SIZE,
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
                                                    <?= $form->field($dokTextModel, 'kodeDokumen')->textInput(['value' => $sumber['kode'], 'readonly' => true]) ?>
                                                    <?= $form->field($dokTextModel, 'namaDokumen')->textInput(['value' => $sumber['dokumen'], 'readonly' => true]) ?>

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
                                                    <?= $form->field($dokLinkModel, 'kodeDokumen')->textInput(['value' => $sumber['kode'], 'readonly' => true]) ?>
                                                    <?= $form->field($dokLinkModel, 'namaDokumen')->textInput(['value' => $sumber['dokumen'], 'readonly' => true]) ?>
                                                    <?= $form->field($dokLinkModel, 'isiDokumen')->textInput() ?>

                                                    <div class="form-group text-right">
                                                        <?= Html::submitButton("<i class='la la-save'></i> Simpan", ['class' => 'btn btn-pill btn-elevate btn-elevate-air btn-primary ']) ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php ActiveForm::end() ?>

                                            <?php Modal::end(); ?>

                                        <?php else :
                                            echo '<tr><td>Tidak ada dokumen</td></tr>';
                                        endif; ?>
                                        <?php

                                        $detailClass = 'common\\models\\kriteria9\\lk\\prodi\\K9LkProdiKriteria' . $kriteria . 'Detail';
                                        $detail = call_user_func($detailClass . "::find")->where(['id_lk_prodi_kriteria' . $kriteria => $modelNarasi->id]);

                                        $detail1 = $detail->andWhere(['kode_dokumen' => $doksum['kode'], 'jenis_dokumen' => Constants::SUMBER])->all();
                                        foreach ($detail1 as $k => $v) : ?>

                                            <tr>
                                                <td></td>
                                                <td>
                                                    <div class="text-center">
                                                        <?php if ($v->bentuk_dokumen != 'text' && $v->bentuk_dokumen != 'link') : ?>
                                                            <div class="icon">
                                                                <?= FileIconHelper::getIconByExtension($v->bentuk_dokumen) ?>
                                                            </div>
                                                            <div class="kt-space-5"></div>
                                                            <?= Html::a($v['isi_dokumen'] . " <i class='fa fa-external-link-alt'></i>", ['lk/lihat-dok', 'kriteria' => $kriteria, 'dok' => $v['id'], 'lk' => $_GET['lk']], ['target' => '_blank', 'data-pjax' => "0"]) ?>

                                                        <?php else :
                                                            if ($v->bentuk_dokumen == 'link') {
                                                                echo '<a href=' . $v['isi_dokumen'] . ' target="_blank">' . $v["isi_dokumen"] . ' <i class=\'fa fa-external-link-alt\'></i></a>';
                                                            } else {
                                                                echo $v['isi_dokumen'];
                                                            }
                                                        endif; ?>
                                                    </div>
                                                </td>
                                                <td class="text-right">

                                                    <?php if ($v->bentuk_dokumen != 'text' && $v->bentuk_dokumen != 'link') {
                                                        echo Html::a('<i class="la la-download"></i> &nbsp;Unduh', ['lk/download-dok', 'id' => $v['id']], ['class' => 'btn btn-warning btn-pill btn-elevate btn-elevate-air']);
                                                    } ?>


                                                    <div class="kt-space-10"></div>

                                                    <?= Html::a('<i class="la la-trash"></i> &nbsp;Hapus', ['lk/hapus-dok'], ['class' => 'btn btn-danger btn-pill btn-elevate btn-elevate-air',
                                                        'data' => [
                                                            'method' => 'POST',
                                                            'confirm' => 'Apakah anda yakin menghapus item ini ?',
                                                            'params' => ['id' => $v->id, 'kriteria' => $kriteria, 'lk' => $_GET['lk'], 'prodi' => $_GET['prodi']]
                                                        ]]) ?>

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
                                            if (!empty($pendukung['kode'])) {

                                                $kodePendukung = str_replace('.', '', trim($pendukung['kode']));
                                                ?>

                                                <tr>
                                                    <th scope="row"><?= $pendukung['kode'] ?></th>
                                                    <td>
                                                        <p style="font-size: 14px;font-weight: 400"><?= $pendukung['dokumen'] ?></p>
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
                                                        <?= $form->field($dokModel, 'kodeDokumen')->textInput(['value' => $pendukung['kode'], 'readonly' => true]) ?>
                                                        <?= $form->field($dokModel, 'namaDokumen')->textInput(['value' => $pendukung['dokumen'], 'readonly' => true]) ?>

                                                        <?= $form->field($dokModel, 'isiDokumen')->widget(FileInput::class, [
                                                            'options' => ['id' => 'isiDokumen' . $kodePendukung],
                                                            'pluginOptions' => [
                                                                'theme' => 'explorer-fas',
                                                                'showUpload' => false,
                                                                'maxFileSize' => Constants::MAX_UPLOAD_SIZE,
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
                                                        <?= $form->field($dokTextModel, 'kodeDokumen')->textInput(['value' => $pendukung['kode'], 'readonly' => true]) ?>
                                                        <?= $form->field($dokTextModel, 'namaDokumen')->textInput(['value' => $pendukung['dokumen'], 'readonly' => true]) ?>

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
                                                        <?= $form->field($dokLinkModel, 'kodeDokumen')->textInput(['value' => $pendukung['kode'], 'readonly' => true]) ?>
                                                        <?= $form->field($dokLinkModel, 'namaDokumen')->textInput(['value' => $pendukung['dokumen'], 'readonly' => true]) ?>
                                                        <?= $form->field($dokLinkModel, 'isiDokumen')->textInput() ?>

                                                        <div class="form-group text-right">
                                                            <?= Html::submitButton("<i class='la la-save'></i> Simpan", ['class' => 'btn btn-pill btn-elevate btn-elevate-air btn-primary ']) ?>
                                                        </div>

                                                    </td>

                                                </tr>
                                                <?php ActiveForm::end() ?>

                                                <?php Modal::end(); ?>

                                            <?php } else {
                                                echo '<tr><td>Tidak ada dokumen</td></tr>';
                                            } ?>


                                            <?php
                                            $detailClass = 'common\\models\\kriteria9\\lk\\prodi\\K9LkProdiKriteria' . $kriteria . 'Detail';
                                            $detail = call_user_func($detailClass . "::find")->where(['id_lk_prodi_kriteria' . $kriteria => $modelNarasi->id]);

                                            $detail1 = $detail->andWhere(['kode_dokumen' => $dokpen['kode'], 'jenis_dokumen' => Constants::PENDUKUNG])->all();

                                            foreach ($detail1 as $k => $v) :
                                                ?>
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <div class="text-center">
                                                            <?php if ($v->bentuk_dokumen != 'text' && $v->bentuk_dokumen != 'link') { ?>
                                                                <div class="icon">
                                                                    <?= FileIconHelper::getIconByExtension($v->bentuk_dokumen) ?>
                                                                </div>
                                                                <div class="kt-space-5"></div>
                                                                <?= Html::a($v['isi_dokumen'] . " <i class='fa fa-external-link-alt'></i>", ['lk/lihat-dok', 'standar' => $kriteria, 'dok' => $v['id'], 'lk' => $_GET['lk']], ['target' => '_blank', 'data-pjax' => "0"]) ?>

                                                            <?php } else {
                                                                if ($v->bentuk_dokumen == 'link') {
                                                                    echo '<a href=' . $v['isi_dokumen'] . ' target="_blank">' . $v["isi_dokumen"] . ' <i class=\'fa fa-external-link-alt\'></i></a>';
                                                                } else {
                                                                    echo $v['isi_dokumen'];
                                                                }
                                                            } ?>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">

                                                        <?php if ($v->bentuk_dokumen != 'text' && $v->bentuk_dokumen != 'link') {
                                                            echo Html::a('<i class="la la-download"></i> &nbsp;Unduh', ['lk/download-dok', 'id' => $v->id], ['class' => 'btn btn-pill btn-elevate btn-elevate-air btn-warning']);
                                                        } ?>

                                                        <div class="kt-space-10"></div>

                                                        <?= Html::a('<i class="la la-trash"></i> &nbsp;Hapus', ['lk/hapus-dok'], ['class' => 'btn btn-pill btn-elevate btn-elevate-air btn-danger',
                                                            'data' => [
                                                                'method' => 'POST',
                                                                'confirm' => 'Apakah anda yakin menghapus item ini ?',
                                                                'params' => ['id' => $v->id, 'kriteria' => $kriteria, 'lk' => $_GET['lk'], 'prodi' => $_GET['prodi']]
                                                            ]]) ?>

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
                                                        'maxFileSize' => Constants::MAX_UPLOAD_SIZE,
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
                                        if (!empty($model)) {
                                            foreach ($model as $key => $item) {
                                                if ($item['tabel'] == $item['kode_dokumen'] && $item['jenis_dokumen'] == 'lainnya') { ?>
                                                    <tr>
                                                        <td><strong><?= $key + 1 ?></strong></td>
                                                        <td>
                                                            <div class="text-center">
                                                                <?php if ($item->bentuk_dokumen != 'text' && $item->bentuk_dokumen != 'link') { ?>
                                                                    <div class="icon">
                                                                        <?= FileIconHelper::getIconByExtension($item->bentuk_dokumen) ?>
                                                                    </div>
                                                                    <div class="kt-space-5"></div>
                                                                    <?= Html::a($item['isi_dokumen'] . " <i class='fa fa-external-link-alt'></i>", ['lk/lihat-dok', 'id' => $item['id']], ['target' => '_blank', 'data-pjax' => "0"]) ?>

                                                                <?php } else {
                                                                    if ($item->bentuk_dokumen == 'link') {
                                                                        echo '<a href=' . $item['isi_dokumen'] . ' target="_blank">' . $item["isi_dokumen"] . ' <i class=\'fa fa-external-link-alt\'></i></a>';
                                                                    } else {
                                                                        echo $item['isi_dokumen'];
                                                                    }
                                                                } ?>
                                                            </div>
                                                        </td>
                                                        <td class="pull-right">
                                                            <?php if ($item->bentuk_dokumen != 'text' && $item->bentuk_dokumen != 'link') {
                                                                echo Html::a('<i class="la la-download"></i> &nbsp;Unduh', ['lk/download-dok', 'id' => $item->id], ['class' => 'btn btn-pill btn-elevate btn-elevate-air btn-warning']);
                                                            } ?>

                                                            <!--                                                <div class="kt-space-10"></div>-->

                                                            <?= Html::a('<i class="la la-trash"></i> &nbsp;Hapus', ['lk/hapus-dok'], ['class' => 'btn btn-pill btn-elevate btn-elevate-air btn-danger',
                                                                'data' => [
                                                                    'method' => 'POST',
                                                                    'confirm' => 'Apakah anda yakin menghapus item ini ?',
                                                                    'params' => ['id' => $item->id, 'kriteria' => $kriteria, 'lk' => $_GET['lk'], 'prodi' => $_GET['prodi']]
                                                                ]]) ?>
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

