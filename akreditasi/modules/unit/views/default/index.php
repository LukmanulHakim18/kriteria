<?php
/**
 * @var $this View
 * @var $unit Unit
 */
$this->title = $unit->nama;


use common\models\Unit;
use yii\web\View; ?>


<div class="kt-portlet">
    <div class="kt-space-30"></div>
    <h1 class="text-center">IAIN Padangsidimpuan</h1>

    <div class="text-center" style="margin-top: 30px">
        <img src="<?= Yii::getAlias('@web/upload/struktur.png') ?>">
    </div>
    <div class="text-center" style="margin-top: 10px">
        <img src="<?= Yii::getAlias('@web/upload/struktur2.png') ?>">
    </div>
    <div class="text-center" style="margin-top: 20px">
        <img src="<?= Yii::getAlias('@web/upload/struktur3.png') ?>">
    </div>

</div>
