<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\Berkas */
/* @var $form yii\bootstrap4\ActiveForm;
*/
?>


<div class="berkas-form">

    <?php $form = ActiveForm::begin(['id'=>'berkas-form']); ?>

    <?= $form->field($model, 'external_id')->textInput() ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_berkas')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

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