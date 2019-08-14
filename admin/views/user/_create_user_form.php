<?php

use common\models\User;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 *  @var $dataFakultas []
 *  @var $dataRoles []
 */

?>



<div class="create_user_form">

    <?php $form = ActiveForm::begin([
            'enableClientValidation' => true,
        'enableAjaxValidation' => true,
        'id' => 'create-user-form'
    ]); ?>

    <?= $form->field($model, 'username')->textInput(['prompt'=>'username']) ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'status')->dropDownList([User::STATUS_ACTIVE => 'Aktif', User::STATUS_INACTIVE => 'Tidak Aktif'], ['prompt' => 'Pilih Status User']) ?>
    <?= $form->field($model, 'hak_akses')->dropDownList( $dataRoles,['prompt'=>'Pilih Hak Akses']) ?>

    <?= $form->field($model, 'nama_lengkap')->textInput() ?>
    <?= $form->field($model, 'id_fakultas')->widget(Select2::class, [
        'data' => $dataFakultas,
        'name' => 'id_fakultas',
        'options' => [
            'placeholder' => 'Pilih Fakultas/Akademi',
            'id' => 'id_fakultas',
        ]
    ]) ?>
    <?= $form->field($model, 'id_prodi')->widget(DepDrop::class, [
        'options' => ['id' => 'id_prodi'],
        'type' => DepDrop::TYPE_SELECT2,
        'pluginOptions' => [
            'depends' => ['id_fakultas'],
            'placeholder' => 'Pilih Program Studi',
            'url' => [\yii\helpers\Url::toRoute(['user/get-prodi'])],

        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class=\'la la-save\'></i> Simpan', ['class' => 'btn btn-pill btn-elevate btn-elevate-air btn-brand']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- create_user_form -->
