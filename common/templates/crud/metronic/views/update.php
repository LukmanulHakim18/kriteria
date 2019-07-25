<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$modelClassName = Inflector::camel2words(StringHelper::basename($generator->modelClass));
$nameAttributeTemplate = '$model->' . $generator->getNameAttribute();
$titleTemplate = $generator->generateString('Update ' . $modelClassName . ': {name}', ['name' => '{nameAttribute}']);
if ($generator->enableI18N) {
    $title = strtr($titleTemplate, ['\'{nameAttribute}\'' => $nameAttributeTemplate]);
} else {
    $title = strtr($titleTemplate, ['{nameAttribute}\'' => '\' . ' . $nameAttributeTemplate]);
}

echo "<?php\n";
?>

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= $title ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model-><?= $generator->getNameAttribute() ?>, 'url' => ['view', <?= $urlParams ?>]];
$this->params['breadcrumbs'][] = <?= $generator->generateString('Update') ?>;
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
                <div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-update">

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

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="green">
                <i class="material-icons">file_copy</i>

            </div>
            <div class="card-content">
                <h4 class="card-title">
                    <?= "<?= " ?>Html::encode($this->title) ?>
                </h4>



            </div>
        </div>
    </div>
</div>


