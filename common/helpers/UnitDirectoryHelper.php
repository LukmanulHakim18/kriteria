<?php
/**
 * Project: mutu-v2.
 * @author Adryan Eka Vandra <adryanekavandra@gmail.com>
 *
 * Date: 14/09/19
 * Time: 05.56
 */

namespace common\helpers;


use Yii;

class UnitDirectoryHelper
{

    public static function getUnitPath($id){
        $p = Yii::$app->params['uploadUnit'];
        $replacement = ['{id_unit}'=>$id];
        $path = strtr($p,$replacement);
        $realPath = Yii::getAlias('@uploadAkreditasi/'.$path);

        return $realPath;
    }

    public static function getUnitUrl($id){
        $p = Yii::$app->params['uploadUnit'];
        $replacement = ['{id_unit}'=>$id];
        $path = strtr($p,$replacement);
        $realPath = Yii::getAlias('@web/upload/'.$path);

        return $realPath;
    }
}