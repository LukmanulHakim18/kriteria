<?php


namespace monitoring\modules\eksekutif\modules\institusi\controllers;

class LedInstitusiController extends \akreditasi\modules\kriteria9\modules\institusi\controllers\LedController
{
    protected $lihatLedView = '@monitoring/modules/eksekutif/modules/institusi/views/led-institusi/led';
    protected $lihatKriteriaView = '@monitoring/modules/eksekutif/modules/institusi/views/led-institusi/isi-kriteria';
    protected $lihatNonKriteriaView = '@monitoring/modules/eksekutif/modules/institusi/views/led-institusi/isi-non_kriteria';
}
