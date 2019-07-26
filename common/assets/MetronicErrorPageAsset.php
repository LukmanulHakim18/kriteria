<?php


namespace common\assets;


use dominus77\sweetalert2\assets\SweetAlert2Asset;
use yii\web\AssetBundle;

class MetronicErrorPageAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $depends = [BaseMetronicAsset::class,SweetAlert2Asset::class];

    public $css = [
        'css/pages/general/error/error-6.css'
    ];

    public $js = [
        'js/scripts.bundle.js',
        'js/pages/my-script.js'


    ];

}