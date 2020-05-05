<?php
/**
 * mutu-v2
 * @author Adryan Eka Vandra <adryanekavandra@gmail.com>
 */
/**
 * Class K9ProdiDirectoryHelper
 * @package common\helpers\kriteria9
 */


namespace common\helpers\kriteria9;


use common\models\kriteria9\akreditasi\K9AkreditasiProdi;
use common\models\kriteria9\led\prodi\K9LedProdi;
use Yii;

class K9ProdiDirectoryHelper extends K9DirectoryHelper
{
    private static function getK9ProdiPath(K9AkreditasiProdi $akreditasiProdi)
    {
        $pathData = Yii::$app->params['uploadPath'];
        $pathReplacements = [
            '{lembaga}'=> $akreditasiProdi->akreditasi->lembaga,
            '{jenis_akreditasi}'=>$akreditasiProdi->akreditasi->jenis_akreditasi,
            '{tahun}'=> $akreditasiProdi->akreditasi->tahun,
            '{level}'=>'prodi',
            '{id}'=>$akreditasiProdi->id_prodi
        ];
        $result = strtr($pathData,$pathReplacements);
        $realPath = "$result";

        return $realPath;
    }

    public static function getDokumenLedPath($akreditasi)
    {

        $path = Yii::getAlias('@uploadAkreditasi');
        $documentPath = self::getK9ProdiPath($akreditasi);
        $realPath = "$path/$documentPath/led";

        return $realPath;
    }

    public static function getDokumenLedUrl($akreditasi)
    {
        $path = Yii::getAlias('@web/upload');
        $documentPath = self::getK9ProdiPath($akreditasi);
        $realPath = "$path/$documentPath/led";

        return $realPath;
    }

    public static function getDetailLedPath($akreditasi)
    {
        $path = Yii::getAlias('@uploadAkreditasi');
        $documentPath = self::getK9ProdiPath($akreditasi);
        $realPath = "$path/$documentPath/led";

        return $realPath;
    }

    public static function getDetailLedUrl($akreditasi)
    {
        $path = Yii::getAlias('@web/upload');
        $documentPath = self::getK9ProdiPath($akreditasi);
        $realPath = "$path/$documentPath/led";

        return $realPath;
    }

    public static function getDokumenLkPath($akreditasi)
    {
        $path = Yii::getAlias('@uploadAkreditasi');
        $documentPath = self::getK9ProdiPath($akreditasi);
        $realPath = "$path/$documentPath/lk";

        return $realPath;
    }

    public static function getDokumenLkUrl($akreditasi)
    {
        $path = Yii::getAlias('@web/upload');
        $documentPath = self::getK9ProdiPath($akreditasi);
        $realPath = "$path/$documentPath/lk";

        return $realPath;
    }

    public static function getDetailLkPath($akreditasi)
    {
        $path = Yii::getAlias('@uploadAkreditasi');
        $documentPath = self::getK9ProdiPath($akreditasi);
        $realPath = "$path/$documentPath/lk";

        return $realPath;
    }

    public static function getDetailLkUrl($akreditasi)
    {
        $path = Yii::getAlias('@web/upload');
        $documentPath = self::getK9ProdiPath($akreditasi);
        $realPath = "$path/$documentPath/lk";

        return $realPath;
    }

    public static function getKuantitatifPath($akreditasi)
    {
        $path = Yii::getAlias('@uploadAkreditasi');
        $documentPath = self::getK9ProdiPath($akreditasi);
        $realPath = "$path/$documentPath/matriks-kuantitatif";

        return $realPath;
    }

    public static function getKuantitatifUrl($akreditasi)
    {
        $path = Yii::getAlias('@web/upload');
        $documentPath = self::getK9ProdiPath($akreditasi);
        $realPath = "$path/$documentPath/matriks-kuantitatif";

        return $realPath;
    }


    public static function getTemplateLkPath(){
        $path = Yii::getAlias('@required');
        $pathReplacement = [
            '{borang}'=>'kriteria9',
            '{jenis_dokumen}'=>'aps',
            '{template}'=>'template',
            '{untuk}'=>'lk'

        ];
        $templatePath = parent::getTemplateLk($pathReplacement);
        $realPath =  "$path/$templatePath";

        return $realPath;
    }
}