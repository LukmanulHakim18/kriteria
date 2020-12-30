<?php


namespace monitoring\modules\asesor\controllers;


use monitoring\modules\eksekutif\modules\prodi\controllers\LedController;

class LedProdiController extends LedController
{

    protected $lihatLedView = '@monitoring/modules/asesor/views/led-prodi/led';
    protected $lihatKriteriaView = '@monitoring/modules/asesor/views/led-prodi/isi-kriteria';
    protected $lihatNonKriteriaView = '@monitoring/modules/asesor/views/led-prodi/isi-non_kriteria';
}
