<?php
/**
 * @var $this yii\web\View
 * @var $prodis common\models\ProgramStudi[]
 * @var $modelFakultas common\models\FakultasAkademi
 */

use common\models\FakultasAkademi;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;

$this->title = 'Akreditasi Program Studi: ' . $modelFakultas->nama;

$this->params['breadcrumbs'][] = $this->title;
?>

<?php foreach ($prodis as $prodi): ?>
    <h3><?= $prodi->nama ?></h3>
    <?= ListView::widget([
        'dataProvider' => new ActiveDataProvider(['query' => $prodi->getK9AkreditasiProdis()]),
        'summary' => false,
        'itemView' => '@monitoring/views/common/_prodi_progress',
        'viewParams' => ['prodi' => $prodi, 'jenis' => FakultasAkademi::FAKULTAS_AKADEMI]
    ]); ?>
<?php endforeach; ?>
