<?php

namespace monitoring\models\forms;

use common\models\ProgramStudi;

class PencarianProdiForm extends \akreditasi\models\PencarianProdiForm
{

    public function cariK9(): ?array
    {
        $this->_prodi = ProgramStudi::findOne($this->id_prodi);
        if (!$this->_prodi) {
            return null;
        }

        return ['eksekutif-prodi/default', 'prodi' => $this->_prodi->id];
    }
}
