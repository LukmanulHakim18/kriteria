<?php


namespace common\assets\metronic;


use yii\web\AssetBundle;

class MetronicLoginPageDemo6Asset extends AssetBundle
{
    public $sourcePath = '@common/assets/metronic/assets';



    public $depends = [BaseMetronicAsset::class];

    public $css = [
        'css/demo6/pages/general/login/login-3.css'
    ];

    public $js = [
        'js/demo6/scripts.bundle.js',

//        'js/pages/login/login-general.js'
    ];

}