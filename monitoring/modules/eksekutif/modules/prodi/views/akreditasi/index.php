<?php
/**
 * @var $this yii\web\View
 * @var $prodi common\models\ProgramStudi
 * @var $akreditasiDataProvider yii\data\ActiveDataProvider
 */

use yii\bootstrap4\Html;

$this->title = 'Akreditasi Program Studi: '.$prodi->nama;

$this->params['breadcrumbs'][] = $this->title;
?>

<?=\yii\widgets\ListView::widget([
    'dataProvider' => $akreditasiDataProvider,
    'summary' => false,
    'itemView' => '@monitoring/views/common/_prodi_progress',
    'viewParams' => ['prodi'=>$prodi]
])?>
