<?php


namespace common\helpers\kriteria9;


use common\models\kriteria9\kuantitatif\prodi\K9DataKuantitatifProdi;
use common\models\kriteria9\lk\prodi\K9LkProdi;
use common\models\ProgramStudi;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpWord\IOFactory;
use yii\base\BaseObject;
use yii\helpers\Inflector;

class KuantitatifProdiExport extends BaseObject
{
    /** @var K9LkProdi */
    private $lk;

    /** @var Spreadsheet */
    private $spreadsheet;
    private $template;

    private $reader;
    private $writer;

    public function __construct($lk, $config = [])
    {
        $this->lk = $lk;
        $this->template = '@required/kriteria9/aps/template/penilaian.xslx';
        $this->spreadsheet = IOFactory::load($this->template);
        $this->reader = IOFactory::createReader('Html');
        $this->writer = IOFactory::createWriter($this->spreadsheet, 'Xlsx');
        $this->export();
        parent::__construct($config);
    }


    /**
     * @param $queue
     */
    private function export()
    {
        $akreditasiProdi = $this->lk->akreditasiProdi;
        $prodi = $akreditasiProdi->prodi;

        switch ($prodi->jenjang) {
            case ProgramStudi::JENJANG_DIPLOMA:

                $this->exportDiploma();
                break;
            case ProgramStudi::JENJANG_SARJANA:
                $this->exportSarjana();
                break;

            case ProgramStudi::JENJANG_SARJANA_TERAPAN:
                $this->exportSarjanaTerapan();
                break;

            case ProgramStudi::JENJANG_MAGISTER:
                $this->exportMagister();
                break;
            case ProgramStudi::JENJANG_MAGISTER_TERAPAN:
                $this->exportMagisterTerapan();
                break;
            case ProgramStudi::JENJANG_DOKTOR:
                $this->exportDoktor();
                break;
            case ProgramStudi::JENJANG_DOKTOR_TERAPAN:
                $this->exportDoktorTerapan();
                break;
        }

        $kuantitatif = K9DataKuantitatifProdi::findOne(['id_akreditasi_prodi' => $$akreditasiProdi->id]);
        if (!$kuantitatif) {
            $kuantitatif = new K9DataKuantitatifProdi();
            $kuantitatif->id_akreditasi_prodi = $akreditasiProdi->id;
            $kuantitatif->nama_dokumen = 'Matriks Kuantitatif - ' . $prodi->nama;
            $kuantitatif->isi_dokumen = 'matriks-kuantitatif-' . Inflector::slug($prodi->nama) . '.xslx';
        }
    }

    private function exportDiploma()
    {

    }

    private function exportSarjana()
    {
        $result = $this->tabel1();
    }

    private function tabel1()
    {

        return;
    }

    private function exportSarjanaTerapan()
    {
    }

    private function exportMagister()
    {
    }

    private function exportMagisterTerapan()
    {
    }

    private function exportDoktor()
    {
    }

    private function exportDoktorTerapan()
    {
    }

    private function tabel2a()
    {
    }

    private function tabel2b()
    {
    }

    private function tabel3a1()
    {
    }

    private function tabel3a2()
    {
    }

    private function tabel3a3()
    {
    }

    private function tabel3a4()
    {
    }

    private function tabel3b1()
    {
    }

    private function tabel3b2()
    {
    }

    private function tabel3b3()
    {
    }

    private function tabel3b4()
    {
    }

    private function tabel3b5()
    {
    }

    private function tabel3b6()
    {
    }

    private function tabel3b7()
    {
    }

    private function tabel4()
    {
    }

    private function tabel5a()
    {
    }

    private function tabel5b()
    {
    }

    private function tabel5c()
    {
    }

    private function tabel6a()
    {
    }

    private function tabel7()
    {
    }

    private function tabel8a()
    {
    }

    private function tabel8b1()
    {
    }

    private function tabel8b2()
    {
    }

    private function tabel8c()
    {
    }

    private function tabel8d1()
    {
    }

    private function tabel8d2()
    {
    }

    private function tabel8e1()
    {
    }

    private function tabel8e2()
    {
    }

    private function tabel8f1()
    {
    }

    private function tabel8f2()
    {
    }

    private function tabel8f3()
    {
    }

    private function tabel8f4()
    {
    }

}
