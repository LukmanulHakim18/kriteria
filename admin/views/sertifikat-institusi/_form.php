<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\sertifikat\SertifikatInstitusi */
/* @var $form yii\bootstrap4\ActiveForm;
*/
?>


<div class="sertifikat-institusi-form">

    <?php $form = ActiveForm::begin(['id'=>'sertifikat-institusi-form']); ?>

    <?= $form->field($model, 'nama_institusi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_lembaga')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tgl_akreditasi')->textInput() ?>

    <?= $form->field($model, 'tgl_kadaluarsa')->textInput() ?>

    <?= $form->field($model, 'nomor_sk')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nomor_sertifikat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nilai_angka')->textInput() ?>

    <?= $form->field($model, 'nilai_huruf')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tahun_sk')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tanggal_pengajuan')->textInput() ?>

    <?= $form->field($model, 'tanggal_diterima')->textInput() ?>

    <?= $form->field($model, 'is_publik')->textInput() ?>

    <?= $form->field($model, 'dokumen_sk')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sertifikat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

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