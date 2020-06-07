<?php
/**
 * @var $berkas common\models\Berkas[]
 */

use kartik\grid\GridView;
use yii\widgets\ListView;

?>


<div class="berkas">
    <?= ListView::widget(['dataProvider' => $berkas,
        'itemView' => '_berkas_item',
        'summary' => false])?>

</div>
