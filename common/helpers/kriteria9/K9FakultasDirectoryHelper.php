<?php
/**
 * mutu-v2
 * @author Adryan Eka Vandra <adryanekavandra@gmail.com>
 */
/**
 * Class K9FakultasDirectoryHelper
 * @package common\helpers\kriteria9
 */


namespace common\helpers\kriteria9;


use common\models\kriteria9\led\fakultas\K9LedFakultas;
use Yii;

class K9FakultasDirectoryHelper extends K9DirectoryHelper
{
    private static function getK9FakultasPath(K9LedFakultas $akreditasiFakultas)
    {
        $pathData = Yii::$app->params['uploadPath'];
        $pathReplacements = [
            '{lembaga}'=> $akreditasiFakultas->akreditasi->lembaga,
            '{jenis_akreditasi}'=>$akreditasiFakultas->akreditasi->jenis_akreditasi,
            '{tahun}'=> $akreditasiFakultas->akreditasi->tahun,
            '{level}'=>'fakultas',
            '{id}'=>$akreditasiFakultas->id_fakultas
        ];
        $result = strtr($pathData,$pathReplacements);
        $realPath = "$result";

        return $realPath;
    }

    public static function getDokumenLedPath($akreditasi)
    {

        $path = Yii::getAlias('@uploadAkreditasi');
        $documentPath = self::getK9FakultasPath($akreditasi);
        $realPath = "$path/$documentPath/led";

        return $realPath;
    }

    public static function getDokumenLedUrl($akreditasi)
    {
        $path = Yii::getAlias('@web/upload');
        $documentPath = self::getK9FakultasPath($akreditasi);
        $realPath = "$path/$documentPath/led";

        return $realPath;
    }

    public static function getDetailLedPath($akreditasi)
    {
        $path = Yii::getAlias('@uploadAkreditasi');
        $documentPath = self::getK9FakultasPath($akreditasi);
        $realPath = "$path/$documentPath/led";

        return $realPath;
    }

    public static function getDetailLedUrl($akreditasi)
    {
        $path = Yii::getAlias('@web/upload');
        $documentPath = self::getK9FakultasPath($akreditasi);
        $realPath = "$path/$documentPath/led";

        return $realPath;
    }

    public static function getDokumenLkPath($akreditasi)
    {
        $path = Yii::getAlias('@uploadAkreditasi');
        $documentPath = self::getK9FakultasPath($akreditasi);
        $realPath = "$path/$documentPath/lk";

        return $realPath;
    }

    public static function getDokumenLkUrl($akreditasi)
    {
        $path = Yii::getAlias('@web/upload');
        $documentPath = self::getK9FakultasPath($akreditasi);
        $realPath = "$path/$documentPath/lk";

        return $realPath;
    }

    public static function getDetailLkPath($akreditasi)
    {
        $path = Yii::getAlias('@uploadAkreditasi');
        $documentPath = self::getK9FakultasPath($akreditasi);
        $realPath = "$path/$documentPath/lk";

        return $realPath;
    }

    public static function getDetailLkUrl($akreditasi)
    {
        $path = Yii::getAlias('@web/upload');
        $documentPath = self::getK9FakultasPath($akreditasi);
        $realPath = "$path/$documentPath/lk";

        return $realPath;
    }

    public static function getKuantitatifPath($akreditasi)
    {
        $path = Yii::getAlias('@uploadAkreditasi');
        $documentPath = self::getK9FakultasPath($akreditasi);
        $realPath = "$path/$documentPath/matriks-kuantitatif";

        return $realPath;
    }

    public static function getKuantitatifUrl($akreditasi)
    {
        $path = Yii::getAlias('@web/upload');
        $documentPath = self::getK9FakultasPath($akreditasi);
        $realPath = "$path/$documentPath/matriks-kuantitatif";

        return $realPath;
    }


    public static function getTemplateLkPath(){
        $path = Yii::getAlias('@required');
        $pathReplacement = [
            '{jenis_akreditasi}'=>'aps',

        ];
        $templatePath = parent::getTemplateLk($pathReplacement);
        $realPath =  "$path/$templatePath";

        return $realPath;
    }
}