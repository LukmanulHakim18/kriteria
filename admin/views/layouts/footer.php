<?php

use yii\bootstrap4\Html;

?>
<!-- begin:: Footer -->
<div class="kt-footer kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop" id="kt_footer">
    <div class="kt-footer__copyright">
        <?= date('Y') ?>&nbsp;&copy;&nbsp;<a href="http://keenthemes.com/metronic" target="_blank" class="kt-link">
            <?= Html::encode(Yii::$app->params['instansi'])?> by Adryan Eka Vandra</a>
    </div>
    <div class="kt-footer__menu">
        <a href="https://uin-suska.ac.id" target="_blank" class="kt-footer__menu-link kt-link"><?=Yii::$app->params['instansi']?></a>
    </div>
</div>

<!-- end:: Footer -->