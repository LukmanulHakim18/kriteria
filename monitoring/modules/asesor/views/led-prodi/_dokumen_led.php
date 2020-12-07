<?php
/**
 * @var $this yii\web\View
 * @var $modelDokumen K9DokumenLedProdiUploadForm;
 * @var $dataDokumen [];
 * @var $path string
 * @var $prodi int
 */

use akreditasi\models\kriteria9\forms\led\K9DokumenLedProdiUploadForm;
use common\helpers\FileIconHelper;
use common\helpers\FileTypeHelper;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;

?>

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Dokumen LED
            </h3>
        </div>
    </div>

    <div class="kt-portlet__body">
        <div class="kt-section kt-section--first" style="margin-bottom: 0;">
            <table class="table table-hover table-light table-striped">
                <thead class="thead-light">
                <tr>

                    <th>No.</th>
                    <th>Dokumen Led</th>
                    <th>
                        Aksi
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($dataDokumen as $key => $item) : ?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td>
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <?= FileIconHelper::getIconByExtension($item->bentuk_dokumen) ?>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <?= Html::encode($item->nama_dokumen) ?>

                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="row pull-right">
                                <div class="col-lg-12">
                                    <?php $type = FileTypeHelper::getType($item->bentuk_dokumen);
                                    if ($type === FileTypeHelper::TYPE_IMAGE || $type === FileTypeHelper::TYPE_PDF):?>
                                        <?php Modal::begin([
                                            'title' => $item->nama_dokumen,
                                            'toggleButton' => [
                                                'label' => '<i class="la la-eye"></i> &nbsp;Lihat',
                                                'class' => 'btn btn-info btn-pill btn-elevate btn-elevate-air'
                                            ],
                                            'size' => 'modal-lg',
                                            'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                                        ]); ?>
                                        <?php switch ($type) {
                                            case FileTypeHelper::TYPE_IMAGE:
                                                echo Html::img("$path/{$item->nama_dokumen}",
                                                    ['height' => '100%', 'width' => '100%']);
                                                break;
                                            case FileTypeHelper::TYPE_PDF:
                                                echo '<embed src="' . $path . '/' . $item->nama_dokumen . '" type="application/pdf" height="100%" width="100%">
';
                                                break;
                                        } ?>
                                        <?php Modal::end(); ?>
                                    <?php endif; ?>
                                    <?= Html::a('<i class ="la la-download"></i> Unduh',
                                        ['led-prodi/download-dokumen', 'dokumen' => $item->id],
                                        ['class' => 'btn btn-warning btn-pill btn-elevate btn-elevate-air']) ?>
                                    <?= Html::a('<i class ="la la-trash"></i> Hapus', ['led-prodi/hapus-dokumen-led'], [
                                        'class' => 'btn btn-danger btn-pill btn-elevate btn-elevate-air',
                                        'data' => [
                                            'method' => 'POST',
                                            'confirm' => 'Apakah anda yakin menghapus item ini?',
                                            'params' => ['id' => $item->id, 'prodi' => $prodi]
                                        ]
                                    ]) ?>
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

