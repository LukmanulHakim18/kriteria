<?php
/**
 * Project: mutu-v2.
 * @author Adryan Eka Vandra <adryanekavandra@gmail.com>
 *
 * Date: 8/26/2019
 * Time: 10:41 AM
 */

namespace common\models\kriteria9\forms\led;

use common\models\kriteria9\akreditasi\K9Akreditasi;
use common\models\kriteria9\akreditasi\K9AkreditasiInstitusi;
use common\models\kriteria9\led\institusi\K9LedInstitusi;
use yii\base\Model;

class K9PencarianLedInstitusiForm extends Model
{

    public $akreditasi;

    private $_akreditasi;
    private $_akreditasiInstitusi;
    private $_led;

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

        $this->_led = K9LedInstitusi::findOne(['id_akreditasi_institusi'=>$this->_akreditasiInstitusi->id]);
        $url = ["led/$target",'led'=>$this->_led->id];

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
    public function getLed()
    {
        return $this->_led;
    }

}