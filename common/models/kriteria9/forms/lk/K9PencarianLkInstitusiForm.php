<?php

namespace common\models\kriteria9\forms\lk;

use common\models\kriteria9\akreditasi\K9Akreditasi;
use common\models\kriteria9\akreditasi\K9AkreditasiInstitusi;
use common\models\kriteria9\lk\institusi\K9LkInstitusi;
use yii\base\Model;

class K9PencarianLkInstitusiForm extends Model
{
    public $akreditasi;

    private $_akreditasi;
    private $_akreditasiInstitusi;
    private $_lk;

    public function rules()
    {
        return[
            ['akreditasi','required'],
            ['akreditasi','integer']
        ];
    }

    public function cari($target){
        $this->_akreditasi = K9Akreditasi::findOne($this->akreditasi);
        $this->_akreditasiInstitusi = K9AkreditasiInstitusi::findOne(['id_akreditasi'=> $this->_akreditasi->id]);
        if(!$this->_akreditasiInstitusi){
            return null;
        }

        $this->_lk = K9LkInstitusi::findOne(['id_akreditasi_institusi'=>$this->_akreditasiInstitusi->id]);
        $url = ["lk/$target",'lk'=>$this->_lk->id];

        return $url;
    }

    /**
     * @return mixed
     */
    public function getAkreditasi()
    {
        return $this->_akreditasi;
    }

    /**
     * @return mixed
     */
    public function getAkreditasiInstitusi()
    {
        return $this->_akreditasiInstitusi;
    }

    /**
     * @return mixed
     */
    public function getLk()
    {
        return $this->_lk;
    }

}