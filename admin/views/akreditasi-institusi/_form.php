<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\kriteria9\akreditasi\K9AkreditasiInstitusi */
/* @var $form yii\bootstrap4\ActiveForm; */
/* @var $dataAkreditasi [] */
/* @var $dataProdi []*/
?>


<div class="k9-akreditasi-prodi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=    $form->field($model, 'id_akreditasi')->widget(Select2::class,
        ['data' => $dataAkreditasi,
            'options' => ['placeholder' => 'Pilih Akreditasi']])->label('Akreditasi') ?>



    <div class="form-group">
        <?= Html::submitButton('<i class=\'la la-save\'></i> Simpan', ['class' => 'btn btn-pill btn-elevate btn-elevate-air btn-brand']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
