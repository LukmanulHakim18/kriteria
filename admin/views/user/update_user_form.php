<?php

use common\models\FakultasAkademi;
use common\models\User;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\forms\user\UpdateUserForm */
/* @var $modelPassword common\models\forms\user\UserPasswordForm */
/* @var $form ActiveForm */
/* @var $dataFakultas FakultasAkademi[] */
/* @var $dataRoles [] */
$this->title = 'Update User';
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="row">
    <div class="col-lg-12">

        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="flaticon2-add-1"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        <?= Html::encode($this->title) ?>
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="user-create">

                    <div class="update_user_form">

                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'username')->textInput() ?>
                        <?= $form->field($model, 'email')->textInput() ?>
                        <?= $form->field($model, 'status')->dropDownList([User::STATUS_ACTIVE => 'Aktif', User::STATUS_INACTIVE => 'Tidak Aktif'], ['prompt' => 'Pilih Status User']) ?>
                        <?= $form->field($model, 'hak_akses')->dropDownList( $dataRoles,['prompt'=>'Pilih Hak Akses']) ?>

                        <?= $form->field($model, 'nama_lengkap')->textInput() ?>
                        <?= $form->field($model, 'id_fakultas')->widget(Select2::class, [
                            'data' => $dataFakultas,
                            'name' => 'id_fakultas',
                            'options' => [
                                'placeholder' => 'Pilih Fakultas/Akademi',
                                'id' => 'id_fakultas',
                            ],
                            'pluginOptions' => [
                                'allowClear'=>true
                            ]
                        ]) ?>
                        <?= $form->field($model, 'id_prodi')->widget(DepDrop::class, [
                            'data' => [$model->id_prodi => 'default'],
                            'options' => ['id' => 'id_prodi'],
                            'type' => DepDrop::TYPE_SELECT2,
                            'pluginOptions' => [
                                'depends' => ['id_fakultas'],
                                'placeholder' => 'Pilih Program Studi',
                                'url' => [\yii\helpers\Url::toRoute(['user/get-prodi'])],
                                'initialize' => true,
                                'allowClear'=>true


                            ]
                        ]) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>

                    </div><!-- create_user_form -->


                </div>
            </div>
        </div>
        <!--end::Portlet-->

    </div>
</div>


<div class="row">
    <div class="col-lg-12">

        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="flaticon2-add-1"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        <?= Html::encode($this->title) ?>
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="user-create">

                    <div class="update_password_from">

                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($modelPassword, 'oldPassword')->passwordInput() ?>
                        <?= $form->field($modelPassword, 'newPassword')->passwordInput() ?>
                        <?= $form->field($modelPassword, 'repeatPassword')->passwordInput() ?>


                        <div class="form-group">
                            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>

                    </div><!-- create_user_form -->


                </div>
            </div>
        </div>
        <!--end::Portlet-->

    </div>
</div>

