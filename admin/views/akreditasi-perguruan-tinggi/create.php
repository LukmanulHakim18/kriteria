<?php

use common\models\kriteria9\akreditasi\K9Akreditasi;
use common\models\ProgramStudi;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\kriteria9\akreditasi\K9AkreditasiInstitusi */
/* @var $dataAkreditasi K9Akreditasi[] */

$this->title = 'Tambah Akreditasi Perguruan Tinggi';
$this->params['breadcrumbs'][] = ['label' => 'Akreditasi Perguruan Tinggi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12">

        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="flaticon2-add-1"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        <?= Html::encode($this->title) ?>
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="k9-akreditasi-prodi-create">

                    <?= $this->render('_form', [
                        'model' => $model,
                        'dataAkreditasi'=>$dataAkreditasi,
                    ]) ?>


                </div>
            </div>
        </div>
        <!--end::Portlet-->

    </div>
</div>

