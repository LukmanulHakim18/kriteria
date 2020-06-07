<?php
/**
 * @var $this yii\web\View
 * @var $model common\models\Berkas
 */

use yii\bootstrap4\Html;
use yii\helpers\Url;

?>
<div class="row">
    <div class="col-lg-12">
        <h4><?=$key . '. ' . $model->nama_berkas?></h4>
        <?=\kartik\grid\GridView::widget(['dataProvider' => new \yii\data\ActiveDataProvider(['query' => $model->getDetailBerkas()]),
            'summary' => false,
            'columns' => [
                ['class'=>'kartik\grid\SerialColumn','header' => 'No'],
                'isi_berkas',
                ['class'=>'common\widgets\ActionColumn','header' => 'Aksi',
                    'template' => '{lihat}{gunakan}',
                    'buttons' => [

                        'lihat'=>function ($url, $model, $key) {
            return Html::button('<i class="flaticon2-magnifier-tool"></i> Lihat',['value'=>Url::to(['resource/lihat-berkas-detail','id'=>$model->id]),'title'=>$model->isi_berkas,'class'=>'btn btn-warning btn-sm btn-pill btn-elevate btn-elevate-air showModalButton']);
                        },
                        'gunakan'=>function ($url, $model, $key) {
                            return Html::button('<i class="flaticon2-laptop"></i> Gunakan', ['value'=> Url::to(['resource/gunakan']),'title'=>"Gunakan {$model->berkas->nama_berkas}",'class'=>'btn btn-primary btn-sm btn-pill btn-elevate btn-elevate-air showModalButton']);
                        }
                    ]]
            ]])?>
    </div>
</div>
