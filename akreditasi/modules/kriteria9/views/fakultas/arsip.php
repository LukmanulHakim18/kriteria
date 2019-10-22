<?php

use common\models\FakultasAkademi;
use common\models\ProgramStudi;
use common\models\standar7\akreditasi\S7Akreditasi;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var $dataFakultas [FakultasAkademi]
 * @var $this View
 */


$this->title = "Pencarian Data Fakultas";

$this->params['breadcrumbs'][] = ['label'=>'Beranda','url'=>['/site/index']];
$this->params['breadcrumbs'][] = ['label'=>'9 Kriteria','url'=>['/kriteria9/default/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<!--card-->

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Form <?=Html::encode($this->title)?>
            </h3>
        </div>
    </div>

    <!--begin::Form-->

        <div class="kt-portlet__body">

                <?php $form = ActiveForm::begin() ?>


                <?= $form->field($model, 'id_fakultas')->widget(Select2::class, [
                    'data' => $dataFakultas,
                    'options' => [
                        'placeholder' => 'Pilih Fakultas'
                    ]
                ])->label('Fakultas') ?>

                <div class="kt-form__actions">
                    <?= Html::submitButton('<i class="la la-search"></i> Cari', ['class' => 'btn btn-success btn-pill btn-elevate btn-elevate-air']) ?>
                </div>

                <?php ActiveForm::end() ?>


        </div>


    <!--end::Form-->
</div>

