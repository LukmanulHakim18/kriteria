<?php
/**
 * @var $this yii\web\View
 * @var $kegiatanUnit common\models\unit\KegiatanUnit[]
 * @var $profilUnit common\models\Profil[]
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
                <?php foreach ($profilUnit as $profil): ?>
                    <h5><?=$profil->owner->nama?></h5>
                    <?= $this->render('_profil', ['profil'=>$profil])?>
                    <div class="kt-separator kt-separator--dashed"></div>
                <?php endforeach; ?>
            </div>
            <div class="tab-pane" id="unit_berkas" role="tabpanel">
                It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
            </div>
        </div>

    </div>
</div>
