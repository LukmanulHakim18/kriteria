<?php
/**
 * Project: devmall.
 * @author Adryan Eka Vandra <adryanekavandra@gmail.com>
 *
 * Date: 9/30/2019
 * Time: 10:13 PM
 */
namespace common\assets\metronic;

class BaseMetronicDemo1Asset extends \yii\web\AssetBundle
{

    public $sourcePath = '@common/assets/metronic/assets';


    public $css = [
        'css/demo1/skins/header/base/light.css',
        'css/demo1/skins/header/menu/light.css',
        'css/demo1/skins/brand/dark.css',
        'css/demo1/skins/aside/dark.css'
    ];

    public $depends = [
        BaseMetronicAsset::class
    ];
}