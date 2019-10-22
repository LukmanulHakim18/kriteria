<?php
/**
 * mutu-v2
 * @author Adryan Eka Vandra <adryanekavandra@gmail.com>
 */
/**
 * Class K9LedInstitusiNarasiKriteria1Form
 * @package akreditasi\models\kriteria9\led\institusi
 */


namespace akreditasi\models\kriteria9\led\institusi;


use common\models\kriteria9\led\institusi\K9LedInstitusiNarasiKriteria8;

class K9LedInstitusiNarasiKriteria8Form extends K9LedInstitusiNarasiKriteria8
{

    public function beforeSave($insert)
    {
        $this->updateProgress();
        $this->ledInstitusiKriteria8->updateProgress();
        $this->ledInstitusiKriteria8->ledInstitusi->updateProgress();
        $this->ledInstitusiKriteria8->ledInstitusi->akreditasiInstitusi->updateProgress();
        return parent::beforeSave($insert);
    }

    public function updateProgress(){
        $count = 0;

        $exclude = ['id','id_led_institusi_kriteria8','progress','created_at','updated_at','created_by','updated_by'];

        $filters = array_filter($this->attributes, function ($attribute) use ($exclude){
            return in_array($attribute,$exclude) === false;
        },ARRAY_FILTER_USE_KEY);

        $total = sizeof($filters);

        foreach ($filters as $attribute){
            if($attribute !== null){
                $count +=1;
            }
        }

        $progress = round(($count/$total) * 100,2);

        $this->progress = $progress;

        return true;
    }
}