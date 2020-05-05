<?php
/**
 * Project: kriteria.
 * @author Adryan Eka Vandra <adryanekavandra@gmail.com>
 *
 * Date: 10/22/2019
 * Time: 5:29 PM
 */

namespace akreditasi\models\kriteria9\lk\institusi;


use common\helpers\kriteria9\K9InstitusiJsonHelper;
use common\helpers\kriteria9\K9InstitusiProgressHelper;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria1;

class K9LkInstitusiNarasiKriteria1Form extends K9LkInstitusiKriteria1
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
        $json = K9InstitusiJsonHelper::getJsonKriteriaLk(1);
        $count = 0;

        $exclude = ['id', 'id_lk_institusi', 'progress', 'created_at', 'updated_at'];

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


        $progress1 = round(($count / $total) * 100, 2);

        $dokumen = K9InstitusiProgressHelper::getDokumenLkProgress($this->id_lk_institusi, $this->getK9LkInstitusiKriteria1Details(), 1);

        $progress2 = round(($dokumen), 2);
        $this->progress = $progress1 + $progress2;

        return true;
    }
}