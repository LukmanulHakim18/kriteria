<?php

use common\models\Constants;
use common\models\standar7\akreditasi\S7AkreditasiInstitusi;
use common\models\standar7\kuantitatif\institusi\S7DataKuantitatifInstitusi;
use kartik\file\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;

/* @var $dataKuantitatifInstitusi S7DataKuantitatifInstitusi */
/* @var $model S7DataKuantitatifInstitusi */
/* @var $akreinstitusi S7AkreditasiInstitusi */

$this->title = "Data Kuantitatif";
$this->params['breadcrumbs'][] = ['label'=>'Beranda','url'=>['/site/index']];
$this->params['breadcrumbs'][] = ['label'=>'9 Kriteria','url'=>['/site/index']];
$this->params['breadcrumbs'][] = ['label'=>'Data Institusi','url'=>['/kriteria/k9-institusi/default/index']];
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Form Isi Data Kuantitatif <?= $akreinstitusi->akreditasi->nama ?>

            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-actions">

            </div>
        </div>
    </div>

    <div class="kt-portlet__body">
        <div class="kt-section kt-section--first" style="margin-bottom: 0;">

            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th colspan="2">Dokumen Kuantitatif</th>

                </tr>
                </thead>
                <tbody>

                <?php

                if ($dataKuantitatifInstitusi != null) {
                    foreach ($dataKuantitatifInstitusi as $item):?>
                        <tr>
                            <td>
                                <?= $item->nama_dokumen ?>
                            </td>
                            <td>

                                <?=Html::a('<i class ="la la-download"></i> Unduh',['kuantitatif/download-dokumen','dokumen'=>$item->id],['class'=>'btn btn-pill btn-elevate btn-elevate-air btn-info']) ?>
                                <?=Html::a('<i class ="la la-trash"></i> Hapus',['kuantitatif/hapus-dokumen'],['class'=>'btn btn-pill btn-elevate btn-elevate-air btn-danger','data'=>[
                                    'method'=>'POST',
                                    'confirm'=>'Apakah anda yakin menghapus '.$item->nama_dokumen.' ?',
                                    'params'=>['id'=>$item->id, 'id_institusi'=>$item->id_akreditasi_institusi]
                                ]])?>
                            </td>
                        </tr>
                    <?php
                    endforeach;
                } else {
                    ?>
                    <tr>
                        <td>
                            <p style="font-size: 14px;font-weight: 400">Silahkan Unggah Data Kuantitatif</p>
                        </td>
                        <td style="padding-top: 15px;" class="text-right">
                            <?php Modal::begin([
                                'title' => 'Upload Dokumen Dokumentasi',
                                'toggleButton' => ['label' => '<i class="la la-upload"></i> &nbsp;Unggah','class'=>'btn btn-light btn-pill btn-sm btn-elevate btn-elevate-air pull-right'],
                                'size' => 'modal-lg',
                                'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                            ]); ?>

                            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

                            <?= $form->field($model,'nama_dokumen')->widget(FileInput::class,[

                                'pluginOptions' => [
                                    'theme' => 'explorer-fas',
                                    'showUpload' => false,
                                    'maxFileSize' => Constants::MAX_UPLOAD_SIZE(),
                                    'allowedFileExtensions' => ['xls', 'xlsx', 'csv', 'ods'],
                                    'previewFileType' => 'any',
                                    'fileActionSettings' => [
                                        'showZoom' => true,
                                        'showRemove' => false,
                                        'showUpload' => false,
                                    ],
                                ]
                            ]) ?>

                            <div class="form-group text-right">
                                <?=Html::submitButton("<i class='la la-save'></i> Simpan",['class'=>'btn btn-pill btn-elevate btn-elevate-air btn-primary ']) ?>
                            </div>
                            <?php ActiveForm::end() ?>

                            <?php Modal::end(); ?>
                        </td>
                    </tr>

                    <?php
                }
                ?>


                </tbody>
            </table>





            <!--end::Accordion-->

        </div>
    </div>
</div>

