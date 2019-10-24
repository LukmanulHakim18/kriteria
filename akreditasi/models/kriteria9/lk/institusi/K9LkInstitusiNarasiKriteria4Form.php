<?php
/**
 * Project: kriteria.
 * @author Adryan Eka Vandra <adryanekavandra@gmail.com>
 *
 * Date: 10/22/2019
 * Time: 5:29 PM
 */

namespace akreditasi\models\kriteria9\lk\prodi;


use common\helpers\kriteria9\K9InstitusiProgressHelper;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria4;

class K9LkInstitusiNarasiKriteria4Form extends K9LkInstitusiKriteria4
{

    public function beforeSave($insert)
    {
        $this->updateProgress();
        $this->lkInstitusi->updateProgress();
        $this->lkInstitusi->akreditasiInstitusi->updateProgress();
        return parent::beforeSave($insert);
    }

    public function updateProgress()
    {
        $count = 0;

        $exclude = ['id', 'id_lk_institusi', 'progress', 'created_at', 'updated_at'];

        $filters = array_filter($this->attributes, function ($attribute) use ($exclude) {
            return in_array($attribute, $exclude) === false;
        }, ARRAY_FILTER_USE_KEY);

        $total = sizeof($filters);

        foreach ($filters as $attribute) {
            if ($attribute !== null) {
                $count += 1;
            }
        }

        $progress1 = round(($count / $total) * 100, 2);

        $dokumen = K9InstitusiProgressHelper::getDokumenLkProgress($this->id_lk_institusi, $this->getK9LkInstitusiKriteria4Details(), 4);

        $progress2 = round(($dokumen) / 1, 2);
        $this->progress = $progress1 + $progress2;

        return true;
    }
}