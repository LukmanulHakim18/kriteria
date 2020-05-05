<?php


namespace common\assets\metronic;


use yii\web\AssetBundle;

class MetronicLoginPageDemo1Asset extends AssetBundle
{
    public $sourcePath = '@common/assets/metronic/assets';



    public $depends = [BaseMetronicAsset::class];

    public $css = [
        'css/demo1/pages/general/login/login-4.css'
    ];

    public $js = [
        'js/demo1/scripts.bundle.js',

//        'js/pages/login/login-general.js'
    ];

}