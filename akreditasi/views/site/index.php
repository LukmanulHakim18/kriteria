<?php

/* @var $this yii\web\View */
/* @var $struktur common\models\ProfilInstitusi */

$this->title = 'Beranda';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="kt-portlet">
    <div class="kt-space-30"></div>
    <h1 class="text-center"><?= Yii::$app->params['institusi'] ?></h1>

    <?php foreach ($struktur as $item):?>
        <div class="text-center" style="margin-top: 30px">
            <img src="<?= Yii::getAlias('@web/upload/struktur/'.$item->nama) ?>">
        </div>
    <?php endforeach; ?>
</div>
