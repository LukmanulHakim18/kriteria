<?php

/**
 * @var $this yii\web\View
 * @var $profilInstitusi common\models\ProfilInstitusi[]
 * @var $kegiatanUnit common\models\unit\KegiatanUnit[]
 * @var $berkasFakultas common\models\Berkas[]
 *
 */


use yii\bootstrap4\Html;

$this->title = 'Shared Resource'


?>

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
              Resource
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-wrapper">
                <div class="kt-portlet__head-actions">
                </div>
            </div>
        </div>
    </div>

    <div class="kt-portlet__body">

        <ul class="nav nav-tabs  nav-tabs-line nav-tabs-line-brand" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#kt_tabs_9_1" role="tab"><i class="flaticon-time-2"></i> Institusi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#kt_tabs_9_2" role="tab"><i class="flaticon2-edit"></i> Fakultas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#kt_tabs_9_3" role="tab"><i class="flaticon-multimedia"></i> Unit</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="kt_tabs_9_1" role="tabpanel">
              <?= $this->render('_institusi', ['profilInstitusi'=>$profilInstitusi]) ?>
            </div>
            <div class="tab-pane" id="kt_tabs_9_2" role="tabpanel">
               <?=$this->render('_fakultas', ['berkasFakultas'=>$berkasFakultas])?>
            </div>
            <div class="tab-pane" id="kt_tabs_9_3" role="tabpanel">
               <?=$this->render('_unit', ['kegiatanUnit'=>$kegiatanUnit])?>
            </div>
        </div>
    </div>
</div>