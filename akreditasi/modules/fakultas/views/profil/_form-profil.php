<?php

use common\models\Constants;
use dosamigos\tinymce\TinyMce;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\FakultasAkademi */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $profil common\models\Profil */
/* @var $strukturModel akreditasi\models\kriteria9\forms\StrukturOrganisasiUploadForm */
?>


<div class="profil-fakultas-akademi-form">

    <?php $form = ActiveForm::begin(['id' => 'profil-fakultas-form']); ?>

    <?= $form->field($profil, 'visi')->widget(TinyMce::class,[

    ]) ?>


    <?= $form->field($profil, 'misi')->widget(TinyMce::class,[


    ]) ?>
    <?= $form->field($profil, 'tujuan')->widget(TinyMce::class,[


    ]) ?>
    <?= $form->field($profil, 'sasaran')->widget(TinyMce::class,[


    ]) ?>
    <?= $form->field($profil, 'motto')->widget(TinyMce::class,[


    ]) ?>
    <?= $form->field($profil, 'sambutan')->widget(TinyMce::class,[


    ]) ?>
    <?php if($profil->struktur_organisasi):?>
        <div id="current-struktur">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th>Berkas Struktur Organisasi Saat ini</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?=Html::img(Yii::getAlias("@.uploadStruktur/{$profil->type}/{$model->id}/{$profil->struktur_organisasi}"),['width'=>'50%'])?></td>
                    <td>
                        <?=\dmstr\ajaxbutton\AjaxButton::widget([
                                'id' => 'hapus-struktur-button',
                            'url' => ['profil/hapus-struktur'],
                            'method' => 'POST',
                            'content' => Yii::t('app','Hapus'),
                            'options' => ['class'=>'btn btn-danger btn-elevate btn-elevate-air'],
                            'params' => ['nama'=>$profil->struktur_organisasi,'id'=>$profil->external_id],
                            'successExpression' => new \yii\web\JsExpression('function(resp,status,xhr){
                            if(resp){
                                const elem = document.getElementById("current-struktur");
                                elem.parentNode.removeChild(elem);
                            }

                            }')
                        ])?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

    <?php endif; ?>
    <?= $form->field($strukturModel, 'struktur')->widget(FileInput::class,[

        'pluginOptions' => [
            'allowedFileExtensions' => Constants::IMAGE_EXTENSIONS,
        ]
    ]) ?>


    <div class="form-group">
        <?= Html::submitButton('<i class=\'la la-save\'></i> Simpan', ['class' => 'btn btn-pill btn-elevate btn-elevate-air btn-brand block-ui']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$jsForm = <<<JS
 $('form').on('beforeSubmit', function()
    {
        var form = $(this);
        //console.log('before submit');

        var submit = form.find(':submit');
        KTApp.block('.modal',{
            overlayColor: '#000000',
            type: 'v2',
            state: 'primary',
            message: 'Sedang Memproses...'
        });
        submit.html('<i class="flaticon2-refresh"></i> Sedang Memproses');
        submit.prop('disabled', true);

    });

JS;

$this->registerJs($jsForm);
?>
