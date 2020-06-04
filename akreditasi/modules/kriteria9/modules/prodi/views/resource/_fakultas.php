<?php
/**
 * @var $this yii\web\View
 * @var $berkasFakultas common\models\Berkas[]
 * @var $profilFakultas common\models\Profil
 */

?>

<div class="row">
    <div class="col-lg-12">
        <ul class="nav nav-pills nav-fill" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#fakultas_profil">Profil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#fakultas_berkas">Berkas</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="fakultas_profil" role="tabpanel">
                <h3>Profil Fakultas</h3>
                <div class="kt-separator "></div>
                <?= $this->render('_profil', ['profil'=>$profilFakultas])?>
            </div>
            <div class="tab-pane" id="fakultas_berkas" role="tabpanel">
                It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
            </div>
        </div>

    </div>
</div>
