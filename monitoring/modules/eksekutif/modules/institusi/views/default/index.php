<?php

/**
 * @var $this yii\web\View
 * @var $fakultasDataProvider yii\data\ActiveDataProvider
 * @var $akreditasiTerakhir common\models\kriteria9\akreditasi\K9Akreditasi
 * @var $akreditasiInstitusiTerakhir common\models\kriteria9\akreditasi\K9AkreditasiInstitusi
 * @var $profil common\models\Profil
 * @var $profilInstitusi common\models\ProfilInstitusi
 */

use yii\widgets\ListView;

$this->title = 'Akreditasi ';
$this->params['breadcrumbs'] = ['label'=>$this->title];

?>

<?php if ($akreditasiInstitusiTerakhir !== null):?>
    <h3>Akreditasi Perguruan Tinggi</h3>
    <?= $this->render('//common/_institusi_progress', ['model'=>$akreditasiInstitusiTerakhir,'profil'=>$profil,'profilInstitusi'=>$profilInstitusi])?>
<?php endif; ?>
<?php if ($akreditasiTerakhir !== null): ?>
<h3>Akreditasi Program Studi</h3>
    <?= ListView::widget(['dataProvider' => $fakultasDataProvider,'itemView' => '@monitoring/views/common/_fakultas_progress','viewParams' => ['akreditasiTerakhir'=>$akreditasiTerakhir],
        'summary' => false])?>

<?php endif;?>
