<?php

/* @var $this yii\web\View */
/* @var $jumlahProdi integer */
/* @var $jumlahPengguna integer */
/* @var $apt integer */
/* @var $aps integer */
/* @var $persenAps float */
/* @var $persenApt float */

$this->title = 'Beranda';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="kt-portlet">
    <div class="kt-space-30"></div>
    <h1 class="text-center"><?= Yii::$app->params['institusi'] ?></h1>

    <div class="text-center" style="margin-top: 30px">
        <img src="<?= Yii::getAlias('@web/upload/struktur/struktur.png') ?>">
    </div>
    <div class="text-center" style="margin-top: 10px">
        <img src="<?= Yii::getAlias('@web/upload/struktur/struktur2.png') ?>">
    </div>
    <div class="text-center" style="margin-top: 20px">
        <img src="<?= Yii::getAlias('@web/upload/struktur/struktur3.png') ?>">
    </div>

</div>



