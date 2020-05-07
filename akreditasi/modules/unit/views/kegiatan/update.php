<?php

use akreditasi\models\unit\KegiatanDetailUploadForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\unit\KegiatanUnit */
/* @var $detailModel KegiatanDetailUploadForm */
/* @var $detailData []*/

$this->title = 'Ubah Kegiatan Unit: ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Kegiatan Unit', 'url' => ['index','unit'=>$_GET['unit']]];
$this->params['breadcrumbs'][] = ['label' => $model->nama, 'url' => ['view', 'id' => $model->id,'unit'=>$_GET['unit']]];
$this->params['breadcrumbs'][] = 'Ubah';
?>

<div class="row">
    <div class="col-lg-12">

        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="flaticon2-edit"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        <?= Html::encode($this->title) ?>
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kegiatan-unit-update">

                    <?= $this->render('_form', [
                    'model' => $model,
                        'detailModel'=>$detailModel,
                        'detailData'=>$detailData,
                        'path'=>$path


                    ]) ?>

                </div>
            </div>
        </div>
        <!--end::Portlet-->

    </div>
</div>



