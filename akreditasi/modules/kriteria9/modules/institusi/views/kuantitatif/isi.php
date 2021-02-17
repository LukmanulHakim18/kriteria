<?php

use common\models\standar7\akreditasi\S7AkreditasiInstitusi;
use common\models\standar7\kuantitatif\institusi\S7DataKuantitatifInstitusi;
use yii\bootstrap4\Html;
use yii\helpers\Url;

/* @var $dataKuantitatifInstitusi S7DataKuantitatifInstitusi */
/* @var $model S7DataKuantitatifInstitusi */
/* @var $akreinstitusi S7AkreditasiInstitusi */

$this->title = "Data Kuantitatif";
$this->params['breadcrumbs'][] = ['label' => 'Beranda', 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = ['label' => '9 Kriteria', 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = ['label' => 'Data Institusi', 'url' => ['/kriteria/k9-institusi/default/index']];
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Form Data Kuantitatif <?= $akreinstitusi->akreditasi->nama ?>

            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-actions">
                <?= Html::button('<i class="la la-upload"></i> Unggah Kuantitatif', [
                    'class' => 'btn btn-primary btn-pill btn-elevate btn-elevate-air showModalButton',
                    'value' => Url::to(['kuantitatif/isi', 'id' => $akreinstitusi->id]),
                    'title' => 'Unggah Data Kuantitatif'
                ]) ?>
                <?= Html::a('<i class="fas fa-file-excel"></i> Export Kuantitatif', ['kuantitatif/export'],
                    [
                        'class' => 'btn btn-success btn-pill btn-elevate btn-elevate-air',
                        'data-method' => 'POST',
                        'data-params' => ['akreditasiInstitusi' => $akreinstitusi->id],
                        'data-confirm' => 'Apakah anda yakin membuat Excel Kuantitatif baru? (Data yang lama akan dihapus)'
                    ]) ?>
            </div>
        </div>
    </div>

    <div class="kt-portlet__body">
        <div class="kt-section kt-section--first" style="margin-bottom: 0;">

            <div class="alert alert-warning">
                Hasil Ekspor Kuantitatif masih beta dan belum sempurna, mohon diperiksa hasilnya.
            </div>

            <?= \kartik\grid\GridView::widget([
                'dataProvider' => $dataKuantitatifInstitusi,
                'summary' => false,
                'columns' => [
                    ['class' => \kartik\grid\SerialColumn::class, 'header' => 'No'],
                    'nama_dokumen',
                    'isi_dokumen',
                    'created_at:datetime',
                    'sumber',
                    [
                        'class' => \common\widgets\ActionColumn::class,
                        'header' => 'Aksi',
                        'template' => '{lihat}{download}{hapus}',
                        'buttons' => [
                            'lihat' => function ($url, $model, $key) {
                                return Html::button('<i class="la la-eye"></i>',
                                    [
                                        'class' => 'showModalButton btn btn-pill btn-sm btn-elevate btn-elevate-air btn-primary',
                                        'value' => \yii\helpers\Url::to(['show', 'id' => $model->id]),
                                        'title' => $model->nama_dokumen
                                    ]);
                            },
                            'download' => function ($url, $model, $key) {
                                return Html::a('<i class ="la la-download"></i>',
                                    ['kuantitatif/download-dokumen', 'dokumen' => $model->id],
                                    ['class' => 'btn btn-pill btn-sm btn-elevate btn-elevate-air btn-warning']);
                            },
                            'hapus' => function ($url, $model, $key) {
                                return Html::a('<i class ="la la-trash"></i>', ['kuantitatif/hapus-dokumen'], [
                                    'class' => 'btn btn-sm btn-pill btn-elevate btn-elevate-air btn-danger',
                                    'data' => [
                                        'method' => 'POST',
                                        'confirm' => 'Apakah anda yakin menghapus ' . $model->nama_dokumen . ' ?',
                                        'params' => ['id' => $model->id]
                                    ]
                                ]);
                            }
                        ]
                    ]
                ]
            ])

            ?>
            <!--end::Accordion-->

        </div>
    </div>
</div>

