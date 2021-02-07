<?php

/**
 * @var $this yii\web\View
 * @var $model common\models\kriteria9\akreditasi\K9AkreditasiInstitusi
 * @var $profil common\models\Profil
 * @var $profilInstitusi array
 */

use yii\bootstrap4\Html;
use yii\bootstrap4\Progress;

$url = ['akreditasi/detail-pt', 'id' => $model->id]
?>
<div class="row">
    <div class="col-lg-12">
        <div class="kt-portlet kt-portlet--height-fluid">
            <div class="kt-portlet__body">
                <div class="kt-widget kt-widget--user-profile-3">
                    <div class="kt-widget__top">
                        <div class="kt-widget__pic kt-widget__pic--danger kt-font-danger kt-font-boldest kt-font-light">
                            <?php
                            $initial = '';
                            $institusi = preg_split('/\s+/', $profilInstitusi['nama']);

                            foreach ($institusi as $word) {
                                $initial .= $word[0];
                            }

                            echo $initial
                            ?>
                        </div>
                        <div class="kt-widget__content">
                            <div class="kt-widget__head">
                                <a href="#" class="kt-widget__username">
                                    <?= $profilInstitusi['nama'] ?>
                                    <i class="flaticon2-correct"></i>
                                </a>
                                <div class="kt-widget__action">
                                    <?= Html::a('Detail', $url, ['class' => 'btn btn-brand btn-sm btn-upper']) ?>
                                </div>
                            </div>
                            <div class="kt-widget__subhead">
                                <a href="#"><i class="flaticon2-new-email"></i><?= $model->akreditasi->nama ?></a>
                                <a href="#"><i class="flaticon2-calendar-3"></i><?= $model->akreditasi->tahun ?></a>
                                <a href="#"><i class="flaticon2-placeholder"></i><?= $model->akreditasi->lembaga ?></a>
                            </div>
                            <div class="kt-widget__info">
                                <div class="kt-widget__desc">
                                    Berikut progress pengisian borang Akreditasi Institusi.
                                </div>
                                <div class="kt-widget__progress">
                                    <div class="kt-widget__text">
                                        Progress
                                    </div>
                                    <?= Progress::widget([
                                        'bars' => [
                                            ['percent' => $model->progress, 'options' => ['class' => 'kt-bg-success']]
                                        ],
                                        'options' => ['class' => 'progress', 'style' => 'height:5px;width:100%']
                                    ]) ?>

                                    <div class="kt-widget__stats">
                                        <?= $model->progress ?>%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-widget__bottom">
                        <div class="kt-widget__item">
                            <div class="kt-widget__icon">
                                <i class="flaticon-piggy-bank"></i>
                            </div>
                            <div class="kt-widget__details">
                                <span class="kt-widget__title">Laporan Evaluasi Diri</span>
                                <span class="kt-widget__value">  <?= Progress::widget([
                                        'bars' => [
                                            [
                                                'percent' => $model->k9LedInstitusi->progress,
                                                'options' => ['class' => 'kt-bg-success']
                                            ]
                                        ],
                                        'options' => ['class' => 'progress', 'style' => 'height:5px;width:100%']
                                    ]) ?>

                                    <div class="kt-widget__stats">
                                       <span><?= $model->k9LedInstitusi->progress ?>%</span>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="kt-widget__item">
                            <div class="kt-widget__icon">
                                <i class="flaticon-confetti"></i>
                            </div>
                            <div class="kt-widget__details">
                                <span class="kt-widget__title">Laporan Kinerja</span>
                                <span class="kt-widget__value">  <?= Progress::widget([
                                        'bars' => [
                                            [
                                                'percent' => $model->k9LkInstitusi->progress,
                                                'options' => ['class' => 'kt-bg-success']
                                            ]
                                        ],
                                        'options' => ['class' => 'progress', 'style' => 'height:5px;width:100%']
                                    ]) ?>

                                    <div class="kt-widget__stats">
                                       <span><?= $model->k9LkInstitusi->progress ?>%</span>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="kt-widget__item">
                            <div class="kt-widget__icon">
                                <i class="flaticon-pie-chart"></i>
                            </div>
                            <div class="kt-widget__details">
                                <span class="kt-widget__title">Matriks Kuantitatif</span>
                                <span
                                    class="kt-widget__value"><?= $model->kuantitatif ? Html::button('<i class="flaticon2-arrow-down"></i> Download',
                                        [
                                            'class' => 'btn btn-success btn-sm btn-pill btn-elevate btn-elevate-air showModalButton',
                                            'value' => \yii\helpers\Url::to([
                                                '/kuantitatif/institusi',
                                                'id' => $model->id
                                            ]),
                                            'title' => 'Berkas Kuantitatif Institusi'
                                        ]) : 'Belum' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
