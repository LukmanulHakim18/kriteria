<?php

use common\models\CreateUserForm;
use common\models\FakultasAkademi;
use common\models\User;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CreateUserForm */
/* @var $modelPassword common\models\UserPasswordForm */
/* @var $form ActiveForm */
/* @var $dataFakultas FakultasAkademi[] */
$this->title = 'Update User';
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="green">
                <i class="material-icons">file_copy</i>

            </div>
            <div class="card-content">
                <h4 class="card-title">
                    <?= Html::encode($this->title) ?>
                </h4>

                <div class="update_user_form">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'username')->textInput() ?>
                    <?= $form->field($model, 'email')->textInput() ?>
                    <?= $form->field($model, 'status')->dropDownList([User::STATUS_ACTIVE => 'Aktif', User::STATUS_INACTIVE => 'Tidak Aktif'], ['prompt' => 'Pilih Status User']) ?>
                    <?= $form->field($model, 'is_admin')->checkbox() ?>
                    <?= $form->field($model, 'is_institusi')->checkbox() ?>
                    <?= $form->field($model, 'is_fakultas')->checkbox() ?>
                    <?= $form->field($model, 'is_prodi')->checkbox() ?>
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
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="green">
                <i class="material-icons">file_copy</i>

            </div>
            <div class="card-content">
                <h4 class="card-title">
                    <?= "Update Password" ?>
                </h4>

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
</div>
