<?php
/**
 * @var $this yii\web\View
 * @var $model K9PencarianLedInstitusiForm
 * @var $dataAkreditasi array
 */
$this->title = "Pencarian LED";

$this->params['breadcrumbs'][] = ['label' => 'Beranda', 'url' => ['/site/index']];

$this->params['breadcrumbs'][] = ['label' => '9 Kriteria', 'url' => ['/kriteria9/default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Institusi', 'url' => ['/kriteria9/k9-institusi/default/index']];
$this->params['breadcrumbs'][] = $this->title;


use common\models\kriteria9\forms\led\K9PencarianLedInstitusiForm;
use demogorgorn\ajax\AjaxSubmitButton;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\web\JsExpression;
use yii\widgets\Pjax;

?>
<!--card-->

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Form Pencarian borang
            </h3>
        </div>
    </div>

    <!--begin::Form-->
    <?php $form = ActiveForm::begin(['id' => 'form-pencarian-led', 'options' => ['class' => 'kt-form']]) ?>
    <div class="kt-portlet__body">
        <div class="kt-section kt-section--first" style="margin-bottom: 0;">

            <?= $form->field($model, 'akreditasi')->widget(Select2::class, [
                'data' => $dataAkreditasi,
                'pluginOptions' => ['placeholder' => 'Pilih Akreditasi'],

            ]) ?>

        </div>
    </div>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <?php AjaxSubmitButton::begin([
                'label' => 'Cari',
                'icon' => 'la la-search',
                'useWithActiveForm' => 'form-pencarian-led',
                'ajaxOptions' => [
                    'type' => 'POST',
                    'success' => new JsExpression('function(html){
                        $("#hasil-arsip").html(html);
                        normalizeButton("submit-form");
                    }')

                ],
                'options' => ['class' => 'btn btn-success btn-pill btn-elevate btn-elevate-air', 'type' => 'submit', 'id' => 'submit-form']
            ]);

            AjaxSubmitButton::end();

            ?>


        </div>
    </div>
    <?php ActiveForm::end() ?>

    <!--end::Form-->
</div>

<div id="hasil-arsip"></div>
