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
            <?php $form = ActiveForm::begin(['action' => \yii\helpers\Url::to(['led/isi-non-kriteria','led'=>$model->id,'prodi'=>$prodi->id,'poin'=>$poin]),'options' => ['enctype' => 'multipart/form-data'], 'id' => $modelAttribute . '-form']) ?>

            <?= $form->field($modelNarasi, $modelAttribute)->widget(TinyMce::class, [
                'options' => ['id' => $modelAttribute . '-tinymce-poin'],

            ])->label('') ?>

            <div class="form-group pull-right">
                <?= Html::submitButton('<i class="la la-save"></i> Simpan', ['class' => 'btn btn-primary btn-pill btn-elevate btn-elevate-air ']) ?>
            </div>
            <?php ActiveForm::end() ?>

        </div>
    </div>



    <?=$this->render('_item_dokumen_non_kriteria',[
        'linkModel'=>$linkModel,
        'textModel'=>$textModel,
        'uploadModel'=>$uploadModel,
        'model'=>$model,
        'poin'=>$poin,
        'prodi'=>$prodi,
        'path'=>$path,
        'json_dokumen'=>$item->dokumen_sumber,
        'jenis'=>Constants::SUMBER,
        'detailCollection'=>$detailCollection
    ])?>

    <?=$this->render('_item_dokumen_non_kriteria',[
        'linkModel'=>$linkModel,
        'textModel'=>$textModel,
        'uploadModel'=>$uploadModel,
        'model'=>$model,
        'poin'=>$poin,
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
                        <?php $form = ActiveForm::begin(['action' => \yii\helpers\Url::to(['led/isi-non-kriteria','led'=>$model->id,'prodi'=>$prodi->id,'poin'=>$poin]),
                            'options' => ['enctype' => 'multipart/form-data'], 'id' => $modelAttribute . '-text-lainnya-form']) ?>
                        <?= $form->field($textModel, 'kode_dokumen')->textInput(['value' => $poin.'.'.$item->nomor, 'readonly' => true]) ?>

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
                        <?php $form = ActiveForm::begin(['action' => \yii\helpers\Url::to(['led/isi-non-kriteria','led'=>$model->id,'prodi'=>$prodi->id,'poin'=>$poin]),'options' => ['enctype' => 'multipart/form-data'], 'id' => $modelAttribute . '-link-lainnya-form']) ?>

                        <?= $form->field($linkModel, 'kode_dokumen')->textInput(['value' => $poin.'.'.$item->nomor, 'readonly' => true]) ?>
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

                        <?php $form = ActiveForm::begin(['action' => \yii\helpers\Url::to(['led/isi-non-kriteria','led'=>$model->id,'prodi'=>$prodi->id,'poin'=>$poin]),'options' => ['enctype' => 'multipart/form-data'], 'id' => $modelAttribute . '-lainnya-form']) ?>

                        <?= $form->field($uploadModel, 'kode_dokumen')->textInput(['value' => $poin.'.'.$item->nomor, 'readonly' => true]) ?>
                        <?= $form->field($uploadModel, 'nama_dokumen')->textInput() ?>
                        <?= $form->field($uploadModel, 'jenis_dokumen')->textInput(['value' => Constants::LAINNYA, 'readonly' => true]) ?>


                        <?= $form->field($uploadModel, 'berkasDokumen')->widget(FileInput::class, [
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
                        <?php //echo Html::submitButton('<i class="flaticon2-laptop"></i> Gunakan Data',['value'=>\yii\helpers\Url::to(['resource/index','prodi'=>$_GET['prodi'],'poin'=>$poin,'kode'=>'','jenis'=>Constants::LED,'id_led_lk'=>$_GET['led'],'jenis_dokumen'=>Constants::LAINNYA]),'title'=>'Gunakan Data Untuk Dokumen lainnya ' ,'class'=>'btn btn-warning btn-pill btn-elevate btn-elevate-air showModalButton pull-right'])?>
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
            <?=$this->render('_item_dokumen_detail_non_kriteria',[
            'path'=>$path,
            'poin'=>$poin,
            'jenis'=>'lainnya',
            'detail'=>$v,
            'nomor'=>$k+1,
            'prodi'=>$prodi,
            'led'=>$model
        ])?>

        <?php endforeach; ?>
        </tbody>
    </table>

</div>
