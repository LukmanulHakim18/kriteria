<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $fakultasAkademi common\models\FakultasAkademi */
/**
 * @var $model common\models\Profil
 */

$this->title = 'Profil: ' . $fakultasAkademi->nama;
$this->params['breadcrumbs'][] = ['label' => 'Fakultas / Akademi / Pascasarjana', 'url' => ['/fakultas/arsip/index']];
$this->params['breadcrumbs'][] = ['label' => $fakultasAkademi->nama, 'url' => ['default/index', 'fakultas' => $fakultasAkademi->id]];
$this->params['breadcrumbs'][] = $this->title;
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
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">

                            <?= Html::a('<i class=flaticon2-edit></i> Edit Fakultas/Akademi/Pascasarjana', ['profil/update', 'fakultas' => Yii::$app->request->get('fakultas')], ['class' => 'btn btn-info btn-elevate btn-elevate-air']); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="program-studi-fakultas">
                    <?=\yii\widgets\DetailView::widget([
                        'model' => $fakultasAkademi,
                            'attributes' => [
                                'id',
                                'kode',
                                'nama',
                                'dekan',
                                'created_at:datetime',
                                'updated_at:datetime',
                            ],
                        ])?>


                </div>
            </div>
        </div>
        <!--end::Portlet-->

    </div>
</div>

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
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">

                            <?= Html::a('<i class=flaticon2-edit></i> Edit Profil Fakultas/Akademi/Pascasarjana', ['profil/update-profil', 'fakultas' => Yii::$app->request->get('fakultas')], ['class' => 'btn btn-info btn-elevate btn-elevate-air']); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="data-fakultas">
                    <?=\yii\widgets\DetailView::widget([
                            'model' => $fakultasAkademi->profil,
                            'attributes' => [
//                                'id',
                                'visi:html',
                                'misi:html',
                                'tujuan:html',
                                'sasaran:html',
                                'motto:html',
                                'sambutan:html',
                                ['attribute'=>'struktur_organisasi',
                                    'format'=>['image',['width'=>'50%']],
                                    'value'=>function ($model) {
                                        return Yii::getAlias("@.uploadStruktur/{$model->type}/{$model->external_id}/$model->struktur_organisasi");
                                    }]
                            ],
                        ])?>


                </div>
            </div>
        </div>
        <!--end::Portlet-->

    </div>
</div>
