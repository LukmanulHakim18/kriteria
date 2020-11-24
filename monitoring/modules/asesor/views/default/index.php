<?php
/**
 * @var $this yii\web\View
 * @var $aptDataProvider yii\data\ActiveDataProvider
 * @var $apsDataProvider yii\data\ActiveDataProvider
 */


$this->title = 'Index Asesor';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asesor-default-index">
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                   Akreditasi Program Studi
                </h3>
            </div>
        </div>

        <div class="kt-portlet__body">
           <?= \kartik\grid\GridView::widget([
               'dataProvider' => $apsDataProvider,
               'summary' => false,
               'columns' => [
                   ['class'=>\kartik\grid\SerialColumn::class,'header' => 'No.'],
                   'akreditasi.lembaga',
                   'akreditasi.tahun',
                   'prodi.nama',
                   ['label' => 'Laporan Evaluasi Diri',
                       'value' => function($model,$key,$index,$widget){
                            return $model->k9LedProdi->progress;
                       }],
                   ['label' => 'Laporan Kinerja',
                       'value'=>function($model, $key, $index,$widget){
               return $model->k9LkProdi->progress;
                       }],
                   ['class'=>\common\widgets\ActionColumn::class,'header' => 'Aksi',
                       'template' => '{nilai}',
                       'buttons' => [
                           'nilai'=>function($url,$model){
                                return \yii\bootstrap4\Html::a('Nilai',['prodi/index','id'=>$model->id],['class'=>'btn btn-primary btn-pill btn-xs']);
                           }
                       ]
                   ]

               ]
           ])?>
        </div>
    </div>

    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    Akreditasi Program Tinggi
                </h3>
            </div>
        </div>

        <div class="kt-portlet__body">
            <?= \kartik\grid\GridView::widget([
                'dataProvider' => $aptDataProvider,
                'summary' => false,
                'columns' => [
                    ['class'=>\kartik\grid\SerialColumn::class,'header' => 'No.'],
                    'akreditasi.lembaga',
                    'akreditasi.tahun',
                    ['label' => 'Laporan Evaluasi Diri',
                        'value' => function($model,$key,$index,$widget){
                            return $model->k9LedInstitusi->progress;
                        }],
                    ['label' => 'Laporan Kinerja',
                        'value'=>function($model, $key,$index,$widget){
                            return $model->k9LkInstitusi->progress;
                        }],
                    ['class'=>\common\widgets\ActionColumn::class,'header' => 'Aksi',
                        'template' => '{nilai}',
                        'buttons' => [
                            'nilai'=>function($url,$model){
                                return \yii\bootstrap4\Html::a('Nilai',['institusi/index','id'=>$model->id],['class'=>'btn btn-primary btn-pill btn-xs']);
                            }
                        ]
                    ]
                ]
            ])?>
        </div>
    </div>

</div>
