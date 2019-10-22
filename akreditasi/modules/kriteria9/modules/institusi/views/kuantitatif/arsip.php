<?php


use demogorgorn\ajax\AjaxSubmitButton;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\web\JsExpression;

/* @var $modelInstitusi */
/* @var $dataAkreInstitusi */

$this->title = "Pencarian Data Kuantitatif Program Studi";

$this->params['breadcrumbs'][] = ['label'=>'Beranda','url'=>['/site/index']];
$this->params['breadcrumbs'][] = ['label'=>'9 Kriteria','url'=>['/site/index']];
$this->params['breadcrumbs'][] = ['label'=>'Data Institusi','url'=>['/kriteria9/k9-institusi/default/index']];

?>
<!--card-->

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Form Pencarian Data Institusi
            </h3>
        </div>
    </div>

    <!--begin::Form-->
    <div class="kt-portlet__body">

        <?php $form = ActiveForm::begin(['id' => 'form-pencarian-dokumentasi', 'options' => ['class' => 'kt-form']]) ?>

        <?= $form->field($modelInstitusi, 'akreditasi_ins')->dropDownList($dataAkreInstitusi,['prompt'=>'Pilih Akreditasi'])?>

        <div class="kt-form__actions">

            <?php


            echo Html::submitButton('<i class="la la-search"></i> Cari', ['class' => 'btn btn-success btn-pill btn-elevate btn-elevate-air']);

            ?>

        </div>

        <?php ActiveForm::end() ?>


    </div>

    <!--end::Form-->
</div>

<div id="hasil-arsip"></div>

