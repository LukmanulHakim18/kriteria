<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12">

        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="flaticon2-graph-1"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        <?= "<?= " ?>Html::encode($this->title) ?> <small>portlet sub title</small>
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create">

                    <?= "<?= " ?>$this->render('_form', [
                    'model' => $model,
                    ]) ?>

                </div>
            </div>
            <div class="kt-portlet__foot kt-hidden">
                <div class="row">
                    <div class="col-lg-6">
                        Portlet footer:
                    </div>
                    <div class="col-lg-6">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <span class="kt-margin-left-10">or <a href="#" class="kt-link kt-font-bold">Cancel</a></span>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Portlet-->

    </div>
</div>

