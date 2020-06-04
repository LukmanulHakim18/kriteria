<?php
 /**
  * @var $model common\models\DetailBerkas[]
  */

use kartik\grid\GridView;

echo GridView::widget([
    'dataProvider' => $model,
    'summary' => false,
    'columns' => [
        ['class'=>'kartik\grid\SerialColumn','header' => 'No'],
        'isi_berkas',
        'bentuk_berkas',
        ['class'=>'common\widgets\ActionColumn','header'=>'Aksi']
    ]
]);
