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
use yii\helpers\Json;

class K9ProdiProgressHelper implements IK9ProgressHelper
{

    use K9ProgressTrait;


    public static function getDokumenLedProgress($led, $detail, $kriteria)
    {

        $progress = 0;
        $filename = 'led_prodi.json';
        $filejson = file_get_contents(Yii::getAlias('@required/kriteria9/aps/' . $filename));

        return self::hitung($detail,$kriteria,$filejson);

    }

    public static function getDokumenLkProgress($lk, $dokumen, $kriteria)
    {

        $prodi = $lk->lkProdi->akreditasiProdi->prodi;
        $filename = 'lkps_prodi_'.$prodi->jenjang.'.json';
        $filejson = file_get_contents(Yii::getAlias('@required/kriteria9/aps/' . $filename));

        return self::hitung($dokumen, $kriteria,$filejson);


    }


}
