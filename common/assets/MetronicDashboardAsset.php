<?php


namespace common\assets;


use dominus77\sweetalert2\assets\SweetAlert2Asset;
use fedemotta\datatables\DataTablesAsset;
use fedemotta\datatables\DataTablesBootstrapAsset;
use fedemotta\datatables\DataTablesTableToolsAsset;
use yii\web\AssetBundle;

class MetronicDashboardAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';


    public $depends = [BaseMetronicAsset::class, SweetAlert2Asset::class];
    public $css = [];
    public $js = [
        'js/scripts.bundle.js',
        'js/pages/dashboard.js',
        'js/pages/my-script.js'
    ];
}