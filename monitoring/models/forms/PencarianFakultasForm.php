<?php
namespace monitoring\models\forms;

use common\models\FakultasAkademi;

class PencarianFakultasForm extends \akreditasi\models\PencarianFakultasForm
{

    public function cari(): ?array
    {
        $this->_fakultas = FakultasAkademi::findOne($this->id_fakultas);
        if(!$this->_fakultas) return null;
        return ['/eksekutif/eksekutif-fakultas/default/index','fakultas'=>$this->_fakultas->id];
    }
}
