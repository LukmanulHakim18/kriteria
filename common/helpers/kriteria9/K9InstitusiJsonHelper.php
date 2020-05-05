<?php
/**
 * Project: kriteria.
 * @author Adryan Eka Vandra <adryanekavandra@gmail.com>
 *
 * Date: 11/4/2019
 * Time: 9:24 AM
 */

namespace common\helpers\kriteria9;


use Yii;
use yii\helpers\Json;

class K9InstitusiJsonHelper implements IK9JsonHelper
{

    public static function getAllJsonLk()
    {
        return self::getJson('lk');

    }

    static function getJson($tipe)
    {
        $filename = '';
        switch ($tipe) {
            case 'led':
                $filename = 'led_institusi.json';
                break;
            case 'lk':
                $filename = 'lkpt_institusi.json';
                break;
        }
        $path = Yii::getAlias('@required/kriteria9/apt/' . $filename);
        $json = Json::decode(file_get_contents($path));
        return $json;
    }

    public static function getJsonKriteriaLk(int $kriteria)
    {
        $json = self::getJson('lk');
        return $json[$kriteria - 1];
    }

    public static function getAllJsonLed()
    {
        return self::getJson('led');
    }

    public static function getJsonKriteriaLed(int $kriteria)
    {
        $json = self::getJson('led');
        return $json[$kriteria - 1];
    }
}