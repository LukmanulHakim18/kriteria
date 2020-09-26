<?php

use akreditasi\models\kriteria9\forms\lk\institusi\K9LinkLkInstitusiKriteriaDetailForm;
use akreditasi\models\kriteria9\forms\lk\institusi\K9LkInstitusiKriteriaDetailForm;
use akreditasi\models\kriteria9\forms\lk\institusi\K9TextLkInstitusiKriteriaDetailForm;
use akreditasi\models\kriteria9\lk\institusi\K9LkInstitusiNarasiKriteria1Form;
use common\helpers\FileIconHelper;
use common\helpers\FileTypeHelper;
use common\models\Constants;
use common\models\kriteria9\lk\institusi\K9LkInstitusi;
use dosamigos\tinymce\TinyMce;
use kartik\file\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
use yii\bootstrap4\Progress;

/* @var $this yii\web\View */
/* @var $lkInstitusi K9LkInstitusi */
/* @var $modelNarasi K9LkInstitusiNarasiKriteria1Form */
/* @var $dokModel K9LkInstitusiKriteriaDetailForm */
/* @var $dokTextModel K9TextLkInstitusiKriteriaDetailForm */
/* @var $dokLinkModel K9LinkLkInstitusiKriteriaDetailForm */
/* @var $poinKriteria */
/* @var $path string */
/* @var $modelKriteria */

