<?php
namespace common\models\kriteria9\forms\kuantitatif;

use common\models\kriteria9\akreditasi\K9Akreditasi;
use yii\base\Model;

class K9PencarianKuantitatifForm extends Model
{
    public $akreditasi;
    public $id_prodi;

    private $_akreditasi;
    private $_akreditasi_prodi;
    private $_kuantitatif;

    public function rules(): array {
        return [
            [['akreditasi','id_prodi'],'required']
        ];
    }

    public function cari($target): string {
        $url = '';

        $akreditasiProdiClass = 'common\\models\\kriteria9\\akreditasi\\K9AkreditasiProdi';
        $kuantitatifProdiClass = 'common\\models\\kriteria9\\kuantitatif\\prodi\\K9DataKuantitatifProdi';

        $this->_akreditasi = K9Akreditasi::find()->where(['id'=>$this->akreditasi])->one();

//        $this->_akreditasi_prodi = call_user_func($akreditasiProdiClass.'::findOne',['id_prodi'=>$this->id_prodi,'id_akreditasi'=>$this->akreditasi]);
//
//        if(!$this->_akreditasi_prodi){
//            return false;
//        }
//        $this->_kuantitatif = call_user_func($kuantitatifProdiClass.'::findOne',['id_akreditasi_prodi' =>$this->_akreditasi_prodi->id]);
        $url .= 'kuantitatif/'.$target;

        return $url;
    }

    /**
     * @return mixed
     */
    public function getKuantitatif()
    {
        return $this->_kuantitatif;
    }
}