<?php


namespace common\models\sertifikat;


use common\models\sertifikat\SertifikatInstitusi;
use yii\base\Model;

class SertifikatInstitusiForm extends Model
{


    public $sertifikat_untuk;

    private $_akreditasi;
    private $_akreditasi_Institusi;
    private $_sertifikat;


    public function rules() :array
    {
        return [
            [['sertifikat_untuk',],'required']
        ];
    }

    public function cari(): string
    {

        $url ='';

        $untuk = strtolower($this->sertifikat_untuk);

        if($untuk === 'institusi'){
            $this->_sertifikat = SertifikatInstitusi::find();
            $url .= "sertifikat-institusi";
        }

        return $url;

    }


    /**
     * @return mixed
     */
    public function getSertifikat()
    {
        return $this->_sertifikat;
    }


}