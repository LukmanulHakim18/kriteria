<?php


namespace common\assets\metronic;


use dominus77\sweetalert2\assets\SweetAlert2Asset;
use yii\web\AssetBundle;

class MetronicErrorPageDemo6Asset extends AssetBundle
{
    public $sourcePath = '@common/assets/metronic/assets';

    public $depends = [BaseMetronicDemo6Asset::class,SweetAlert2Asset::class];

    public $css = [
        'css/demo6/pages/general/error/error-6.css'
    ];

    public $js = [
        'js/demo6/scripts.bundle.js',
        'js/demo6/pages/my-script.js'


    ];

}