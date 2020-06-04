<?php

use akreditasi\models\unit\KegiatanDetailUploadForm;
use common\helpers\FileIconHelper;
use common\helpers\FileTypeHelper;
use common\models\Constants;
use dosamigos\tinymce\TinyMce;
use kartik\datecontrol\DateControl;
use kartik\datecontrol\Module;
use kartik\datetime\DateTimePicker;
use kartik\file\FileInput;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$unit = $_GET['unit'];

/* @var $this yii\web\View */
/* @var $model akreditasi\models\unit\KegiatanUnitForm */
/* @var $form yii\bootstrap4\ActiveForm; */

$action = Yii::$app->controller->action->id;
?>

<div class="kegiatan-unit-form">

    <?php $form = ActiveForm::begin(['id'=>'kegiatan-unit-form','options' => ['enctype'=>'multipart/form-data']]); ?>


    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'waktu_mulai')->widget(DateControl::class,[
            'type' => Module::FORMAT_DATETIME,
            'widgetOptions' => [
                    'pluginOptions'=>['autoclose'=>true]
            ]
    ]) ?>

    <?= $form->field($model, 'waktu_selesai')->widget(DateControl::class,[
        'type' => Module::FORMAT_DATETIME,
        'widgetOptions' => [
            'pluginOptions'=>['autoclose'=>true]
        ]
    ]) ?>

    <?= $form->field($model, 'deskripsi')->widget(TinyMce::class,[
            'options'=>['rows' => 6]
    ]) ?>

    <?=$form->field($model,'sk_kegiatan')->widget(FileInput::className(),[
        'pluginOptions' => [
            'theme' => 'explorer-fas',
            'maxFileSize' => Constants::MAX_UPLOAD_SIZE(),
            'allowedFileExtensions' => Constants::ALLOWED_EXTENSIONS,
            'showUpload' => false,
            'fileActionSettings' => [
                'showZoom' => true,
                'showRemove' => false,
                'showUpload' => false,
            ],
        ]
    ])?>
    <?=$form->field($model,'laporan_kegiatan')->widget(FileInput::className(),[
        'pluginOptions' => [
            'theme' => 'explorer-fas',
            'maxFileSize' => Constants::MAX_UPLOAD_SIZE(),
            'allowedFileExtensions' => Constants::ALLOWED_EXTENSIONS,
            'showUpload' => false,
            'fileActionSettings' => [
                'showZoom' => true,
                'showRemove' => false,
                'showUpload' => false,
            ],
        ]
    ])?>
    <?=$form->field($model,'absensi')->widget(FileInput::className(),[
        'pluginOptions' => [
            'theme' => 'explorer-fas',
            'maxFileSize' => Constants::MAX_UPLOAD_SIZE(),
            'allowedFileExtensions' => Constants::ALLOWED_EXTENSIONS,
            'showUpload' => false,
            'fileActionSettings' => [
                'showZoom' => true,
                'showRemove' => false,
                'showUpload' => false,
            ],
        ]
    ])?>

    <?= $form->field($model, 'foto_kegiatan[]')->widget(FileInput::class,[
            'options' => ['multiple'=>true],
            'pluginOptions' => [
            'theme' => 'explorer-fas',
            'maxFileSize' => Constants::MAX_UPLOAD_SIZE(),
            'allowedFileExtensions' => Constants::ALLOWED_EXTENSIONS,
            'showUpload' => false,
            'fileActionSettings' => [
                'showZoom' => true,
                'showRemove' => false,
                'showUpload' => false,
            ],
        ]
    ]) ?>
    <?= $form->field($model, 'sertifikat[]')->widget(FileInput::class,[
        'options' => ['multiple'=>true],
        'pluginOptions' => [
            'theme' => 'explorer-fas',
            'maxFileSize' => Constants::MAX_UPLOAD_SIZE(),
            'allowedFileExtensions' => Constants::ALLOWED_EXTENSIONS,
            'showUpload' => false,
            'fileActionSettings' => [
                'showZoom' => true,
                'showRemove' => false,
                'showUpload' => false,
            ],
        ]
    ]) ?>

    <?= $form->field($model, 'dokumen_lainnya[]')->widget(FileInput::class,[
        'options' => ['multiple'=>true],
        'pluginOptions' => [
            'theme' => 'explorer-fas',
            'maxFileSize' => Constants::MAX_UPLOAD_SIZE(),
            'allowedFileExtensions' => Constants::ALLOWED_EXTENSIONS,
            'showUpload' => false,
            'fileActionSettings' => [
                'showZoom' => true,
                'showRemove' => false,
                'showUpload' => false,
            ],
        ]
    ]) ?>





    <div class="form-group">
        <?= Html::submitButton('<i class=\'la la-save\'></i> Simpan', ['class' => 'btn btn-pill btn-elevate btn-elevate-air btn-brand']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php if($action === 'update'):
        $detailData = $model->getKegiatan()->kegiatanUnitDetails;
        ?>

        <div class="row">
            <div class="col-lg-12 table-responsive">
                <table class="table table-striped table-light">
                    <thead class="thead-dark">
                    <tr>
                        <th class="text-center">Nama berkas</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($detailData as $datum) :?>
                        <tr>
                            <td>
                                <div class="row">
                                    <div class="col-lg-12 text-center">

                                        <?= FileIconHelper::getIconByExtension($datum->bentuk_file) ?>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <?= \yii\bootstrap4\Html::encode($datum->nama_file) ?>

                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="row pull-right">
                                    <div class="col-lg-12 ">
                                        <?php $type = FileTypeHelper::getType($datum->bentuk_file);
                                        if ($type === FileTypeHelper::TYPE_IMAGE || $type === FileTypeHelper::TYPE_PDF || $type ===FileTypeHelper::TYPE_STATIC_TEXT):?>

                                            <?php Modal::begin([
                                                'title' => $model->nama,
                                                'toggleButton' => ['label' => '<i class="la la-eye"></i> &nbsp;Lihat', 'class' => 'btn btn-info btn-pill btn-elevate btn-elevate-air'],
                                                'size' => 'modal-lg',
                                                'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                            ]); ?>
                                            <?php switch ($type) {
                                                case FileTypeHelper::TYPE_IMAGE:
                                                    echo \yii\bootstrap4\Html::img("$path/{$datum->isi_file}", ['height' => '100%', 'width' => '100%']);
                                                    break;
                                                case FileTypeHelper::TYPE_STATIC_TEXT:
                                                    echo $datum->isi_file;
                                                    break;
                                                case FileTypeHelper::TYPE_PDF:
                                                    echo '<embed src="' . $path . '/' . $datum->isi_file . '" type="application/pdf" height="100%" width="100%">
';
                                                    break;
                                            } ?>
                                            <?php Modal::end(); ?>


                                        <?php endif; ?>
                                        <?= Html::a('<i class="la la-download"></i>&nbsp;Unduh', ['kegiatan/download-detail','dokumen'=>$datum->id,'unit'=>$unit,'id'=>$_GET['id']], ['class' => 'btn btn-warning btn-pill btn-elevate btn-elevate-air']) ?>

                                        <?= Html::a('<i class ="la la-trash"></i>&nbsp; Hapus', ['kegiatan/hapus-detail'], [
                                            'class' => 'btn btn-danger btn-pill btn-elevate btn-elevate-air',
                                            'data' => [
                                                'method' => 'POST',
                                                'confirm' => 'Apakah anda yakin menghapus item ini?',
                                                'params' => ['dokumen'=>$datum->id,'unit'=>$unit,'id'=>$_GET['id']]
                                            ]
                                        ]) ?>
                                    </div>

                                </div>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php $js = <<<JS
 $('form').on('beforeSubmit', function()
    {
        var form = $(this);
        //console.log('before submit');

        var submit = form.find(':submit');
        KTApp.block('.modal',{
            overlayColor: '#000000',
            type: 'v2',
            state: 'primary',
            message: 'Sedang Memproses...'
        });
        submit.html('<i class="flaticon2-refresh"></i> Sedang Memproses');
        submit.prop('disabled', true);

        KTApp.blockPage({
            overlayColor: '#000000',
            type: 'v2',
            state: 'primary',
            message: 'Sedang memproses...'
        });

    });

JS;

$this->registerJs($js);
?>