$kriteria = Yii::$app->request->get('kriteria');
$this->title = "Kriteria " . $kriteria;
$this->params['breadcrumbs'][] = ['label' => 'Beranda', 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = ['label' => '9 Kriteria', 'url' => ['/kriteria9/default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Institusi', 'url' => ['/kriteria9/k9-institusi/default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Isi Kriteria', 'url' => ['/kriteria9/k9-institusi/lk/lihat', 'lk' => $lkInstitusi->id,]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                <?= $this->title ?>

            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-actions">
                <strong>Kelengkapan Berkas &nbsp; : <?= $modelKriteria->progress ?> %</strong>
                <div class="kt-space-10"></div>
                <?=
                Progress::widget([
                    'percent' => $modelKriteria->progress,
                    'barOptions' => ['class' => 'progress-bar-info'],
                    'options' => ['class' => 'progress-sm']
                ]);
                ?>
            </div>
        </div>
    </div>

    <div class="kt-portlet__body">
        <div class="kt-section kt-section--first" style="margin-bottom: 0;">

            <!--begin::Accordion-->
            <div class="accordion accordion-solid  accordion-toggle-arrow" id="accordionExample2">

                <?php foreach ($poinKriteria

                               as $key => $item) :
                    $modelAttribute = '_' . str_replace('.', '_', $item['tabel']); ?>

                    <div class="card">
                        <div class="card-header" id="heading<?= $key ?>">
                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapse<?= $key ?>"
                                 aria-expanded="false" aria-controls="collapse<?= $key ?>">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <i class="flaticon-file-2"></i> <?=
                                        $item['tabel'] ?>&nbsp;
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <small>&nbsp;<?= $item['isi'] ?></small>

                                    </div>
                                </div>
                            </div>

                            <div id="collapse<?= $key ?>" class="collapse" aria-labelledby="heading<?= $key ?>"
                                 data-parent="#accordionExample2" style="">
                                <div class="card-body">

                                    <div class="kt-portlet kt-portlet--mobile">
                                        <div class="kt-portlet__body">
                                            <div class="row">
                                                <div class="col-lg-12">

                                                    <?=$modelNarasi->$modelAttribute ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!--                            Tabel dokumen sumber-->
                                    <table class="table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th colspan="3" class="text-center">Dokumen Sumber</th>
                                        </tr>
                                        </thead>
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>Kode</th>
                                            <th colspan="2">Dokumen</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($item['dokumen_sumber'] as $keyDoksum => $doksum) :

                                        $clear = trim($doksum['kode']);
                                        $kodeSumber = '_' . str_replace('.', '_', $clear);

                                        if (!empty($doksum['kode'])) : ?>

                                            <tr>
                                                <th scope="row"><?= $doksum['kode'] ?></th>
                                                <td>
                                                    <p style="font-size: 14px;font-weight: 400"><?= $doksum['dokumen'] ?></p>
                                                </td>

                                            </tr>


                                        <?php else :
                                            echo '<tr><td>Tidak ada dokumen</td></tr>';
                                        endif; ?>
                                        <?php

                                        $detailClass = 'common\\models\\kriteria9\\lk\\institusi\\K9LkInstitusiKriteria' . $kriteria . 'Detail';
                                        $detail = call_user_func($detailClass . "::find")->where(['id_lk_institusi_kriteria' . $kriteria => $modelKriteria->id]);

                                        $detail1 = $detail->andWhere(['kode_dokumen' => $doksum['kode'], 'jenis_dokumen' => Constants::SUMBER])->all();
                                        foreach ($detail1 as $k => $v) : ?>

                                            <tr>
                                                <td></td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-lg-12 text-center">

                                                            <?= FileIconHelper::getIconByExtension($v->bentuk_dokumen) ?>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12 text-center">
                                                            <?php $type = FileTypeHelper::getType($v->bentuk_dokumen);

                                                            if ($type === FileTypeHelper::TYPE_STATIC_TEXT || $type === FileTypeHelper::TYPE_LINK) : ?>
                                                                <?= Html::encode($v->nama_dokumen) ?>

                                                            <?php else: ?>
                                                                <?= Html::encode($v->isi_dokumen) ?>
                                                            <?php endif; ?>

                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <?php $type = FileTypeHelper::getType($v->bentuk_dokumen);
                                                            if ($type === FileTypeHelper::TYPE_IMAGE || $type === FileTypeHelper::TYPE_PDF || $type === FileTypeHelper::TYPE_STATIC_TEXT):?>

                                                                <?php Modal::begin([
                                                                    'title' => $v->nama_dokumen,
                                                                    'toggleButton' => ['label' => '<i class="la la-eye"></i> &nbsp;Lihat', 'class' => 'btn btn-info btn-sm btn-pill btn-elevate btn-elevate-air'],
                                                                    'size' => 'modal-lg',
                                                                    'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                                                ]); ?>
                                                                <?php switch ($type) {
                                                                    case FileTypeHelper::TYPE_IMAGE:
                                                                        echo Html::img("$path/sumber/{$v->isi_dokumen}", ['height' => '100%', 'width' => '100%']);
                                                                        break;
                                                                    case FileTypeHelper::TYPE_STATIC_TEXT:
                                                                        echo $v->isi_dokumen;
                                                                        break;
                                                                    case FileTypeHelper::TYPE_PDF:
                                                                        echo '<embed src="' . $path . '/sumber/' . $v->isi_dokumen . '" type="application/pdf" height="100%" width="100%">
';
                                                                        break;
                                                                } ?>
                                                                <?php Modal::end(); ?>
                                                            <?php elseif ($type === FileTypeHelper::TYPE_LINK): ?>
                                                                <?= Html::a('<i class="la la-external-link"></i> Lihat', $v->isi_dokumen, ['class' => 'btn btn-info btn-sm btn-pill btn-elevate btn-elevate-air', 'target' => '_blank']) ?>
                                                            <?php endif; ?>
                                                            <?php if ($type === FileTypeHelper::TYPE_LINK || $type === FileTypeHelper::TYPE_STATIC_TEXT): ?>

                                                            <?php else: ?>
                                                                <?= Html::a('<i class="la la-download"></i>&nbsp;Unduh', ['lk/download-detail', 'kriteria' => $kriteria, 'dokumen' => $v->id, 'lk' => $_GET['lk'], 'jenis' => Constants::SUMBER], ['class' => 'btn btn-warning btn-sm btn-pill btn-elevate btn-elevate-air']) ?>
                                                            <?php endif; ?>
                                                        </div>

                                                    </div>
                                                </td>
                                            </tr>

                                        <?php
                                        endforeach;
                                        ?>

                                        </tbody>
                                        <?php endforeach; ?>
                                    </table>

                                    <!--                            Tabel dokumen pendukung-->
                                    <table class="table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th colspan="3" class="text-center">Dokumen Pendukung</th>
                                        </tr>
                                        </thead>
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>Kode</th>
                                            <th colspan="2">Dokumen</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php foreach ($item['dokumen_pendukung'] as $keyDokpen => $dokpen) {
                                            $dokpenAttr = '_' . str_replace('.', '_', $dokpen['kode']);
                                            if (!empty($dokpen['kode'])) {

                                                $kodePendukung = str_replace('.', '', trim($dokpen['kode']));
                                                ?>

                                                <tr>
                                                    <th scope="row"><?= $dokpen['kode'] ?></th>
                                                    <td>
                                                        <p style="font-size: 14px;font-weight: 400"><?= $dokpen['dokumen'] ?></p>
                                                    </td>

                                                </tr>

                                            <?php } else {
                                                echo '<tr><td>Tidak ada dokumen</td></tr>';
                                            } ?>


                                            <?php
                                            $detailClass = 'common\\models\\kriteria9\\lk\\institusi\\K9LkInstitusiKriteria' . $kriteria . 'Detail';
                                            $detail = call_user_func($detailClass . "::find")->where(['id_lk_institusi_kriteria' . $kriteria => $modelKriteria->id]);

                                            $detail1 = $detail->andWhere(['kode_dokumen' => $dokpen['kode'], 'jenis_dokumen' => Constants::PENDUKUNG])->all();

                                            foreach ($detail1 as $k => $v) :
                                                ?>
                                                <tr>
                                                    <td colspan="2">
                                                        <div class="row">
                                                            <div class="col-lg-12 text-center">

                                                                <?= FileIconHelper::getIconByExtension($v->bentuk_dokumen) ?>
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12 text-center">
                                                                <?php $type = FileTypeHelper::getType($v->bentuk_dokumen);

                                                                if ($type === FileTypeHelper::TYPE_STATIC_TEXT || $type === FileTypeHelper::TYPE_LINK) : ?>
                                                                    <?= Html::encode($v->nama_dokumen) ?>

                                                                <?php else: ?>
                                                                    <?= Html::encode($v->isi_dokumen) ?>
                                                                <?php endif; ?>

                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="pull-right">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <?php $type = FileTypeHelper::getType($v->bentuk_dokumen);
                                                                if ($type === FileTypeHelper::TYPE_IMAGE || $type === FileTypeHelper::TYPE_PDF || $type === FileTypeHelper::TYPE_STATIC_TEXT):?>

                                                                    <?php Modal::begin([
                                                                        'title' => $v->nama_dokumen,
                                                                        'toggleButton' => ['label' => '<i class="la la-eye"></i> &nbsp;Lihat', 'class' => 'btn btn-info btn-sm btn-pill btn-elevate btn-elevate-air'],
                                                                        'size' => 'modal-lg',
                                                                        'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                                                    ]); ?>
                                                                    <?php switch ($type) {
                                                                        case FileTypeHelper::TYPE_IMAGE:
                                                                            echo Html::img("$path/pendukung/{$v->isi_dokumen}", ['height' => '100%', 'width' => '100%']);
                                                                            break;
                                                                        case FileTypeHelper::TYPE_STATIC_TEXT:
                                                                            echo $v->isi_dokumen;
                                                                            break;
                                                                        case FileTypeHelper::TYPE_PDF:
                                                                            echo '<embed src="' . $path . '/pendukung/' . $v->isi_dokumen . '" type="application/pdf" height="100%" width="100%">
';
                                                                            break;
                                                                    } ?>
                                                                    <?php Modal::end(); ?>
                                                                <?php elseif ($type === FileTypeHelper::TYPE_LINK): ?>
                                                                    <?= Html::a('<i class="la la-external-link"></i> Lihat', $v->isi_dokumen, ['class' => 'btn btn-info btn-sm btn-pill btn-elevate btn-elevate-air', 'target' => '_blank']) ?>
                                                                <?php endif; ?>
                                                                <?php if ($type === FileTypeHelper::TYPE_LINK || $type === FileTypeHelper::TYPE_STATIC_TEXT): ?>

                                                                <?php else: ?>
                                                                    <?= Html::a('<i class="la la-download"></i>&nbsp;Unduh', ['lk/download-detail', 'kriteria' => $kriteria, 'dokumen' => $v->id, 'lk' => $_GET['lk'], 'jenis' => Constants::PENDUKUNG], ['class' => 'btn btn-warning btn-sm btn-pill btn-elevate btn-elevate-air']) ?>
                                                                <?php endif; ?>
                                                            </div>

                                                        </div>
                                                    </td>


                                                </tr>
                                            <?php
                                            endforeach;
                                        } ?>

                                        </tbody>
                                    </table>

                                    <!--                                Tabel dokumen lainnya-->
                                    <table class="table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th colspan="2" class="text-left">Dokumen Lainnya</th>
                                        </tr>
                                        </thead>
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>No.</th>
                                            <th colspan="2">Dokumen</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $detailClass = 'common\\models\\kriteria9\\lk\\institusi\\K9LkInstitusiKriteria' . $kriteria . "Detail";
                                        $detail = call_user_func($detailClass . "::find")->where(['id_lk_institusi_kriteria' . $kriteria => $modelKriteria->id]);

                                        $detail1 = $detail->andWhere(['jenis_dokumen' => Constants::LAINNYA])->all();
                                        if (!empty($detail1)) {
                                            foreach ($detail1 as $k => $v) {
                                                if ( $v['jenis_dokumen'] === 'lainnya') { ?>
                                                    <tr>
                                                        <td><strong><?= $k + 1 ?></strong></td>
                                                        <td>
                                                            <div class="row">
                                                                <div class="col-lg-12 text-center">

                                                                    <?= FileIconHelper::getIconByExtension($v->bentuk_dokumen) ?>
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12 text-center">
                                                                    <?php $type = FileTypeHelper::getType($v->bentuk_dokumen);

                                                                    if ($type === FileTypeHelper::TYPE_STATIC_TEXT || $type === FileTypeHelper::TYPE_LINK) : ?>
                                                                        <?= Html::encode($v->nama_dokumen) ?>

                                                                    <?php else: ?>
                                                                        <?= Html::encode($v->isi_dokumen) ?>
                                                                    <?php endif; ?>

                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-right">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <?php $type = FileTypeHelper::getType($v->bentuk_dokumen);
                                                                    if ($type === FileTypeHelper::TYPE_IMAGE || $type === FileTypeHelper::TYPE_PDF || $type === FileTypeHelper::TYPE_STATIC_TEXT):?>

                                                                        <?php Modal::begin([
                                                                            'title' => $v->nama_dokumen,
                                                                            'toggleButton' => ['label' => '<i class="la la-eye"></i> &nbsp;Lihat', 'class' => 'btn btn-info btn-sm btn-pill btn-elevate btn-elevate-air'],
                                                                            'size' => 'modal-lg',
                                                                            'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                                                        ]); ?>
                                                                        <?php switch ($type) {
                                                                            case FileTypeHelper::TYPE_IMAGE:
                                                                                echo Html::img("$path/lainnya/{$v->isi_dokumen}", ['height' => '100%', 'width' => '100%']);
                                                                                break;
                                                                            case FileTypeHelper::TYPE_STATIC_TEXT:
                                                                                echo $v->isi_dokumen;
                                                                                break;
                                                                            case FileTypeHelper::TYPE_PDF:
                                                                                echo '<embed src="' . $path . '/lainnya/' . $v->isi_dokumen . '" type="application/pdf" height="100%" width="100%">
';
                                                                                break;
                                                                        } ?>
                                                                        <?php Modal::end(); ?>
                                                                    <?php elseif ($type === FileTypeHelper::TYPE_LINK): ?>
                                                                        <?= Html::a('<i class="la la-external-link"></i> Lihat', $v->isi_dokumen, ['class' => 'btn btn-info btn-sm btn-pill btn-elevate btn-elevate-air', 'target' => '_blank']) ?>
                                                                    <?php endif; ?>
                                                                    <?php if ($type === FileTypeHelper::TYPE_LINK || $type === FileTypeHelper::TYPE_STATIC_TEXT): ?>

                                                                    <?php else: ?>
                                                                        <?= Html::a('<i class="la la-download"></i>&nbsp;Unduh', ['lk/download-detail', 'kriteria' => $kriteria, 'dokumen' => $v->id, 'lk' => $_GET['lk'], 'jenis' => Constants::LAINNYA], ['class' => 'btn btn-warning btn-sm btn-pill btn-elevate btn-elevate-air']) ?>
                                                                    <?php endif; ?>
                                                                </div>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            }
                                        } else {
                                            echo '<tr><td>Tidak ada dokumen</td></tr>';
                                        } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>

                <?php endforeach; ?>
                <!--end::Accordion-->
            </div>
        </div>
    </div>

