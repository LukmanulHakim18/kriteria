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


use common\models\kriteria9\led\institusi\K9LedInstitusiNarasiKriteria1;

class K9LedInstitusiNarasiKriteria1Form extends K9LedInstitusiNarasiKriteria1
{

    public function beforeSave($insert)
    {
        $this->updateProgress();
        $this->ledInstitusiKriteria1->updateProgress();
        $this->ledInstitusiKriteria1->ledInstitusi->updateProgress();
        $this->ledInstitusiKriteria1->ledInstitusi->akreditasiInstitusi->updateProgress();
        return parent::beforeSave($insert);
    }

    public function updateProgress(){
        $count = 0;

        $exclude = ['id','id_led_institusi_kriteria1','progress','created_at','updated_at','created_by','updated_by'];

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