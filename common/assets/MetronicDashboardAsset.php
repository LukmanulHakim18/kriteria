<?php


namespace common\assets;


use yii\web\AssetBundle;

class MetronicDashboardAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';


    public $depends = [BaseMetronicAsset::class];
    public $css = [];
    public $js = [
        'js/pages/dashboard.js',
        'js/pages/my-script.js'
    ];
}