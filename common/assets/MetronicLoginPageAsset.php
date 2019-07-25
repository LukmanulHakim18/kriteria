<?php


namespace common\assets;


use yii\web\AssetBundle;

class MetronicLoginPageAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';


    public $depends = [BaseMetronicAsset::class];

    public $css = [
        'css/pages/general/login/login-4.css'
    ];

    public $js = [
//        'js/pages/login/login-general.js'
    ];

}