<?php


namespace monitoring\modules\asesor\controllers;


class LedInstitusiController extends \monitoring\modules\eksekutif\modules\institusi\controllers\LedInstitusiController
{
    protected $lihatLedView = '@monitoring/modules/asesor/views/led-institusi/led';
    protected $lihatKriteriaView = '@monitoring/modules/asesor/views/led-institusi/isi-kriteria';
    protected $lihatNonKriteriaView = '@monitoring/modules/asesor/views/led-institusi/isi-non_kriteria';

}
