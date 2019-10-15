<?php
/**
 * mutu-v2
 * @author Adryan Eka Vandra <adryanekavandra@gmail.com>
 */
/**
 * Class K9InstitusiDirectoryHelper
 * @package common\helpers\kriteria9
 */


namespace common\helpers\kriteria9;


use common\models\kriteria9\akreditasi\K9AkreditasiInstitusi;
use Yii;

class K9InstitusiDirectoryHelper extends K9DirectoryHelper
{
    private static function getK9InstitusiPath(K9AkreditasiInstitusi $akreditasiInstitusi)
    {
        $pathData = Yii::$app->params['uploadPath'];
        $pathReplacements = [
            '{lembaga}'=> $akreditasiInstitusi->akreditasi->lembaga,
            '{jenis_akreditasi}'=>$akreditasiInstitusi->akreditasi->jenis_akreditasi,
            '{tahun}'=> $akreditasiInstitusi->akreditasi->tahun,
            '{level}'=>'institusi',
            '{id}'=>''
        ];
        $result = strtr($pathData,$pathReplacements);
        $realPath = "$result";

        return $realPath;
    }

    public static function getDokumenLedPath($akreditasi)
    {

        $path = Yii::getAlias('@uploadAkreditasi');
        $documentPath = self::getK9InstitusiPath($akreditasi);
        $realPath = "$path/$documentPath/led";

        return $realPath;
    }

    public static function getDokumenLedUrl($akreditasi)
    {
        $path = Yii::getAlias('@web/upload');
        $documentPath = self::getK9InstitusiPath($akreditasi);
        $realPath = "$path/$documentPath/led";

        return $realPath;
    }

    public static function getDetailLedPath($akreditasi)
    {
        $path = Yii::getAlias('@uploadAkreditasi');
        $documentPath = self::getK9InstitusiPath($akreditasi);
        $realPath = "$path/$documentPath/led";

        return $realPath;
    }

    public static function getDetailLedUrl($akreditasi)
    {
        $path = Yii::getAlias('@web/upload');
        $documentPath = self::getK9InstitusiPath($akreditasi);
        $realPath = "$path/$documentPath/led";

        return $realPath;
    }

    public static function getDokumenLkPath($akreditasi)
    {
        $path = Yii::getAlias('@uploadAkreditasi');
        $documentPath = self::getK9InstitusiPath($akreditasi);
        $realPath = "$path/$documentPath/lk";

        return $realPath;
    }

    public static function getDokumenLkUrl($akreditasi)
    {
        $path = Yii::getAlias('@web/upload');
        $documentPath = self::getK9InstitusiPath($akreditasi);
        $realPath = "$path/$documentPath/lk";

        return $realPath;
    }

    public static function getDetailLkPath($akreditasi)
    {
        $path = Yii::getAlias('@uploadAkreditasi');
        $documentPath = self::getK9InstitusiPath($akreditasi);
        $realPath = "$path/$documentPath/lk";

        return $realPath;
    }

    public static function getDetailLkUrl($akreditasi)
    {
        $path = Yii::getAlias('@web/upload');
        $documentPath = self::getK9InstitusiPath($akreditasi);
        $realPath = "$path/$documentPath/lk";

        return $realPath;
    }

    public static function getKuantitatifPath($akreditasi)
    {
        $path = Yii::getAlias('@uploadAkreditasi');
        $documentPath = self::getK9InstitusiPath($akreditasi);
        $realPath = "$path/$documentPath/matriks-kuantitatif";

        return $realPath;
    }

    public static function getKuantitatifUrl($akreditasi)
    {
        $path = Yii::getAlias('@web/upload');
        $documentPath = self::getK9InstitusiPath($akreditasi);
        $realPath = "$path/$documentPath/matriks-kuantitatif";

        return $realPath;
    }


    public static function getTemplateLkPath(){
        $path = Yii::getAlias('@required');
        $pathReplacement = [
            '{borang}'=>'kriteria9',
            '{jenis_dokumen}'=>'apt',
            '{template}'=>'template',
            '{untuk}'=>'lk'
        ];
        $templatePath = parent::getTemplateLk($pathReplacement);
        $realPath =  "$path/$templatePath";

        return $realPath;
    }
}