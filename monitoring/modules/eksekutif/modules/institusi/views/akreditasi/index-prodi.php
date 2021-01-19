<?php
/**
 * @var $fakultasDataProvider yii\data\ActiveDataProvider
 * @var $akreditasiTerakhir common\models\kriteria9\akreditasi\K9Akreditasi
 */

use yii\widgets\ListView;

?>

<h3>Akreditasi Program Studi</h3>
<?= ListView::widget(['dataProvider' => $fakultasDataProvider,'itemView' => '@monitoring/views/common/_fakultas_progress','viewParams' => ['akreditasiTerakhir'=>$akreditasiTerakhir],
    'summary' => false])?>

