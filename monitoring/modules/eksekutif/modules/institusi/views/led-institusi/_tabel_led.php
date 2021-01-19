<?php
/**
 * @var $this yii\web\View
 * @var $untuk string
 * @var $led common\models\kriteria9\led\institusi\K9LedInstitusi
 * @var $json common\models\kriteria9\led\Led
 * @var $kriteria []
 * @var $institusi
 * @var $json_eksternal common\models\kriteria9\led\Led
 * @var $json_profil common\models\kriteria9\led\Led
 * @var $json_analisis common\models\kriteria9\led\Led
 * @var $modelEksternal common\models\kriteria9\led\institusi\K9LedInstitusiNarasiKondisiEksternal
 * @var $modelAnalisis common\models\kriteria9\led\institusi\K9LedInstitusiNarasiAnalisis
 * @var $modelProfil common\models\kriteria9\led\institusi\K9LedInstitusiNarasiProfilInstitusi
 */

use yii\bootstrap4\Html;
use yii\bootstrap4\Progress;

?>
<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Laporan Evaluasi Perguruan Tinggi
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-actions">
                <strong>Pengisian:&nbsp;<?= Html::encode($led->progress) ?> %</strong>
                <div class="kt-space-10"></div>
                <?=
                Progress::widget([
                    'percent' => $led->progress,
                    'barOptions' => ['class' => 'progress-bar-info m-progress-lg'],
                    'options' => ['class' => 'progress-sm']
                ]); ?>
            </div>
        </div>
    </div>

    <div class="kt-portlet__body">
        <div class="kt-section kt-section--first" style="margin-bottom: 0;">

            <div class="row">
                <div class="col-lg-12">
                    <?= $this->render('@monitoring/modules/eksekutif/modules/institusi/views/led-institusi/_tabel_led_eksternal',
                        compact('json_eksternal', 'modelEksternal', 'untuk', 'led')) ?>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <?= $this->render('@monitoring/modules/eksekutif/modules/institusi/views/led-institusi/_tabel_led_profil',
                        compact('json_profil', 'modelProfil', 'untuk', 'led')) ?>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <?= $this->render('@monitoring/modules/eksekutif/modules/institusi/views/led-institusi/_tabel_led_kriteria',
                        compact('json', 'kriteria', 'untuk', 'led')) ?>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <?= $this->render('@monitoring/modules/eksekutif/modules/institusi/views/led-institusi/_tabel_led_analisis',
                        compact('json_analisis', 'modelAnalisis', 'untuk', 'led')) ?>

                </div>
            </div>
        </div>
    </div>
</div>
