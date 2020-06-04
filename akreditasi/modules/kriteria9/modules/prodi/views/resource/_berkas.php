<?php
/**
 * @var $berkas common\models\Berkas[]
 */

use kartik\grid\GridView;

?>


<div class="berkas">
    <?=\kartik\grid\GridView::widget([
        'dataProvider' => $berkas,
        'summary' => false,
        'columns' => [
            ['class'=>'kartik\grid\SerialColumn','header' => 'No'],
            'nama_berkas',
            [
                'class'=>'kartik\grid\ExpandRowColumn',
                'expandOneOnly' => true,
                'detailUrl' => \yii\helpers\Url::to(['resource/berkas-detail']),
                'value' => function ($model, $key, $index) {
                    return GridView::ROW_EXPANDED;
                },
                'header' => 'Detail'],


        ]
    ]) ?>
</div>
