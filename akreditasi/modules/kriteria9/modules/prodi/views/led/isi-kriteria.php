<?php
/**
 * @var $this yii\web\View
 * @var $model ;
 * @var $poinKriteria [];

 */
$prodi = $_GET['prodi'];
$kriteria = $_GET['kriteria'];
$this->title = "Kriteria " . $kriteria;
$this->params['breadcrumbs'][] = ['label' => 'Beranda', 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = ['label' => '9 Kriteria', 'url' => ['/kriteria9/default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Program Studi', 'url' => ['/kriteria9/k9-prodi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Pencarian Data Prodi', 'url' => ['/kriteria9/k9-prodi/arsip', 'target' => 'isi', 'prodi' => $prodi]];
$this->params['breadcrumbs'][] = ['label' => 'Isi Led', 'url' => ['/kriteria9/k9-prodi/led/isi', 'led' => $_GET['led'], 'prodi' => $prodi]];
$this->params['breadcrumbs'][] = $this->title;


use akreditasi\models\kriteria9\forms\led\K9DetailLedProdiLinkForm;
use akreditasi\models\kriteria9\forms\led\K9DetailLedProdiTeksForm;
use akreditasi\models\kriteria9\forms\led\K9DetailLedProdiUploadForm;
use common\helpers\FileIconHelper;
use common\helpers\FileTypeHelper;
use common\models\Constants;
use dosamigos\tinymce\TinyMce;
use kartik\file\FileInput;
use yii\bootstrap4\Accordion;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
use yii\bootstrap4\Progress;

?>

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                <?= Html::encode($this->title) ?>

            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-actions">
                <strong>Kelengkapan Berkas &nbsp; : <?= $model->progress ?> %</strong>
                <div class="kt-space-10"></div>
                <?=
                Progress::widget([
                    'percent' => $model->progress,
                    'barOptions' => ['class' => 'progress-bar-info m-progress-lg'],
                    'options' => ['class' => 'progress-sm']
                ]); ?>
            </div>
        </div>
    </div>

    <div class="kt-portlet__body">
        <div class="kt-section kt-section--first" style="margin-bottom: 0;">
            <!--begin::Accordion-->
            <div class="accordion accordion-solid  accordion-toggle-plus" id="accordion">

                <?php foreach ($poinKriteria as $key => $item):
                    $modelAttribute = '_' . str_replace('.', '_', $item->nomor);

                    ?>
                    <div class="card">
                        <div class="card-header" id="heading<?= $key ?>">
                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapse<?= $key ?>"
                                 aria-expanded="false" aria-controls="collapse<?= $key ?>">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <i class="flaticon-file-2"></i> <?=
                                        $item->nomor ?>&nbsp;
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <small>&nbsp;<?= $item->nama ?></small>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="collapse<?= $key ?>" class="collapse" aria-labelledby="heading<?= $key ?>">
                            <div class="card-body">
                                    <div class="kt-spinner kt-spinner--center kt-spinner--primary kt-spinner--v2" id="spinner-<?=$key?>" data-poin="<?=$item->nomor?>"></div>
                                <div id="result-<?=$item->nomor?>"></div>
                            </div>

                        </div>
                    </div>

                <?php endforeach; ?>
            </div>

            <!--end::Accordion-->

        </div>
    </div>
</div>
<?php
$url = \yii\helpers\Url::to(['led/butir-item','kriteria'=>$kriteria,'led'=>$model->id,'prodi'=>$prodi],true);
$js = <<<JS
var loaded = {};
$('#accordion').on('shown.bs.collapse',function(t) {
var url = new URL("{$url}");
var target = t.target.children[0].children[0];
var poin = target.dataset.poin
url.searchParams.append('poin',poin)
console.log(loaded[poin])
if(loaded[poin]==null){
$.ajax({
url:url,
method:'GET',
dataType:"html"
}).done(function(html){
    loaded[poin] = html
    $("#"+target.id).removeAttr('class').next().html(html)


})
}
console.log(loaded)

})
JS;

$this->registerJs($js);


