<?php
/**
 * Project: devmall.
 * @author Adryan Eka Vandra <adryanekavandra@gmail.com>
 *
 * Date: 9/30/2019
 * Time: 10:17 PM
 */

namespace common\assets\metronic;


use yii\web\AssetBundle;

class BaseMetronicDemo6Asset extends AssetBundle
{

    public $sourcePath = '@common/assets/metronic/assets';


    public $depends = [
        BaseMetronicAsset::class
    ];
}