<?php

use common\models\ProgramStudi;
use common\models\standar7\akreditasi\S7Akreditasi;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;

/* @var $dataUnit \common\models\Unit*/
/* @var $model \akreditasi\models\PencarianUnitForm */


$this->title = "Pencarian Unit/Lembaga/Satuan Kerja";

$this->params['breadcrumbs'][] = ['label'=>'Beranda','url'=>['/site/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<!--card-->

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Form Pencarian Unit/Lembaga/Satker
            </h3>
        </div>
    </div>

    <!--begin::Form-->

    <div class="kt-portlet__body">

        <?php $form = ActiveForm::begin() ?>


        <?= $form->field($model, 'id_unit')->widget(Select2::class, [
            'data' => $dataUnit,
            'options' => [
                'placeholder' => 'Pilih Unit/Lembaga/Satker'
            ]
        ])->label('Unit/Lembaga/Satker') ?>

        <div class="kt-form__actions">
            <?= Html::submitButton('<i class="la la-search"></i> Cari', ['class' => 'btn btn-success btn-pill btn-elevate btn-elevate-air']) ?>
        </div>

        <?php ActiveForm::end() ?>


    </div>


    <!--end::Form-->
</div>

