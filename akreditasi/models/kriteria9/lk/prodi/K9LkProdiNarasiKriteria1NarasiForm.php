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
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria1Narasi;

class K9LkProdiNarasiKriteria1NarasiForm extends K9LkProdiKriteria1Narasi
{

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->progress = $this->hitungNarasi();
        $this->lkProdi->akreditasiProdi->updateProgress();
        return parent::beforeSave($insert);
    }

    public function hitungNarasi(){
        $json = K9ProdiJsonHelper::getJsonKriteriaLk(1,$this->lkProdi->akreditasiProdi->prodi->jenjang);
        $count = 0;

        $exclude = ['id', 'id_lk_prodi', 'progress', 'created_at', 'updated_at'];

        $filters = array_filter($this->attributes, function ($attribute) use ($exclude) {
            return in_array($attribute, $exclude) === false;
        }, ARRAY_FILTER_USE_KEY);

        $total = sizeof($filters);
        $attributeKeys = array_keys($filters);

        foreach ($attributeKeys as $k => $attribute) {
            if($attribute === $json['butir'][$k]['template']){
                $template = $json['butir'][$k]['template'];
                $wordCountTemplate = strlen($template);

                $data = $this->$attribute;
                $wordCountData = strlen($data);

                if ($wordCountTemplate !== $wordCountData) {
                    ++$count;
                }
            }

        }

        return round(($count / $total) * 50, 2);
    }
}
