<?php
/**
 * mutu-v2
 * @author Adryan Eka Vandra <adryanekavandra@gmail.com>
 */
/**
 * Class K9LedProdiNarasiKriteria1Form
 * @package akreditasi\models\kriteria9\led\prodi
 */


namespace akreditasi\models\kriteria9\led\prodi;


use common\models\kriteria9\led\prodi\K9LedProdiNarasiKriteria9;

class K9LedProdiNarasiKriteria9Form extends K9LedProdiNarasiKriteria9
{

    public function beforeSave($insert)
    {
        $this->updateProgress();

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->ledProdiKriteria9->updateProgress();
        $this->ledProdiKriteria9->ledProdi->updateProgress();
        $this->ledProdiKriteria9->ledProdi->akreditasiProdi->updateProgress()->save(false);
        parent::afterSave($insert, $changedAttributes);
    }

    public function updateProgress(){
        $count = 0;

        $exclude = ['id','id_led_prodi_kriteria9','progress','created_at','updated_at','created_by','updated_by'];

        $filters = array_filter($this->attributes, function ($attribute) use ($exclude){
            return in_array($attribute,$exclude) === false;
        },ARRAY_FILTER_USE_KEY);

        $total = sizeof($filters);

        foreach ($filters as $attribute){
            if(!empty($attribute)){
                ++$count;
            }
        }

        $progress = round(($count/$total) * 100,2);

        $this->progress = $progress;

        return true;
    }
}
