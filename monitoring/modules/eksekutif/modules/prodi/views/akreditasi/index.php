<?php
/**
 * @var $this yii\web\View
 * @var $prodi common\models\ProgramStudi
 * @var $akreditasiDataProvider yii\data\ActiveDataProvider
 */

use common\models\ProgramStudi;
use yii\widgets\ListView;

$this->title = 'Akreditasi Program Studi: ' . $prodi->nama;

$this->params['breadcrumbs'][] = $this->title;
?>

<?= ListView::widget([
    'dataProvider' => $akreditasiDataProvider,
    'summary' => false,
    'itemView' => '@monitoring/views/common/_prodi_progress',
    'viewParams' => ['prodi' => $prodi, 'jenis' => ProgramStudi::PROGRAM_STUDI]
]);
