<?php

use kartik\date\DatePicker;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\sertifikat\SertifikatInstitusi */
/* @var $namaInstitusi */
/* @var $form yii\bootstrap4\ActiveForm;
 */
?>


    <div class="sertifikat-institusi-form">

        <?php $form = ActiveForm::begin(['id' => 'sertifikat-perguruan-tinggi-form']); ?>

        <?= $form->field($model, 'nama_institusi')->textInput(['readonly' => true, 'value' => $namaInstitusi]) ?>

        <?= $form->field($model, 'nama_lembaga')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'tgl_akreditasi')->widget(DatePicker::class, [
            'name' => 'check_date1',
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd-MM-yyyy'
            ]
        ]) ?>

        <?= $form->field($model, 'tgl_kadaluarsa')->widget(DatePicker::class, [
            'name' => 'check_date2',
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd-MM-yyyy'
            ]
        ]) ?>

        <?= $form->field($model, 'nomor_sk')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'nomor_sertifikat')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'nilai_angka')->textInput() ?>

        <?= $form->field($model, 'nilai_huruf')->widget(Select2::class, [
            'data' => ['A' => 'A', 'B' => 'B', 'C' => 'C'],
            'options' => [
                'placeholder' => 'Pilih Nilai Huruf'
            ]
        ])->label('Nilai Huruf') ?>

        <?= $form->field($model, 'tahun_sk')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'tanggal_pengajuan')->widget(DatePicker::class, [
            'name' => 'check_date3',
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd-MM-yyyy'
            ]
        ]) ?>

        <?= $form->field($model, 'tanggal_diterima')->widget(DatePicker::class, [
            'name' => 'check_date4',
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd-MM-yyyy'
            ]
        ]) ?>

        <?= $form->field($model, 'is_publik')->widget(Select2::class, [
            'data' => [1 => 'Publik', 0 => 'Tidak Publik'],
            'options' => [
                'placeholder' => 'Pilih Keterangan Dokumen'
            ]
        ])->label('Keterangan Dokumen') ?>

        <?= $form->field($model, 'dokumen_sk')->widget(FileInput::class, [
            'options' => ['id' => 'dokumen1'],
            'pluginOptions' => [
                'showUpload' => false
            ]
        ])->label('Dokumen SK : <strong>' . $model->dokumen_sk . '</strong> - <small>Upload ulang, untuk Ganti dokumen</small>') ?>

        <?= $form->field($model, 'sertifikat')->widget(FileInput::class, [
            'options' => ['id' => 'dokumen2'],
            'pluginOptions' => [
                'showUpload' => false
            ]
        ])->label('Sertifikat : <strong>' . $model->sertifikat . '</strong> - <small>Upload ulang, untuk Ganti dokumen</small>') ?>


        <div class="form-group">
            <?= Html::submitButton('<i class=\'la la-save\'></i> Simpan', ['class' => 'btn btn-pill btn-elevate btn-elevate-air btn-brand']) ?>
        </div>

        <?php ActiveForm::end(); ?>

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