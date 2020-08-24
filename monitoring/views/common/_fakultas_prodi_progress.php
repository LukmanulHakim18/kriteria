<?php
/**
 * @var $this yii\web\View
 * @var $model common\models\ProgramStudi
 * @var $akreditasiTerakhir common\models\kriteria9\akreditasi\K9Akreditasi
 */

use yii\bootstrap4\Html;
use yii\bootstrap4\Progress;

$akreditasi = $model->getK9AkreditasiProdis()->andWhere(['id_akreditasi'=>$akreditasiTerakhir->id])->one();
?>
<div class="row">
    <div class="col-lg-6">
        <h5><?=$model->nama?></h5>
    </div>
    <div class="col-lg-4">
        <?php if ($akreditasi !== null): ?>
            <?= Progress::widget([
            'bars'=>[
                ['percent'=>$akreditasi->progress,'options'=>['class'=>'kt-bg-success']]
            ],
            'options'=>['class'=>'progress','style'=>'height:5px;width:100%']
        ])?>
            <?=$akreditasi->progress?>%

        <?php else: ?>
        <p class="text-danger">Belum diakreditasi</p>
        <?php endif;?>
    </div>
    <div class="col-lg-2">
        <?=isset($akreditasi)?Html::a('Detail', ['akreditasi/detail','id'=>$akreditasi->id,'fakultas'=>$model->fakultasAkademi->id,'prodi'=>$model->id], ['class'=>'btn btn-primary btn-sm']):''?>
    </div>
</div>
<br>
