<?php


namespace monitoring\modules\asesor\controllers;


use monitoring\modules\eksekutif\modules\prodi\controllers\LkController;

class LkProdiController extends LkController
{

    protected $lkView = '@monitoring/modules/asesor/views/lk-prodi/isi';
    protected $lihatLkKriteria = '@monitoring/modules/asesor/views/lk-prodi/isi-kriteria';
    protected $itemLkView = '@monitoring/modules/asesor/views/lk-prodi/_item_lk';
}
