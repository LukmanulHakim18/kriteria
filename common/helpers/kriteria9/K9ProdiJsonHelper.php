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

class K9ProdiJsonHelper
{

    public static function getAllJsonLk($jenis)
    {
        return self::getJson('lk', $jenis);
    }

    public static function getJson($tipe, $jenis = '')
    {
        $filename = '';
        switch ($tipe) {
            case 'led':
                $filename = 'led_prodi.json';
                break;
            case 'lk':
                $filename = "lkps_prodi_$jenis.json";
                break;
        }
        $path = Yii::getAlias('@required/kriteria9/aps/' . $filename);
        return Json::decode(file_get_contents($path));
    }

    public static function getJsonKriteriaLk(int $kriteria, string $jenis)
    {
        $json = self::getJson('lk', $jenis);
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
