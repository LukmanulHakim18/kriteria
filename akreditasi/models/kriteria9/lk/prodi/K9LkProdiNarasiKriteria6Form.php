<?php
/**
 * Project: kriteria.
 * @author Adryan Eka Vandra <adryanekavandra@gmail.com>
 *
 * Date: 10/22/2019
 * Time: 5:29 PM
 */

namespace akreditasi\models\kriteria9\lk\prodi;


use common\helpers\kriteria9\K9ProdiJsonHelper;
use common\helpers\kriteria9\K9ProdiProgressHelper;
use common\helpers\NomorKriteriaHelper;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria6Narasi;
use yii2mod\helpers\ArrayHelper;

class K9LkProdiNarasiKriteria6Form extends K9LkProdiKriteria6Narasi
{

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->progress = $this->hitungNarasi();

        return parent::beforeSave($insert);
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        $this->lkProdiKriteria6->updateProgressNarasi()->save(false);
        $this->lkProdiKriteria6->lkProdi->updateProgress()->save(false);
        $this->lkProdiKriteria6->lkProdi->akreditasiProdi->updateProgress()->save(false);
        parent::afterSave($insert, $changedAttributes);
    }

    public function hitungNarasi(){
        $json = K9ProdiJsonHelper::getJsonKriteriaLk(6,$this->lkProdiKriteria6->lkProdi->akreditasiProdi->prodi->jenjang);
        $count = 0;

        $exclude = ['id', 'id_lk_prodi_kriteria6', 'progress', 'created_at', 'updated_at'];

        $filters = array_filter($this->attributes, function ($attribute) use ($exclude) {
            return in_array($attribute, $exclude, true) === false;
        }, ARRAY_FILTER_USE_KEY);

        $total = sizeof($filters);
        $attributeKeys = array_map(function($element){
            return NomorKriteriaHelper::changeToJsonFormat($element);
        },array_keys($filters));


        $indexJson = ArrayHelper::index($json['butir'],'tabel');
        $keysJson =  array_keys($indexJson);

        $arrayIntersect = array_values(array_intersect($attributeKeys,$keysJson));
        foreach ($arrayIntersect as $k => $attribute) {
            $nomor = NomorKriteriaHelper::changeToDbFormat($attribute);
            if($attribute === $json['butir'][$k]['tabel']){
                $template = $json['butir'][$k]['template'];
                $wordCountTemplate = strlen($template);

                $data = $this->$nomor;
                $wordCountData = strlen($data);

                if ($wordCountTemplate !== $wordCountData) {
                    ++$count;
                }
            }

        }

        return round(($count / $total) * 100, 2);
    }
}
