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


use common\models\kriteria9\led\institusi\K9LedInstitusiNarasiKriteria6;

class K9LedInstitusiNarasiKriteria6Form extends K9LedInstitusiNarasiKriteria6
{

    public function beforeSave($insert)
    {
        $this->updateProgress();
        $this->ledInstitusiKriteria6->updateProgress();
        $this->ledInstitusiKriteria6->ledInstitusi->updateProgress();
        $this->ledInstitusiKriteria6->ledInstitusi->akreditasiInstitusi->updateProgress();
        return parent::beforeSave($insert);
    }

    public function updateProgress(){
        $count = 0;

        $exclude = ['id','id_led_institusi_kriteria6','progress','created_at','updated_at','created_by','updated_by'];

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