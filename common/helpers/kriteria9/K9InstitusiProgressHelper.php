<?php
/**
 * mutu-v2
 * @author Adryan Eka Vandra <adryanekavandra@gmail.com>
 */
/**
 * Class K9InstitusiProgressHelper
 * @package common\helpers\kriteria9
 */


namespace common\helpers\kriteria9;


use common\models\Constants;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class K9InstitusiProgressHelper implements IK9ProgressHelper
{
    use K9ProgressTrait;


    /**
     * Membandingkan antara json dan data yang ada.
     * Tahap: 1. Dapatkan data dari json.
     * 2. Hitung semua jumlah dokumen yang ada.
     * 3. Bandingkan jumlah dokumen dengan jumlah dokumen dengan nomor unique yang ada.
     * 4. Hitung perbedaannya dan return progress
     * @param $led
     * @param $detail
     * @param $kriteria
     * @return double
     */
    public static function getDokumenLedProgress($led, $detail, $kriteria)
    {

        $progress = 0;
        $filename = 'led_institusi.json';
        $filejson = file_get_contents(Yii::getAlias('@required/kriteria9/apt/'.$filename));

       return self::hitung($detail,$kriteria,$filejson);
    }

    public static function getDokumenLkProgress($lk, $dokumen, $kriteria)
    {
        $progress = 0;
        $filename = 'lkpt_institusi_akademik.json';
        $filejson = file_get_contents(Yii::getAlias('@required/kriteria9/apt/'.$filename));

       return self::hitung($dokumen,$kriteria,$filejson);
    }
}
