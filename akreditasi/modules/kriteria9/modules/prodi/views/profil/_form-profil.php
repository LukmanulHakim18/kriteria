<?php

use common\models\Constants;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\ProgramStudi */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $profil common\models\Profil */
/* @var $strukturModel akreditasi\models\StrukturOrganisasiUploadForm */
?>


<div class="profil-program-studi-form">

    <?php $form = ActiveForm::begin(['id' => 'profil-prodi-form']); ?>

    <?= $form->field($profil, 'visi')->textInput(['maxlength' => true]) ?>
    <?= $form->field($profil, 'misi')->textInput(['maxlength' => true]) ?>
    <?= $form->field($profil, 'tujuan')->textInput(['maxlength' => true]) ?>
    <?= $form->field($profil, 'sasaran')->textInput(['maxlength' => true]) ?>
    <?= $form->field($profil, 'motto')->textInput(['maxlength' => true]) ?>
    <?= $form->field($profil, 'sambutan')->textInput(['maxlength' => true]) ?>
    <?= $form->field($strukturModel, 'struktur')->widget(FileInput::class,[

        'pluginOptions' => [
            'theme' => 'explorer-fas',
            'maxFileSize' => Constants::MAX_UPLOAD_SIZE,
            'allowedFileExtensions' => Constants::IMAGE_EXTENSIONS,
            'showUpload' => false,
            'previewFileType' => 'any',
            'fileActionSettings' => [
                'showZoom' => true,
                'showRemove' => false,
                'showUpload' => false,
            ],
        ]
    ]) ?>


    <div class="form-group">
        <?= Html::submitButton('<i class=\'la la-save\'></i> Simpan', ['class' => 'btn btn-pill btn-elevate btn-elevate-air btn-brand block-ui']) ?>
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
