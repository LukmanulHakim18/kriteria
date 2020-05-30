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
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria5;

class K9LkProdiNarasiKriteria5Form extends K9LkProdiKriteria5
{

    public function beforeSave($insert)
    {
        $this->updateProgress();
        $this->lkProdi->updateProgress();
        $this->lkProdi->akreditasiProdi->updateProgress();
        return parent::beforeSave($insert);
    }

    public function updateProgress()
    {
        $json = K9ProdiJsonHelper::getJsonKriteriaLk(5,$this->lkProdi->akreditasiProdi->prodi->jenjang);
        $count = 0;

        $exclude = ['id', 'id_lk_prodi', 'progress', 'created_at', 'updated_at'];

        $filters = array_filter($this->attributes, function ($attribute) use ($exclude) {
            return in_array($attribute, $exclude) === false;
        }, ARRAY_FILTER_USE_KEY);

        $total = sizeof($filters);
        $attributeKeys = array_keys($filters);

        foreach ($attributeKeys as $k => $attribute) {
            $template = $json['butir'][$k]['template'];
            $hashTemplate = sha1($template);

            $data = $this->$attribute;
            $hashData = sha1($data);

            if ($hashTemplate !== $hashData) {
                $count += 1;
            }
        }


        $progress1 = round(($count / $total) * 50, 2);

        $dokumen = K9ProdiProgressHelper::getDokumenLkProgress($this->id_lk_prodi, $this->getK9LkProdiKriteria5Details(), 5);

        $progress2 = round(($dokumen), 2);
        $this->progress = $progress1 + $progress2;

        return true;
    }
}
