<?php
/**
 * @var $model ;
 * @var $modelNarasi ;
 * @var $poinKriteria [];
 * @var $detail ;
 */
$prodi = $_GET['prodi'];
$this->title = 'Kriteria ' . $_GET['kriteria'];
$this->params['breadcrumbs'][] = [
    'label' => 'Akreditasi Prodi',
    'url' => ['akreditasi/index', 'prodi' => $_GET['prodi']]
];
$this->params['breadcrumbs'][] = [
    'label' => "Akreditasi: {$akreditasiProdi->akreditasi->nama} - {$modelProdi->nama}",
    'url' => ['akreditasi/detail', 'id' => $akreditasiProdi->id, 'prodi' => $modelProdi->id]
];
$this->params['breadcrumbs'][] = $this->title;
$kriteria = $_GET['kriteria'];

use common\helpers\FileIconHelper;
use common\helpers\FileTypeHelper;
use common\models\Constants;
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
                    $modelAttribute = '_' . str_replace('.', '_', $item['nomor']);

                    ?>
                    <div class="card">
                        <div class="card-header" id="heading<?= $key ?>">
                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapse<?= $key ?>"
                                 aria-expanded="false" aria-controls="collapse<?= $key ?>">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <i class="flaticon-file-2"></i> <?=
                                        $item['nomor'] ?>&nbsp;
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <small>&nbsp;<?= $item['isi'] ?></small>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="collapse<?= $key ?>" class="collapse" aria-labelledby="heading<?= $key ?>"
                             data-parent="#accordion" style="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <?= $item['deskripsi'] ?>
                                    </div>
                                </div>
                                <div class="clearfix"></div>

                                <br>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <?=$modelNarasi->$modelAttribute?>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <br>

                                <!--                            Tabel dokumen sumber-->
                                <table class="table table-striped table-hover">
                                    <thead class="thead-light">
                                    <tr>
                                        <th colspan="3" class="text-center">Dokumen Sumber</th>
                                    </tr>
                                    </thead>
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>Kode</th>
                                        <th colspan="2">Nama Dokumen</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    foreach ($item['dokumen_sumber'] as $keyDoksum => $doksum):
                                        $doksumAttr = '_' . str_replace('.', '_', $doksum['kode']);
                                        ?>
                                        <?php if (empty($doksum['kode'])): ?>
                                        <tr>
                                            <td colspan="3">Tidak ada dokumen</td>
                                        </tr>
                                        <?php else: ?>
                                        <tr>
                                            <th scope="row">
                                                <?=$doksum['kode']?>
                                            </th>
                                            <td>
                                                <?=$doksum['dokumen']?>
                                            </td>
                                            <td></td>
                                        </tr>
                                            <?php
                                            $detailClass = 'common\\models\\kriteria9\\led\\prodi\\K9LedProdiKriteria' . $kriteria . 'Detail';
                                            $detail = call_user_func($detailClass . '::find')->where(['id_led_prodi_kriteria' . $kriteria=>$model->id]);

                                            $detail1 = $detail->andWhere(['kode_dokumen' => $doksum['kode'],'jenis_dokumen'=>Constants::SUMBER])->all();

                                            foreach ($detail1 as $k => $v):
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

                                                            if ($type === FileTypeHelper::TYPE_STATIC_TEXT || $type === FileTypeHelper::TYPE_LINK): ?>
                                                                <?=Html::encode($v->nama_dokumen)  ?>

                                                            <?php else:?>
                                                                <?=Html::encode($v->isi_dokumen)?>
                                                            <?php endif;?>
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
                                                                    <?=Html::a('<i class="la la-external-link"></i> Lihat', $v->isi_dokumen, ['class'=>'btn btn-info btn-sm btn-pill btn-elevate btn-elevate-air','target'=>'_blank'])?>
                                                                <?php endif; ?>
                                                                <?php if ($type === FileTypeHelper::TYPE_LINK || $type === FileTypeHelper::TYPE_STATIC_TEXT): ?>
                                                                <?php else: ?>
                                                                    <?= Html::a('<i class="la la-download"></i>&nbsp;Unduh', ['led/download-detail', 'kriteria' => $kriteria, 'dokumen' => $v->id, 'led' => $_GET['led'],'jenis'=>Constants::SUMBER], ['class' => 'btn btn-warning btn-sm btn-pill btn-elevate btn-elevate-air']) ?>
                                                                <?php endif; ?>
                                                        </div>

                                                    </div>
                                                </td>
                                            </tr>

                                            <?php endforeach; ?>
                                        <?php endif;?>
                                    <?php endforeach;?>


                                    </tbody>
                                </table>

                                <!--                            Tabel dokumen pendukung-->
                                <table class="table table-striped table-hover">
                                    <thead class="thead-light">
                                    <tr>
                                        <th colspan="3" class="text-center">Dokumen Pendukung</th>
                                    </tr>
                                    </thead>
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>Kode</th>
                                        <th colspan="2">Nama Dokumen</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    foreach ($item['dokumen_pendukung'] as $keyDokpen => $dokpen):
                                        $dokpenAttr = '_' . str_replace('.', '_', $dokpen['kode']);
                                        ?>
                                        <?php if (empty($dokpen['kode'])): ?>
                                        <tr>
                                            <td colspan="3">Tidak ada dokumen</td>
                                        </tr>
                                        <?php else: ?>
                                        <tr>
                                            <th scope="row">
                                                <?=$dokpen['kode']?>
                                            </th>
                                            <td>
                                                <?=$dokpen['dokumen']?>
                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                            <?php
                                            $detailClass = 'common\\models\\kriteria9\\led\\prodi\\K9LedProdiKriteria' . $kriteria . 'Detail';
                                            $detail = call_user_func($detailClass . '::find')->where(['id_led_prodi_kriteria' . $kriteria=>$model->id]);

                                            $detail1 = $detail->andWhere(['kode_dokumen' => $dokpen['kode'],'jenis_dokumen'=>Constants::PENDUKUNG])->all();

                                            foreach ($detail1 as $k => $v):
                                                ?>
                                            <tr>
                                                <td><?=$k+1?></td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-lg-12 text-center">
                                                            <?= FileIconHelper::getIconByExtension($v->bentuk_dokumen) ?>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12 text-center">
                                                            <?php $type = FileTypeHelper::getType($v->bentuk_dokumen);

                                                            if ($type === FileTypeHelper::TYPE_STATIC_TEXT || $type === FileTypeHelper::TYPE_LINK): ?>
                                                                <?=Html::encode($v->nama_dokumen)  ?>

                                                            <?php else:?>
                                                                <?=Html::encode($v->isi_dokumen)?>
                                                            <?php endif;?>
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
                                                                    <?=Html::a('<i class="la la-external-link"></i> Lihat', $v->isi_dokumen, ['class'=>'btn btn-info btn-sm btn-pill btn-elevate btn-elevate-air','target'=>'_blank'])?>
                                                                <?php endif; ?>
                                                                <?php if ($type === FileTypeHelper::TYPE_LINK || $type === FileTypeHelper::TYPE_STATIC_TEXT): ?>
                                                                <?php else: ?>
                                                                    <?= Html::a('<i class="la la-download"></i>&nbsp;Unduh', ['led/download-detail', 'kriteria' => $kriteria, 'dokumen' => $v->id, 'led' => $_GET['led'],'jenis'=>Constants::PENDUKUNG], ['class' => 'btn btn-warning btn-sm btn-pill btn-elevate btn-elevate-air']) ?>
                                                                <?php endif; ?>
                                                        </div>

                                                    </div>
                                                </td>
                                            </tr>

                                            <?php endforeach; ?>
                                        <?php endif;?>
                                    <?php endforeach;?>


                                    </tbody>
                                </table>


                                <!--                            Tabel dokumen Lainnya-->
                                <table class="table table-striped table-hover">
                                    <thead class="thead-light">
                                    <tr>
                                        <th colspan="3" class="text-center">Dokumen Lainnya</th>
                                    </tr>
                                    </thead>
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Dokumen Lainnya</th>
                                        <th>

                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    $detailClass = 'common\\models\\kriteria9\\led\\prodi\\K9LedProdiKriteria' . $kriteria . 'Detail';
                                    $detail = call_user_func($detailClass . '::find')->where(['id_led_prodi_kriteria' . $kriteria=>$model->id]);

                                    $detail1 = $detail->andWhere(['jenis_dokumen'=>Constants::LAINNYA])->all();

                                    foreach ($detail1 as $k => $v):
                                        ?>
                                        <tr>
                                            <td><?=$k+1?></td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-lg-12 text-center">
                                                        <?= FileIconHelper::getIconByExtension($v->bentuk_dokumen) ?>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 text-center">
                                                        <?php $type = FileTypeHelper::getType($v->bentuk_dokumen);

                                                        if ($type === FileTypeHelper::TYPE_STATIC_TEXT || $type === FileTypeHelper::TYPE_LINK): ?>
                                                            <?=Html::encode($v->nama_dokumen)  ?>

                                                        <?php else:?>
                                                            <?=Html::encode($v->isi_dokumen)?>
                                                        <?php endif;?>
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
                                                            <?=Html::a('<i class="la la-external-link"></i> Lihat', $v->isi_dokumen, ['class'=>'btn btn-info btn-sm btn-pill btn-elevate btn-elevate-air','target'=>'_blank'])?>
                                                        <?php endif; ?>
                                                        <?php if ($type === FileTypeHelper::TYPE_LINK || $type === FileTypeHelper::TYPE_STATIC_TEXT): ?>
                                                        <?php else: ?>
                                                            <?= Html::a('<i class="la la-download"></i>&nbsp;Unduh', ['led/download-detail', 'kriteria' => $kriteria, 'dokumen' => $v->id, 'led' => $_GET['led'],'jenis'=>Constants::LAINNYA], ['class' => 'btn btn-warning btn-sm btn-pill btn-elevate btn-elevate-air']) ?>
                                                        <?php endif; ?>

                                                    </div>

                                                </div>
                                            </td>
                                        </tr>

                                    <?php endforeach; ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>

            <!--end::Accordion-->

        </div>
    </div>
</div>

