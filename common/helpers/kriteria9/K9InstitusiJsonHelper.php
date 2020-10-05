<?php
/**
 * Project: kriteria.
 * @author Adryan Eka Vandra <adryanekavandra@gmail.com>
 *
 * Date: 11/4/2019
 * Time: 9:24 AM
 */

namespace common\helpers\kriteria9;

use JsonMapper;
use Yii;
use yii\helpers\Json;

class K9InstitusiJsonHelper implements IK9JsonHelper
{

    public static function getAllJsonLk($jenis)
    {
        return self::getJson('lk');
    }

    static function getJson($tipe, $jenis = '')
    {
        $filename = '';
        switch ($tipe) {
            case 'led':
                $filename = 'led_institusi.json';
                break;
            case 'lk':
                $filename = "lkpt_institusi_$jenis.json";
                break;
        }
        $path = Yii::getAlias('@required/kriteria9/apt/' . $filename);
        return Json::decode(file_get_contents($path));
    }

    public static function getJsonKriteriaLk(int $kriteria, $jenis)
    {
        $json = self::getJson('lk');
        return $json[$kriteria - 1];
    }

    public static function getAllJsonLed($jenis = '')
    {
        return self::getJson('led', $jenis);
    }

    public static function getJsonKriteriaLed(int $kriteria)
    {
        $json = self::getJson('led');
        return $json[$kriteria - 1];
    }

    public static function getJsonLedKondisiEksternal()
    {
        // TODO: Implement getJsonLedKondisiEksternal() method.
    }

    public static function getJsonLedProfil()
    {
        // TODO: Implement getJsonLedProfil() method.
    }

    public static function getJsonLedAnalisis()
    {
        // TODO: Implement getJsonLedAnalisis() method.
    }

    public static function getJsonPenilaian($jenis)
    {
        // TODO: Implement getJsonPenilaian() method.
    }

    static function provideMapper()
    {
        return new JsonMapper();
    }
}
