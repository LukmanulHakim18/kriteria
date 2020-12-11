<?php

use common\models\ProgramStudi;
use common\models\standar7\kuantitatif\prodi\S7DataKuantitatifProdi;
use yii\bootstrap4\Html;

/* @var $dataKuantitatifProdi S7DataKuantitatifProdi */
/* @var $model S7DataKuantitatifProdi */
/* @var $akreprodis1 ProgramStudi */

$this->title = "Data Kuantitatif";
$this->params['breadcrumbs'][] = ['label' => 'Beranda', 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = ['label' => '9 Kriteria', 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = [
    'label' => 'Program Studi',
    'url' => ['/kriteria9/k7-prodi/default/index', 'prodi' => $_GET['prodi']]
];
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Form Data Kuantitatif

            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-actions">
                <?= Html::a('Export Kuantitatif', ['kuantitatif/export'],
                    ['class' => 'btn btn-primary btn-pill btn-elevate btn-elevate-air']) ?>
            </div>
        </div>
    </div>

    <div class="kt-portlet__body">
        <div class="kt-section kt-section--first" style="margin-bottom: 0;">


            <!--                            Tabel LED-->
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th colspan="2">Dokumen Kuantitatif</th>

                </tr>
                </thead>
                <tbody>

                <?php

                if ($dataKuantitatifProdi != null) {
                    foreach ($dataKuantitatifProdi as $item):?>
                        <tr>
                            <td>
                                <?= $item->nama_dokumen ?>
                            </td>
                            <td>

                                <?= Html::a('<i class ="la la-download"></i> Unduh',
                                    ['kuantitatif/download-dokumen', 'dokumen' => $item->id, 'prodi' => $_GET['prodi']],
                                    ['class' => 'btn btn-pill btn-elevate btn-elevate-air btn-info']) ?>
                                <?= Html::a('<i class ="la la-trash"></i> Hapus', ['kuantitatif/hapus-dokumen'], [
                                    'class' => 'btn btn-pill btn-elevate btn-elevate-air btn-danger',
                                    'data' => [
                                        'method' => 'POST',
                                        'confirm' => 'Apakah anda yakin menghapus ' . $item->nama_dokumen . ' ?',
                                        'params' => ['id' => $item->id, 'prodi' => $_GET['prodi']]
                                    ]
                                ]) ?>
                            </td>
                        </tr>
                    <?php
                    endforeach;
                }
                ?>


                </tbody>
            </table>


            <!--end::Accordion-->

        </div>
    </div>
</div>

