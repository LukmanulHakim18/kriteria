<?php
/**
 * Project: mutu-v2.
 * @author Adryan Eka Vandra <adryanekavandra@gmail.com>
 *
 * Date: 8/26/2019
 * Time: 1:54 PM
 */

/**
 * @var $this View
 * @var $led K9LedInstitusi
 * @var $dataDokumen [];
 * @var $json Led;
 * @var $kriteria [];
 * @var $path string
 * @var $json_eksternal common\models\kriteria9\led\Led
 * @var $json_profil common\models\kriteria9\led\Led
 * @var $json_analisis common\models\kriteria9\led\Led
 * @var $modelEksternal common\models\kriteria9\led\institusi\K9LedInstitusiNarasiKondisiEksternal
 * @var $modelAnalisis common\models\kriteria9\led\institusi\K9LedInstitusiNarasiAnalisis
 * @var $modelProfil common\models\kriteria9\led\institusi\K9LedInstitusiNarasiProfilInstitusi
 * @var $institusi common\models\ProgramStudi
 * @var $untuk string
 */

use common\models\kriteria9\led\institusi\K9LedInstitusi;
use common\models\kriteria9\led\Led;
use yii\helpers\StringHelper;
use yii\web\View;

$this->title = StringHelper::mb_ucfirst($untuk) . " LED";
$this->params['breadcrumbs'][] = ['label' => 'Beranda', 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = ['label' => '9 Kriteria', 'url' => ['/kriteria9/default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Institusi', 'url' => ['/kriteria9/k9-institusi/default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Led', 'url' => ['/kriteria9/k9-institusi/led/arsip', 'target' => 'isi']];
$this->params['breadcrumbs'][] = $this->title;


?>

<?= $this->render('_info_akreditasi', compact('led')) ?>


<?= $this->render('_dokumen_led', compact('modelDokumen', 'dataDokumen', 'path', 'untuk')) ?>

<?= $this->render('_tabel_led', [
    'kriteria' => $kriteria,
    'json' => $json,
    'untuk' => $untuk,
    'led' => $led,
    'json_eksternal' => $json_eksternal,
    'json_profil' => $json_profil,
    'json_analisis' => $json_analisis,
    'modelEksternal' => $modelEksternal,
    'modelAnalisis' => $modelAnalisis,
    'modelProfil' => $modelProfil,
]) ?>

