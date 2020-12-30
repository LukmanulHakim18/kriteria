<?php

use common\models\Constants;
use dmstr\ajaxbutton\AjaxButton;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Berkas */
/* @var $form yii\bootstrap4\ActiveForm; */
/* @var $detailModel common\models\DetailBerkas;*/
/* @var $urlPath string*/
?>


<div class="berkas-form">

    <?php $form = ActiveForm::begin(['id'=>'berkas-form']); ?>

    <?= $form->field($model, 'nama_berkas')->textInput(['maxlength' => true]) ?>
    <?php if (!$model->isNewRecord):?>
        <div id="current-berkas">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th>Berkas</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($model->detailBerkas as $detail): ?>
                <tr>
                    <td><?=$detail->isi_berkas?></td>
                    <td><?=Html::a('Lihat', "$urlPath/{$detail->isi_berkas}", ['class'=>'btn btn-info btn-elevate btn-elevate-air','target'=>'_blank'])?>
                        <?= AjaxButton::widget([
                            'id' => 'hapus-berkas-button',
                            'url' => ['berkas/delete-berkas'],
                            'method' => 'POST',
                            'content' => Yii::t('app', 'Hapus'),
                            'options' => ['class'=>'btn btn-danger btn-elevate btn-elevate-air'],
                            'params' => ['id'=>$detail->id],
                            'successExpression' => new JsExpression('function(resp,status,xhr){
                            if(resp){
                                const elem = document.getElementById("current-berkas");
                                elem.parentNode.removeChild(elem);
                            }

                            }')
                        ])?>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif;?>
    <?=$form->field($detailModel, 'berkas[]')->widget(kartik\file\FileInput::class, [
        'options' => ['multiple'=>true],
        'pluginOptions' => [
            'allowedFileExtensions' => Constants::ALLOWED_EXTENSIONS,
        ]

    ])?>

    <div class="form-group">
        <?= Html::submitButton('<i class=\'la la-save\'></i> Simpan', ['class' => 'btn btn-pill btn-elevate btn-elevate-air btn-brand']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $js = <<<JS
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

        KTApp.blockPage({
            overlayColor: '#000000',
            type: 'v2',
            state: 'primary',
            message: 'Sedang memproses...'
        });

    });

JS;

$this->registerJs($js);
?>
