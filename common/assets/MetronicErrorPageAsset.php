<?php


namespace common\assets;


use yii\web\AssetBundle;

class MetronicErrorPageAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $depends = [BaseMetronicAsset::class];

    public $css = [
        'css/pages/general/error/error-3.css'
    ];

    public $js = [
        'js/scripts.bundle.js',

    ];

}