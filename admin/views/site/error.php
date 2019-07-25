<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use yii\helpers\Html;
$this->context->layout= 'main-error';
$this->title = $name;
$posTag = strpos($name, '#');
$substring = substr($name, $posTag + 1, '3');
?>
<div class="kt-error_container">
    <span class="kt-error_number">
        <h1><?= $substring ?></h1>
    </span>
    <p class="kt-error_title kt-font-light">
        <?= nl2br(Html::encode($message)) ?>
    </p>
    <p class="kt-error_subtitle">
        Kenapa bisa sampai ke sini?
    </p>
    <p class="kt-error_description">
        Kesalahan diatas terjadi ketika server sedang memproses permintaan anda.<br>
        Silahkan kontak administrator jika anda merasa ini kesalahan server. Terima kasih.
    </p>
</div>
