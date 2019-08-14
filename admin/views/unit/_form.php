<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\Unit */
/* @var $form yii\bootstrap4\ActiveForm;
*/
?>


<div class="unit-form">

    <?php $form = ActiveForm::begin(['id'=>'form-adryan']); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class=\'la la-save\'></i> Simpan', ['class' => 'btn btn-pill btn-elevate btn-elevate-air btn-brand']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php



//$this->registerJsFile('@web/js/pages/my-script.js',['depends'=>\yii\web\YiiAsset::class]) ?>
