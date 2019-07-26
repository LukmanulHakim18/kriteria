<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\ProgramStudi */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $dataFakultas \common\models\FakultasAkademi[] */
?>


<div class="program-studi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kode')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'kaprodi')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'jurusan_departemen')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jenjang')->widget(Select2::class,[
        'data'=>['S1'=>'S1','S2'=>'S2'],
        'options' => ['class'=>'kt-select2'],
    ])->label('Jenjang') ?>

    <?= $form->field($model, 'id_fakultas_akademi')->widget(Select2::class,[
        'data'=>$dataFakultas,
        'options' => ['class'=>'kt-select2'],
    ])->label('Fakultas/Akademi') ?>

    <?= $form->field($model, 'nomor_sk_pendirian')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'tanggal_sk_pendirian')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'pejabat_ttd_sk_pendirian')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'bulan_berdiri')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'tahun_berdiri')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'nomor_sk_operasional')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'tanggal_sk_operasional')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'peringkat_banpt_terakhir')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'nilai_banpt_terakhir')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'nomor_sk_banpt')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'alamat')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'kodepos')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'nomor_telp')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'homepage')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class=\'la la-save\'></i> Simpan', ['class' => 'btn btn-pill btn-elevate btn-elevate-air btn-brand']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
