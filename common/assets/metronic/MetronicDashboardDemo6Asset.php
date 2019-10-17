<?php


namespace common\assets\metronic;


use dominus77\sweetalert2\assets\SweetAlert2Asset;
use fedemotta\datatables\DataTablesAsset;
use fedemotta\datatables\DataTablesBootstrapAsset;
use fedemotta\datatables\DataTablesTableToolsAsset;
use yii\web\AssetBundle;

class MetronicDashboardDemo6Asset extends AssetBundle
{

    public $sourcePath = '@common/assets/metronic/assets';


    public $depends = [BaseMetronicDemo6Asset::class, SweetAlert2Asset::class];
    public $css = [];
    public $js = [
        'js/demo6/scripts.bundle.js',
        'js/demo6/pages/dashboard.js',
        'js/demo6/pages/my-script.js'
    ];
}