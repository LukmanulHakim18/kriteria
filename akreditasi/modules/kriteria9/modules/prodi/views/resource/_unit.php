<?php
/**
 * @var $this yii\web\View
 * @var $kegiatanUnit common\models\unit\KegiatanUnit[]
 * @var $profilUnit common\models\Unit[]
 */

?>

<div class="row">
    <div class="col-lg-12">
        <ul class="nav nav-pills nav-fill" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#unit_profil">Profil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#unit_berkas">Berkas</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="unit_profil" role="tabpanel">
                <h3>Profil Unit</h3>
                <div class="kt-separator"></div>
                <?php foreach ($profilUnit as $unit): ?>
                    <h5><?=$unit->nama?></h5>
                    <?= $this->render('_profil', ['profil'=>$unit->profil])?>
                    <div class="kt-separator kt-separator--dashed"></div>
                <?php endforeach; ?>
            </div>
            <div class="tab-pane" id="unit_berkas" role="tabpanel">
                <h3>Berkas Unit</h3>
                <div class="kt-separator"></div>
                <?php foreach ($profilUnit as $unit): ?>
                    <h5><?=$unit->nama?></h5>
                    <?= $this->render('_berkas', ['berkas'=>new \yii\data\ActiveDataProvider(['query' => $unit->getBerkas()])])?>
                    <div class="kt-separator kt-separator--dashed"></div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</div>
