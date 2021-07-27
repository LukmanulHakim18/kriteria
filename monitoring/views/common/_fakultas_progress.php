<?php

/**
 * @var $this yii\web\View
 * @var $model common\models\FakultasAkademi
 * @var $akreditasiTerakhir common\models\kriteria9\akreditasi\K9Akreditasi
 */

use yii\data\ActiveDataProvider;
use yii\widgets\ListView;


?>
<div class="row">
    <div class="col-lg-12">
        <div class="kt-portlet kt-portlet--height-fluid">
            <div class="kt-portlet__body">
                <div class="kt-widget kt-widget--user-profile-3">
                    <div class="kt-widget__top">
                        <div class="kt-widget__pic kt-widget__pic--danger kt-font-danger kt-font-boldest kt-font-light">
                            <?php
                            preg_match_all('/[A-Z]/', $model->nama, $match);
                            $initial = implode('', $match[0]);
                            echo $initial;
                            ?>
                        </div>
                        <div class="kt-widget__content">
                            <div class="kt-widget__head">
                                <a href="#" class="kt-widget__username">
                                    <?= $model->nama ?>
                                    <i class="flaticon2-correct"></i>
                                </a>
                            </div>
                            <div class="kt-widget__subhead">
                                <a href="#"><i class="flaticon2-edit"></i>
                                    <?= $akreditasiTerakhir->nama ?></a>
                                <a href="#"><i class="flaticon2-calendar"></i><?= $akreditasiTerakhir->tahun ?></a>
                                <a href="#"><i class="flaticon-buildings"></i><?= $akreditasiTerakhir->lembaga ?></a>
                            </div>
                            <div class="kt-widget__info">
                                <div class="kt-widget__desc">
                                    Berikut progress pengisian borang oleh Program Studi.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-separator"></div>
                    <div class="row">
                        <div class="col-lg-12">
                            <?php
                            $prodiDataProvider = new ActiveDataProvider(['query' => $model->getProgramStudis()]);
                            ?>

                            <?= ListView::widget([
                                'dataProvider' => $prodiDataProvider,
                                'summary' => false,
                                'itemView' => '//common/_fakultas_prodi_progress',
                                'viewParams' => ['akreditasiTerakhir' => $akreditasiTerakhir]
                            ]) ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
