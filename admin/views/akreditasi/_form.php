<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\kriteria9\akreditasi\K9Akreditasi */
/* @var $form yii\bootstrap4\ActiveForm;
*/
?>


<div class="k9-akreditasi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tahun')->textInput(['maxlength' => true,'value'=>date('Y')]) ?>

    <?= $form->field($model, 'jenis_akreditasi')->dropDownList(['prodi'=>'Program Studi','institusi'=>'Perguruan Tinggi'],['prompt'=>'Pilih Jenis Akreditasi']) ?>

    <?= $form->field($model, 'lembaga')->textInput(['value'=>'BAN-PT','readonly'=>'true']) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class=\'la la-save\'></i> Simpan', ['class' => 'btn btn-pill btn-elevate btn-elevate-air btn-brand']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$jsForm = <<<JS
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
        
    });

JS;

$this->registerJs($jsForm);
?>