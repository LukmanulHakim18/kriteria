<?php

use yii\grid\SerialColumn;
use common\widgets\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel akreditasi\models\fakultas\BerkasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Berkas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12">

        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="flaticon2-list-2"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        <?= Html::encode($this->title) ?> <small>portlet sub title</small>
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">

                            <?= Html::button('<i class=flaticon2-add></i> Tambah Berkas', ['value' => Url::to(['create','fakultas'=>Yii::$app->request->get('fakultas')]), 'title' => 'Tambah Berkas', 'class' => 'showModalButton btn btn-success btn-elevate btn-elevate-air']); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="berkas-index">




                                                                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                                            <?= GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'filterModel' => $searchModel,
                                            'columns' => [
                                            ['class' => SerialColumn::class,'header'=>'No'],

//                                            'id',
//                                            'external_id',
//                                            'type',
                                            'nama_berkas',
                                            'created_at:datetime',
            //'updated_at',

                                            ['class' => ActionColumn::class,'header'=>'Aksi',]
                                            ],
                        ]); ?>


                </div>
            </div>
        </div>
        <!--end::Portlet-->

    </div>
</div>
