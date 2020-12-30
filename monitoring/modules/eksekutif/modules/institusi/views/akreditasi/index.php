<?php

/**
 * @var $this yii\web\View
 * @var $aptDataProvider yii\data\ActiveDataProvider
 * @var $profilInstitusi yii2mod\collection\Collection
 */

use yii\widgets\ListView;

$this->title="Akreditasi Perguruan Tinggi";
$this->params['breadcrumbs'][] = $this->title;
?>

<h3>Akreditasi Institusi Perguruan Tinggi</h3>
<?= ListView::widget(['dataProvider' => $aptDataProvider,'itemView' => '@monitoring/views/common/_institusi_progress','viewParams' => ['profilInstitusi'=>$profilInstitusi],
    'summary' => false])?>
