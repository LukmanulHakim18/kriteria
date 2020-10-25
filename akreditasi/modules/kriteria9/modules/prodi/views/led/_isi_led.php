<?php
/**
 * @var $this View
 */

use common\helpers\FileIconHelper;
use common\helpers\FileTypeHelper;
use common\models\Constants;
use dosamigos\tinymce\TinyMce;
use kartik\file\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
use yii\web\View;

?>

<div class="led-content">
    <div class="row">
        <div class="col-lg-12">
            <?= $item->deskripsi ?>
        </div>
    </div>
    <div class="clearfix"></div>


    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['action' => \yii\helpers\Url::to(['led/isi-kriteria','led'=>$model->id,'prodi'=>$prodi,'kriteria'=>$kriteria]),'options' => ['enctype' => 'multipart/form-data'], 'id' => $modelAttribute . '-form']) ?>

            <?= $form->field($modelNarasi, $modelAttribute)->widget(TinyMce::class, [
                'options' => ['id' => $modelAttribute . '-tinymce-kriteria'],

            ])->label('') ?>

            <div class="form-group pull-right">
                <?= Html::submitButton('<i class="la la-save"></i> Simpan', ['class' => 'btn btn-primary btn-pill btn-elevate btn-elevate-air ']) ?>
            </div>
            <?php ActiveForm::end() ?>

        </div>
    </div>



    <?=$this->render('_item_dokumen',[
        'linkModel'=>$linkModel,
        'textModel'=>$textModel,
        'detailModel'=>$detailModel,
        'model'=>$model,
        'kriteria'=>$kriteria,
        'prodi'=>$prodi,
        'path'=>$path,
        'json_dokumen'=>$item->dokumen_sumber,
        'jenis'=>Constants::SUMBER,
        'detailCollection'=>$detailCollection
    ])?>

    <?=$this->render('_item_dokumen',[
        'linkModel'=>$linkModel,
        'textModel'=>$textModel,
        'detailModel'=>$detailModel,
        'model'=>$model,
        'kriteria'=>$kriteria,
        'prodi'=>$prodi,
        'path'=>$path,
        'json_dokumen'=>$item->dokumen_pendukung,
        'jenis'=>Constants::PENDUKUNG,
        'detailCollection'=>$detailCollection

    ])?>


    <!--                            Tabel dokumen Lainnya-->
    <table class="table table-striped table-hover">
        <thead class="thead-light">
        <tr>
            <th colspan="3" class="text-center">Dokumen Lainnya</th>
        </tr>
        </thead>
        <thead class="thead-light">
        <tr>
            <th>No</th>
            <th>Dokumen Lainnya</th>
            <th>
                <div class="row">
                    <div class="col-lg-12">
                        <?php Modal::begin([
                            'id'=>'teks-lainnya-'.$modelAttribute,
                            'title' => 'Dokumen Lainnya Led',
                            'toggleButton' => ['label' => '<i class="la la-file-text"></i> &nbsp;Teks', 'class' => 'btn btn-success btn-sm btn-pill btn-elevate btn-elevate-air pull-right'],
                            'size' => 'modal-lg',
                            'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                        ]) ?>
                        <?php $form = ActiveForm::begin(['action' => \yii\helpers\Url::to(['led/isi-kriteria','led'=>$model->id,'prodi'=>$prodi,'kriteria'=>$kriteria]),
                            'options' => ['enctype' => 'multipart/form-data'], 'id' => $modelAttribute . '-text-lainnya-form']) ?>

                        <?= $form->field($textModel, 'kode_dokumen')->textInput(['value' => $item->nomor, 'readonly' => true]) ?>

                        <?= $form->field($textModel, 'jenis_dokumen')->textInput(['value' => Constants::LAINNYA, 'readonly' => true]) ?>
                        <?= $form->field($textModel, 'nama_dokumen')->textInput()->label('Nama Teks') ?>
                        <?= $form->field($textModel, 'berkasDokumen')->widget(TinyMce::class, [
                            'options' => ['rows' => 6, 'id' => $modelAttribute . '-text-lainnya-input',],
                        ])->label('Teks') ?>

                        <div class="form-group pull-right">
                            <?= Html::submitButton('<i class="la la-save"></i> Simpan', ['class' => 'btn btn-primary btn-pill btn-elevate btn-elevate-air']) ?>
                        </div>
                        <?php ActiveForm::end() ?>

                        <?php Modal::end() ?>
                        <?php Modal::begin([
                            'id'=>'link-lainnya-'.$modelAttribute,

                            'title' => 'Dokumen Lainnya Led',
                            'toggleButton' => ['label' => '<i class="la la-link"></i> &nbsp;Tautan', 'class' => 'btn btn-info btn-sm btn-pill btn-elevate btn-elevate-air pull-right'],
                            'size' => 'modal-lg',
                            'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                        ]) ?>
                        <?php $form = ActiveForm::begin(['action' => \yii\helpers\Url::to(['led/isi-kriteria','led'=>$model->id,'prodi'=>$prodi,'kriteria'=>$kriteria]),'options' => ['enctype' => 'multipart/form-data'], 'id' => $modelAttribute . '-link-lainnya-form']) ?>

                        <?= $form->field($linkModel, 'kode_dokumen')->textInput(['value' => $item->nomor, 'readonly' => true]) ?>
                        <?= $form->field($linkModel, 'jenis_dokumen')->textInput(['value' => Constants::LAINNYA, 'readonly' => true]) ?>
                        <?= $form->field($linkModel, 'nama_dokumen')->textInput()->label('Nama Tautan') ?>
                        <?= $form->field($linkModel, 'berkasDokumen')->textInput(['
                                                    placeholder'=>'https://www.contoh.com'])->label('Tautan')->hint('https:// atau http:// harus dimasukkan.') ?>
                        <div class="form-group pull-right">
                            <?= Html::submitButton('<i class="la la-save"></i> Simpan', ['class' => 'btn btn-primary btn-pill btn-elevate btn-elevate-air']) ?>
                        </div>
                        <?php ActiveForm::end() ?>

                        <?php Modal::end() ?>

                        <?php Modal::begin([
                            'id'=>'upload-lainnya-'.$modelAttribute,
                            'title' => 'Upload Dokumen Lainnya Borang',
                            'toggleButton' => ['label' => '<i class="la la-upload"></i> &nbsp;Unggah', 'class' => 'btn btn-light btn-sm btn-pill btn-elevate btn-elevate-air pull-right'],
                            'size' => 'modal-lg',
                            'clientOptions' => ['backdrop' => 'blur', 'keyboard' => true]
                        ]) ?>

                        <?php $form = ActiveForm::begin(['action' => \yii\helpers\Url::to(['led/isi-kriteria','led'=>$model->id,'prodi'=>$prodi,'kriteria'=>$kriteria]),'options' => ['enctype' => 'multipart/form-data'], 'id' => $modelAttribute . '-lainnya-form']) ?>

                        <?= $form->field($detailModel, 'kode_dokumen')->textInput(['value' => $item->nomor, 'readonly' => true]) ?>
                        <?= $form->field($detailModel, 'nama_dokumen')->textInput() ?>
                        <?= $form->field($detailModel, 'jenis_dokumen')->textInput(['value' => Constants::LAINNYA, 'readonly' => true]) ?>


                        <?= $form->field($detailModel, 'berkasDokumen')->widget(FileInput::class, [
                            'options' => ['id' => 'dokumenLainnya' . $modelAttribute],
                            'pluginOptions' => [
                                'allowedFileExtensions' => Constants::ALLOWED_EXTENSIONS,
                            ]
                        ]) ?>
                        <div class="form-group pull-right">
                            <?= Html::submitButton('<i class="la la-save"></i> Simpan', ['class' => 'btn btn-primary btn-pill btn-elevate btn-elevate-air']) ?>
                        </div>
                        <?php ActiveForm::end() ?>

                        <?php Modal::end() ?>
                        <?=Html::submitButton('<i class="flaticon2-laptop"></i> Gunakan Data',['value'=>\yii\helpers\Url::to(['resource/index','prodi'=>$_GET['prodi'],'kriteria'=>$kriteria,'kode'=>'','jenis'=>Constants::LED,'id_led_lk'=>$_GET['led'],'jenis_dokumen'=>Constants::LAINNYA]),'title'=>'Gunakan Data Untuk Dokumen lainnya ' ,'class'=>'btn btn-warning btn-pill btn-elevate btn-elevate-air showModalButton pull-right'])?>
                    </div>
                </div>

            </th>
        </tr>
        </thead>

        <tbody>
        <?php
        $detail = $detailCollection->where('jenis_dokumen',Constants::LAINNYA)->values()->all();

        foreach ($detail as $k => $v):
            ?>
            <tr>
                <td><?= $k + 1 ?></td>
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
                                <?= Html::a('<i class="la la-external-link"></i> Lihat', $v->isi_dokumen, ['class' => 'btn btn-info btn-sm btn-pill btn-elevate btn-elevate-air', 'target' => '_blank']) ?>
                            <?php endif; ?>
                            <?php if ($type === FileTypeHelper::TYPE_LINK || $type === FileTypeHelper::TYPE_STATIC_TEXT): ?>

                            <?php else: ?>
                                <?= Html::a('<i class="la la-download"></i>&nbsp;Unduh', ['led/download-detail', 'kriteria' => $kriteria, 'dokumen' => $v->id, 'led' => $_GET['led'], 'jenis' => Constants::LAINNYA], ['class' => 'btn btn-warning btn-sm btn-pill btn-elevate btn-elevate-air']) ?>
                            <?php endif; ?>
                            <?= Html::a('<i class ="la la-trash"></i>&nbsp; Hapus', ['led/hapus-detail'], [
                                'class' => 'btn btn-danger btn-sm btn-pill btn-elevate btn-elevate-air',
                                'data' => [
                                    'method' => 'POST',
                                    'confirm' => 'Apakah anda yakin menghapus item ini?',
                                    'params' => ['dokumen' => $v->id, 'kriteria' => $kriteria, 'led' => $_GET['led'], 'jenis' => Constants::LAINNYA, 'prodi' => $prodi]
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
