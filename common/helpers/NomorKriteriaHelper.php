<?php


namespace common\helpers;


class NomorKriteriaHelper
{

    public static function changeToJsonFormat($param){
        $first = substr($param,1);
        return str_replace('_', '.', $first);
    }

    public static function changeToDbFormat($param){
        return '_' . str_replace('.', '_', $param);
    }

}
