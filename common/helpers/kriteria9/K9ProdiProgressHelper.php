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
        $filename = 'led_prodi.json';
        $filejson = file_get_contents(Yii::getAlias('@required/kriteria9/aps/'.$filename));

        $json = Json::decode($filejson);

        $dataJson = $json[$kriteria-1];
        $totalDokumenJson = 0;
        foreach ($dataJson['butir'] as $butir){

            $missing = 0;
            foreach ($butir['dokumen_sumber'] as $doksum){
                if(empty($doksum['kode'])) {
                    $missing +=1;
                }
            }

            foreach ($butir['dokumen_pendukung'] as $dokpen){
                if(empty($dokpen['kode'])) {
                    $missing +=1;
                }
            }


            $dataSumber = sizeof($butir['dokumen_sumber']);
            $dataPendukung = sizeof($butir['dokumen_pendukung']);
            $data = $dataSumber+$dataPendukung - $missing;
            $totalDokumenJson+=$data;
        }

        $dokumenKriteria = $detail->select('kode_dokumen')->distinct()->andWhere(['jenis_dokumen'=>Constants::SUMBER])->orWhere(['jenis_dokumen'=>Constants::PENDUKUNG])->all();
        $totalDokumenKriteria = sizeof($dokumenKriteria);

        $progress = round((($totalDokumenKriteria / $totalDokumenJson) *100),2);



        return $progress;

    }

    public static function getDokumenLkProgress($lk, $dokumen, $kriteria)
    {
        $progress = 0;
        $filename = 'lkps_prodi_s1.json';
        $filejson = file_get_contents(Yii::getAlias('@required/kriteria9/aps/'.$filename));

        $json = Json::decode($filejson);

        $dataJson = $json[$kriteria-1];
        $totalDokumenJson = 0;
        foreach ($dataJson['butir'] as $butir){

            $missing = 0;
            foreach ($butir['dokumen_sumber'] as $doksum){
                if(empty($doksum['kode'])) {
                    $missing +=1;
                }
            }

            foreach ($butir['dokumen_pendukung'] as $dokpen){
                if(empty($dokpen['kode'])) {
                    $missing +=1;
                }
            }


            $dataSumber = sizeof($butir['dokumen_sumber']);
            $dataPendukung = sizeof($butir['dokumen_pendukung']);
            $dataTemplate = 1;
            if (empty($butir['template'])){
                $dataTemplate = 0;
            }
            $data = $dataTemplate+$dataSumber+$dataPendukung - $missing;
            $totalDokumenJson+=$data;
        }

        $dokumenKriteria = $dokumen->select('kode_dokumen')->distinct()->andWhere(['jenis_dokumen'=>Constants::SUMBER])->orWhere(['jenis_dokumen'=>Constants::PENDUKUNG])->orWhere(['jenis_dokumen'=>Constants::TEMPLATE])->all();
        $totalDokumenKriteria = sizeof($dokumenKriteria);

        $progress = round((($totalDokumenKriteria / $totalDokumenJson) *100),2);

        return $progress;

    }
}