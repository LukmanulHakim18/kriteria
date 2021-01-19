<?php

/* @var $this yii\web\View */
/* @var $struktur string */

$this->title = 'Beranda';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="kt-portlet">
    <div class="kt-space-30"></div>
    <h1 class="text-center"><?= Yii::$app->params['institusi'] ?></h1>

    <div class="kt-portlet__body">
        <div class="text-center mt-30 mb-30">
            <img src="<?= common\helpers\kriteria9\K9InstitusiDirectoryHelper::getStrukturUrl() . '/' . $struktur ?>">
        </div>
        <div class="clearfix"></div>
    </div>

</div>
