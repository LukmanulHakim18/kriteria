<?php
/**
 * @var $model ;
 * @var $modelNarasi ;
 * @var $poinKriteria [];
 * @var $detail ;
 * @var $detailModel K9DetailLedProdiUploadForm ;
 * @var $textModel K9DetailLedProdiTeksForm ;
 * @var $linkModel K9DetailLedProdiLinkForm ;
 */
$prodi = $_GET['prodi'];
$kriteria = $_GET['kriteria'];
$this->title = "Kriteria " . $kriteria;
$this->params['breadcrumbs'][] = ['label' => 'Beranda', 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = ['label' => '9 Kriteria', 'url' => ['/kriteria9/default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Program Studi', 'url' => ['/kriteria9/k9-prodi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Pencarian Data Prodi', 'url' => ['/kriteria9/k9-prodi/arsip', 'target' => 'isi', 'prodi' => $prodi]];
$this->params['breadcrumbs'][] = ['label' => 'Isi Led', 'url' => ['/kriteria9/k9-prodi/led/isi', 'led' => $_GET['led'], 'prodi' => $prodi]];
$this->params['breadcrumbs'][] = $this->title;


use akreditasi\models\kriteria9\forms\led\K9DetailLedProdiLinkForm;
use akreditasi\models\kriteria9\forms\led\K9DetailLedProdiTeksForm;
use akreditasi\models\kriteria9\forms\led\K9DetailLedProdiUploadForm;
use common\helpers\FileIconHelper;
use common\helpers\FileTypeHelper;
use common\models\Constants;
use dosamigos\tinymce\TinyMce;
use kartik\file\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
use yii\bootstrap4\Progress;

?>

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                <?= Html::encode($this->title) ?>

            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-actions">
                <strong>Kelengkapan Berkas &nbsp; : <?= $model->progress ?> %</strong>
                <div class="kt-space-10"></div>
                <?=
                Progress::widget([
                    'percent' => $model->progress,
                    'barOptions' => ['class' => 'progress-bar-info m-progress-lg'],
                    'options' => ['class' => 'progress-sm']
                ]); ?>
            </div>
        </div>
    </div>

    <div class="kt-portlet__body">
        <div class="kt-section kt-section--first" style="margin-bottom: 0;">

            <!--begin::Accordion-->
            <div class="accordion accordion-solid  accordion-toggle-plus" id="accordion">

                <?php foreach ($poinKriteria as $key => $item):
                    $modelAttribute = '_' . str_replace('.', '_', $item['nomor']);

                    ?>
                    <div class="card">
                        <div class="card-header" id="heading<?= $key ?>">
                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapse<?= $key ?>"
                                 aria-expanded="false" aria-controls="collapse<?= $key ?>">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <i class="flaticon-file-2"></i> <?=
                                        $item['nomor'] ?>&nbsp;
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <small>&nbsp;<?= $item['isi'] ?></small>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="collapse<?= $key ?>" class="collapse" aria-labelledby="heading<?= $key ?>"
                             data-parent="#accordion" style="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <?= $item['deskripsi'] ?>
                                    </div>
                                </div>
                                <div class="clearfix"></div>


                                <div class="row">
                                    <div class="col-lg-12">
                                        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'id' => $modelAttribute . '-form']) ?>

                                        <?= $form->field($modelNarasi, $modelAttribute)->widget(TinyMce::class, [
                                            'options' => ['rows' => 6, 'id' => $modelAttribute . '-tinymce-kriteria'],
                                            'language' => 'id',
                                            'clientOptions' => [
                                                'plugins' => [
                                                    "advlist autolink lists link image charmap print preview hr anchor pagebreak ",
                                                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                                                    "insertdatetime media nonbreaking save table  directionality",
                                                    "emoticons template paste   textpattern imagetools codesample toc noneditable",
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


                                <!--                            Tabel dokumen sumber-->
                                <table class="table table-striped table-hover">
                                    <thead class="thead-light">
                                    <tr>
                                        <th colspan="3" class="text-center">Dokumen Sumber</th>
                                    </tr>
                                    </thead>
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>Kode</th>
                                        <th colspan="2">Nama Dokumen</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    foreach ($item['dokumen_sumber'] as $keyDoksum => $doksum):
                                        $doksumAttr = '_' . str_replace('.', '_', $doksum['kode']);
                                        ?>
                                        <?php if (empty($doksum['kode'])) : ?>
                                        <tr>
                                            <td colspan="3">Tidak ada dokumen</td>
                                        </tr>
                                    <?php else: ?>
                                        <tr>
                                            <th scope="row">
                                                <?= $doksum['kode'] ?>
                                            </th>
                                            <td>
                                                <?= $doksum['dokumen'] ?>
                                            </td>
                                            <td>
                                                <div class="row pull-right">
                                                    <div class="col-lg-12">
                                                        <?php Modal::begin([
                                                            'title' => 'Dokumen Sumber Led',
                                                            'toggleButton' => ['label' => '<i class="la la-file-text"></i> &nbsp;Teks', 'class' => 'btn btn-success btn-sm btn-pill btn-elevate btn-elevate-air pull-right'],
                                                            'size' => 'modal-lg',
                                                            'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                                        ]) ?>
                                                        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'id' => $doksumAttr . '-text-sumber-form']) ?>

                                                        <?= $form->field($textModel, 'kode_dokumen')->textInput(['value' => $doksum['kode'], 'readonly' => true]) ?>
                                                        <?= $form->field($textModel, 'jenis_dokumen')->textInput(['value' => Constants::SUMBER, 'readonly' => true]) ?>
                                                        <?= $form->field($textModel, 'nama_dokumen')->textInput()->label('Nama Teks') ?>
                                                        <?= $form->field($textModel, 'berkasDokumen')->widget(TinyMce::class, [
                                                            'options' => ['rows' => 6, 'id' => $doksumAttr . '-text-sumber-input',],

                                                            'language' => 'id',
                                                            'clientOptions' => [

                                                                'plugins' => [
                                                                    "advlist autolink lists link image charmap print preview hr anchor pagebreak ",
                                                                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                                                                    "insertdatetime media nonbreaking save table  directionality",
                                                                    "emoticons template paste   textpattern imagetools codesample toc noneditable",
                                                                ],
                                                                'toolbar' => "undo redo| styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | ltr rtl | link"

                                                            ]
                                                        ])->label('Teks') ?>

                                                        <div class="form-group pull-right">
                                                            <?= Html::submitButton('<i class="la la-save"></i> Simpan', ['class' => 'btn btn-primary btn-pill btn-elevate btn-elevate-air']) ?>
                                                        </div>
                                                        <?php ActiveForm::end() ?>

                                                        <?php Modal::end() ?>
                                                        <?php Modal::begin([
                                                            'title' => 'Dokumen Sumber Led',
                                                            'toggleButton' => ['label' => '<i class="la la-link"></i> &nbsp;Tautan', 'class' => 'btn btn-info btn-sm btn-pill btn-elevate btn-elevate-air pull-right'],
                                                            'size' => 'modal-lg',
                                                            'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                                        ]) ?>
                                                        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'id' => $doksumAttr . '-link-sumber-form']) ?>

                                                        <?= $form->field($linkModel, 'kode_dokumen')->textInput(['value' => $doksum['kode'], 'readonly' => true]) ?>
                                                        <?= $form->field($linkModel, 'jenis_dokumen')->textInput(['value' => Constants::SUMBER, 'readonly' => true]) ?>
                                                        <?= $form->field($linkModel, 'nama_dokumen')->textInput()->label('Nama Tautan') ?>
                                                        <?= $form->field($linkModel, 'berkasDokumen')->textInput()->label('Tautan') ?>

                                                        <div class="form-group pull-right">
                                                            <?= Html::submitButton('<i class="la la-save"></i> Simpan', ['class' => 'btn btn-primary btn-pill btn-elevate btn-elevate-air']) ?>
                                                        </div>
                                                        <?php ActiveForm::end() ?>

                                                        <?php Modal::end() ?>
                                                        <?php Modal::begin([
                                                            'title' => 'Upload Dokumen Sumber Led',
                                                            'toggleButton' => ['label' => '<i class="la la-upload"></i> &nbsp;Unggah', 'class' => 'btn btn-light btn-sm btn-pill btn-elevate btn-elevate-air pull-right'],
                                                            'size' => 'modal-lg',
                                                            'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                                        ]) ?>
                                                        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'id' => $doksumAttr . '-upload-sumber-form']) ?>

                                                        <?= $form->field($detailModel, 'kode_dokumen')->textInput(['value' => $doksum['kode'], 'readonly' => true]) ?>
                                                        <?= $form->field($detailModel, 'nama_dokumen')->textInput(['value' => $doksum['dokumen'], 'readonly' => true]) ?>
                                                        <?= $form->field($detailModel, 'jenis_dokumen')->textInput(['value' => Constants::SUMBER, 'readonly' => true]) ?>
                                                        <?= $form->field($detailModel, 'berkasDokumen')->widget(FileInput::class, [
                                                            'options' => ['id' => 'dokumenSumber' . $doksumAttr],
                                                            'pluginOptions' => [
                                                                'theme' => 'explorer-fas',
                                                                'maxFileSize' => Constants::MAX_UPLOAD_SIZE(),
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

                                                        <?php Modal::end() ?>
                                                        <?=Html::submitButton('<i class="flaticon2-laptop"></i> Gunakan Data',['value'=>\yii\helpers\Url::to(['resource/index','prodi'=>$_GET['prodi']]),'title'=>'Gunakan Data Untuk : '.$doksum['kode'].'.'.' '.$doksum['dokumen'] ,'class'=>'btn btn-warning btn-pill btn-elevate btn-elevate-air showModalButton'])?>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                        <?php
                                        $detailClass = 'common\\models\\kriteria9\\led\\prodi\\K9LedProdiKriteria' . $kriteria . 'Detail';
                                        $detail = call_user_func($detailClass . "::find")->where(['id_led_prodi_kriteria' . $kriteria => $model->id]);

                                        $detail1 = $detail->andWhere(['kode_dokumen' => $doksum['kode'], 'jenis_dokumen' => Constants::SUMBER])->all();

                                        foreach ($detail1 as $k => $v):
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
                                                                <?= Html::a('<i class="la la-download"></i>&nbsp;Unduh', ['led/download-detail', 'kriteria' => $kriteria, 'dokumen' => $v->id, 'led' => $_GET['led'], 'jenis' => Constants::SUMBER], ['class' => 'btn btn-warning btn-sm btn-pill btn-elevate btn-elevate-air']) ?>
                                                            <?php endif; ?>
                                                            <?= Html::a('<i class ="la la-trash"></i>&nbsp; Hapus', ['led/hapus-detail'], [
                                                                'class' => 'btn btn-danger btn-sm btn-pill btn-elevate btn-elevate-air',
                                                                'data' => [
                                                                    'method' => 'POST',
                                                                    'confirm' => 'Apakah anda yakin menghapus item ini?',
                                                                    'params' => ['dokumen' => $v->id, 'kriteria' => $kriteria, 'prodi' => $prodi, 'led' => $_GET['led'], 'jenis' => Constants::SUMBER]
                                                                ]
                                                            ]) ?>
                                                        </div>

                                                    </div>
                                                </td>
                                            </tr>

                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <?php endforeach; ?>


                                    </tbody>
                                </table>

                                <!--                            Tabel dokumen pendukung-->
                                <table class="table table-striped table-hover">
                                    <thead class="thead-light">
                                    <tr>
                                        <th colspan="3" class="text-center">Dokumen Pendukung</th>
                                    </tr>
                                    </thead>
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>Kode</th>
                                        <th colspan="2">Nama Dokumen</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    foreach ($item['dokumen_pendukung'] as $keyDokpen => $dokpen):
                                        $dokpenAttr = '_' . str_replace('.', '_', $dokpen['kode']);
                                        ?>
                                        <?php if (empty($dokpen['kode'])) : ?>
                                        <tr>
                                            <td colspan="3">Tidak ada dokumen</td>
                                        </tr>
                                    <?php else: ?>
                                        <tr>
                                            <th scope="row">
                                                <?= $dokpen['kode'] ?>
                                            </th>
                                            <td>
                                                <?= $dokpen['dokumen'] ?>
                                            </td>
                                            <td>
                                                <div class="row pull-right">
                                                    <div class="col-lg-12">
                                                        <?php Modal::begin([
                                                            'title' => 'Dokumen Pendukung Led',
                                                            'toggleButton' => ['label' => '<i class="la la-file-text"></i> &nbsp;Teks', 'class' => 'btn btn-success btn-sm btn-pill btn-elevate btn-elevate-air pull-right'],
                                                            'size' => 'modal-lg',
                                                            'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                                        ]) ?>
                                                        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'id' => $doksumAttr . '-text-pendukung-form']) ?>

                                                        <?= $form->field($textModel, 'kode_dokumen')->textInput(['value' => $dokpen['kode'], 'readonly' => true]) ?>
                                                        <?= $form->field($textModel, 'jenis_dokumen')->textInput(['value' => Constants::PENDUKUNG, 'readonly' => true]) ?>
                                                        <?= $form->field($textModel, 'nama_dokumen')->textInput()->label('Nama Teks') ?>
                                                        <?= $form->field($textModel, 'berkasDokumen')->widget(TinyMce::class, [
                                                            'options' => ['rows' => 6, 'id' => $dokpenAttr . '-text-sumber-input',],

                                                            'language' => 'id',
                                                            'clientOptions' => [

                                                                'plugins' => [
                                                                    "advlist autolink lists link image charmap print preview hr anchor pagebreak ",
                                                                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                                                                    "insertdatetime media nonbreaking save table  directionality",
                                                                    "emoticons template paste   textpattern imagetools codesample toc noneditable",
                                                                ],
                                                                'toolbar' => "undo redo| styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | ltr rtl | link"

                                                            ]
                                                        ])->label('Teks') ?>

                                                        <div class="form-group pull-right">
                                                            <?= Html::submitButton('<i class="la la-save"></i> Simpan', ['class' => 'btn btn-primary btn-pill btn-elevate btn-elevate-air']) ?>
                                                        </div>
                                                        <?php ActiveForm::end() ?>

                                                        <?php Modal::end() ?>
                                                        <?php Modal::begin([
                                                            'title' => 'Dokumen Pendukung Led',
                                                            'toggleButton' => ['label' => '<i class="la la-link"></i> &nbsp;Tautan', 'class' => 'btn btn-info btn-sm btn-pill btn-elevate btn-elevate-air pull-right'],
                                                            'size' => 'modal-lg',
                                                            'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                                        ]) ?>
                                                        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'id' => $dokpenAttr . '-link-pendukung-form']) ?>

                                                        <?= $form->field($linkModel, 'kode_dokumen')->textInput(['value' => $dokpen['kode'], 'readonly' => true]) ?>
                                                        <?= $form->field($linkModel, 'jenis_dokumen')->textInput(['value' => Constants::PENDUKUNG, 'readonly' => true]) ?>
                                                        <?= $form->field($linkModel, 'nama_dokumen')->textInput()->label('Nama Tautan') ?>
                                                        <?= $form->field($linkModel, 'berkasDokumen')->textInput()->label('Tautan') ?>

                                                        <div class="form-group pull-right">
                                                            <?= Html::submitButton('<i class="la la-save"></i> Simpan', ['class' => 'btn btn-primary btn-pill btn-elevate btn-elevate-air']) ?>
                                                        </div>
                                                        <?php ActiveForm::end() ?>

                                                        <?php Modal::end() ?>
                                                        <?php Modal::begin([
                                                            'title' => 'Upload Dokumen Pendukung Led',
                                                            'toggleButton' => ['label' => '<i class="la la-upload"></i> &nbsp;Unggah', 'class' => 'btn btn-light btn-sm btn-pill btn-elevate btn-elevate-air pull-right'],
                                                            'size' => 'modal-lg',
                                                            'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                                        ]) ?>
                                                        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'id' => $dokpenAttr . '-pendukung-form']) ?>

                                                        <?= $form->field($detailModel, 'kode_dokumen')->textInput(['value' => $dokpen['kode'], 'readonly' => true]) ?>
                                                        <?= $form->field($detailModel, 'nama_dokumen')->textInput(['value' => $dokpen['dokumen'], 'readonly' => true]) ?>
                                                        <?= $form->field($detailModel, 'jenis_dokumen')->textInput(['value' => Constants::PENDUKUNG, 'readonly' => true]) ?>
                                                        <?= $form->field($detailModel, 'berkasDokumen')->widget(FileInput::class, [
                                                            'options' => ['id' => 'dokumenPendukung' . $dokpenAttr],
                                                            'pluginOptions' => [
                                                                'theme' => 'explorer-fas',
                                                                'maxFileSize' => Constants::MAX_UPLOAD_SIZE(),
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

                                                        <?php Modal::end() ?>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                        <?php
                                        $detailClass = 'common\\models\\kriteria9\\led\\prodi\\K9LedProdiKriteria' . $kriteria . 'Detail';
                                        $detail = call_user_func($detailClass . "::find")->where(['id_led_prodi_kriteria' . $kriteria => $model->id]);

                                        $detail1 = $detail->andWhere(['kode_dokumen' => $dokpen['kode'], 'jenis_dokumen' => Constants::PENDUKUNG])->all();

                                        foreach ($detail1 as $k => $v):
                                            ?>
                                            <tr>
                                                <td><?= $k + 1 ?></td>
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
                                                                <?= Html::a('<i class="la la-download"></i>&nbsp;Unduh', ['led/download-detail', 'kriteria' => $kriteria, 'dokumen' => $v->id, 'led' => $_GET['led'], 'jenis' => Constants::PENDUKUNG], ['class' => 'btn btn-warning btn-sm btn-pill btn-elevate btn-elevate-air']) ?>
                                                            <?php endif; ?>
                                                            <?= Html::a('<i class ="la la-trash"></i>&nbsp; Hapus', ['led/hapus-detail'], [
                                                                'class' => 'btn btn-danger btn-sm btn-pill btn-elevate btn-elevate-air',
                                                                'data' => [
                                                                    'method' => 'POST',
                                                                    'confirm' => 'Apakah anda yakin menghapus item ini?',
                                                                    'params' => ['dokumen' => $v->id, 'kriteria' => $kriteria, 'led' => $_GET['led'], 'jenis' => Constants::PENDUKUNG, 'prodi' => $prodi]
                                                                ]
                                                            ]) ?>
                                                        </div>

                                                    </div>
                                                </td>
                                            </tr>

                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <?php endforeach; ?>


                                    </tbody>
                                </table>


                                <!--                            Tabel dokumen Lainnya-->
                                <table class="table table-striped table-hover">
                                    <thead class="thead-light">
                                    <tr>
                                        <th colspan="3" class="text-center">Dokumen Lainnya</th>
                                    </tr>
                                    </thead>
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Dokumen Lainnya</th>
                                        <th>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <?php Modal::begin([
                                                        'title' => 'Dokumen Lainnya Led',
                                                        'toggleButton' => ['label' => '<i class="la la-file-text"></i> &nbsp;Teks', 'class' => 'btn btn-success btn-sm btn-pill btn-elevate btn-elevate-air pull-right'],
                                                        'size' => 'modal-lg',
                                                        'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                                    ]) ?>
                                                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'id' => $modelAttribute . '-text-lainnya-form']) ?>

                                                    <?= $form->field($textModel, 'jenis_dokumen')->textInput(['value' => Constants::LAINNYA, 'readonly' => true]) ?>
                                                    <?= $form->field($textModel, 'nama_dokumen')->textInput()->label('Nama Teks') ?>
                                                    <?= $form->field($textModel, 'berkasDokumen')->widget(TinyMce::class, [
                                                        'options' => ['rows' => 6, 'id' => $modelAttribute . '-text-lainnya-input',],

                                                        'language' => 'id',
                                                        'clientOptions' => [

                                                            'plugins' => [
                                                                "advlist autolink lists link image charmap print preview hr anchor pagebreak ",
                                                                "searchreplace wordcount visualblocks visualchars code fullscreen",
                                                                "insertdatetime media nonbreaking save table  directionality",
                                                                "emoticons template paste   textpattern imagetools codesample toc noneditable",
                                                            ],
                                                            'toolbar' => "undo redo| styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | ltr rtl | link"

                                                        ]
                                                    ])->label('Teks') ?>

                                                    <div class="form-group pull-right">
                                                        <?= Html::submitButton('<i class="la la-save"></i> Simpan', ['class' => 'btn btn-primary btn-pill btn-elevate btn-elevate-air']) ?>
                                                    </div>
                                                    <?php ActiveForm::end() ?>

                                                    <?php Modal::end() ?>
                                                    <?php Modal::begin([
                                                        'title' => 'Dokumen Lainnya Led',
                                                        'toggleButton' => ['label' => '<i class="la la-link"></i> &nbsp;Tautan', 'class' => 'btn btn-info btn-sm btn-pill btn-elevate btn-elevate-air pull-right'],
                                                        'size' => 'modal-lg',
                                                        'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                                    ]) ?>
                                                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'id' => $modelAttribute . '-link-lainnya-form']) ?>

                                                    <?= $form->field($linkModel, 'jenis_dokumen')->textInput(['value' => Constants::LAINNYA, 'readonly' => true]) ?>
                                                    <?= $form->field($linkModel, 'nama_dokumen')->textInput()->label('Nama Tautan') ?>
                                                    <?= $form->field($linkModel, 'berkasDokumen')->textInput()->label('Tautan') ?>

                                                    <div class="form-group pull-right">
                                                        <?= Html::submitButton('<i class="la la-save"></i> Simpan', ['class' => 'btn btn-primary btn-pill btn-elevate btn-elevate-air']) ?>
                                                    </div>
                                                    <?php ActiveForm::end() ?>

                                                    <?php Modal::end() ?>

                                                    <?php Modal::begin([
                                                        'title' => 'Upload Dokumen Lainnya Borang',
                                                        'toggleButton' => ['label' => '<i class="la la-upload"></i> &nbsp;Unggah', 'class' => 'btn btn-light btn-sm btn-pill btn-elevate btn-elevate-air pull-right'],
                                                        'size' => 'modal-lg',
                                                        'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                                    ]) ?>

                                                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'id' => $modelAttribute . '-lainnya-form']) ?>

                                                    <?= $form->field($detailModel, 'nomorDokumen')->textInput(['value' => $item['nomor'], 'readonly' => true]) ?>
                                                    <?= $form->field($detailModel, 'nama_dokumen')->textInput() ?>
                                                    <?= $form->field($detailModel, 'jenis_dokumen')->textInput(['value' => Constants::LAINNYA, 'readonly' => true]) ?>


                                                    <?= $form->field($detailModel, 'berkasDokumen')->widget(FileInput::class, [
                                                        'options' => ['id' => 'dokumenLainnya' . $modelAttribute],
                                                        'pluginOptions' => [
                                                            'theme' => 'explorer-fas',
                                                            'maxFileSize' => Constants::MAX_UPLOAD_SIZE(),
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

                                                    <?php Modal::end() ?>
                                                </div>
                                            </div>

                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    $detailClass = 'common\\models\\kriteria9\\led\\prodi\\K9LedProdiKriteria' . $kriteria . "Detail";
                                    $detail = call_user_func($detailClass . "::find")->where(['id_led_prodi_kriteria' . $kriteria => $model->id]);

                                    $detail1 = $detail->andWhere(['jenis_dokumen' => Constants::LAINNYA])->all();

                                    foreach ($detail1 as $k => $v):
                                        ?>
                                        <tr>
                                            <td><?= $k + 1 ?></td>
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
                                                            <?= Html::a('<i class="la la-download"></i>&nbsp;Unduh', ['led/download-detail', 'kriteria' => $kriteria, 'dokumen' => $v->id, 'led' => $_GET['led'], 'jenis' => Constants::LAINNYA], ['class' => 'btn btn-warning btn-sm btn-pill btn-elevate btn-elevate-air']) ?>
                                                        <?php endif; ?>
                                                        <?= Html::a('<i class ="la la-trash"></i>&nbsp; Hapus', ['led/hapus-detail'], [
                                                            'class' => 'btn btn-danger btn-sm btn-pill btn-elevate btn-elevate-air',
                                                            'data' => [
                                                                'method' => 'POST',
                                                                'confirm' => 'Apakah anda yakin menghapus item ini?',
                                                                'params' => ['dokumen' => $v->id, 'kriteria' => $kriteria, 'led' => $_GET['led'], 'jenis' => Constants::LAINNYA, 'prodi' => $prodi]
                                                            ]
                                                        ]) ?>
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

                <?php endforeach; ?>
            </div>

            <!--end::Accordion-->

        </div>
    </div>
</div>

