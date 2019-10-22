<?php
/**
 * Project: kriteria.
 * @author Adryan Eka Vandra <adryanekavandra@gmail.com>
 *
 * Date: 10/22/2019
 * Time: 5:29 PM
 */

namespace akreditasi\models\kriteria9\lk\prodi;


use common\models\kriteria9\lk\prodi\K9LkProdiKriteria3;

class K9LkProdiNarasiKriteria3Form extends K9LkProdiKriteria3
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
        $count = 0;

        $exclude = ['id', 'id_lk_prodi', 'progress', 'created_at', 'updated_at'];

        $filters = array_filter($this->attributes, function ($attribute) use ($exclude) {
            return in_array($attribute, $exclude) === false;
        }, ARRAY_FILTER_USE_KEY);

        $total = sizeof($filters);

        foreach ($filters as $attribute) {
            if ($attribute !== null) {
                $count += 1;
            }
        }

        $progress = round(($count / $total) * 100, 2);

        $this->progress = $progress;

        return true;
    }
}