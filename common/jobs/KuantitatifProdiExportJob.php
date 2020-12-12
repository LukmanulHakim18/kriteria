<?php


namespace common\jobs;


use Carbon\Carbon;
use common\helpers\kriteria9\K9ProdiDirectoryHelper;
use common\models\kriteria9\kuantitatif\prodi\K9DataKuantitatifProdi;
use common\models\kriteria9\lk\prodi\K9LkProdi;
use common\models\ProgramStudi;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\DomCrawler\Crawler;
use yii\base\BaseObject;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use yii\queue\JobInterface;

class KuantitatifProdiExportJob extends BaseObject implements JobInterface
{


    /** @var K9LkProdi */
    public $lk;
    public $template;

    /**
     * @var Spreadsheet
     */
    private $spreadsheet;

    public function execute($queue)
    {

        $reader = IOFactory::createReader('Xlsx');
        $this->spreadsheet = $reader->load($this->template);
        $this->export($queue);

    }

    private function export($queue)
    {
        $akreditasiProdi = $this->lk->akreditasiProdi;
        $prodi = $akreditasiProdi->prodi;

        switch ($prodi->jenjang) {
            case ProgramStudi::JENJANG_DIPLOMA:
                break;
            case ProgramStudi::JENJANG_SARJANA:
                $this->tabel1($prodi->jenjang);
                $this->tabel2a($prodi->jenjang);
                break;
            case ProgramStudi::JENJANG_SARJANA_TERAPAN:
                break;
            case ProgramStudi::JENJANG_MAGISTER:
                break;
            case ProgramStudi::JENJANG_MAGISTER_TERAPAN:
                break;
            case ProgramStudi::JENJANG_DOKTOR:
                break;
            case ProgramStudi::JENJANG_DOKTOR_TERAPAN:
                break;
        }

        $writer = IOFactory::createWriter($this->spreadsheet, 'Xlsx');

        $timestamp = Carbon::now()->timestamp;
        $filename = "$timestamp-matriks-kuantitatif-" . Inflector::slug($prodi->nama) . '.xlsx';


        $path = K9ProdiDirectoryHelper::getKuantitatifPath($akreditasiProdi);
        $writer->save("$path/$filename");

        $model = K9DataKuantitatifProdi::findOne(['id_akreditasi_prodi' => $akreditasiProdi->id]);
        $oldName = $model->isi_dokumen;
        if (!$model) {
            $model = new K9DataKuantitatifProdi();
            $model->id_akreditasi_prodi = $akreditasiProdi->id;
        }
        $model->nama_dokumen = 'Matriks Kuantitatif ' . $prodi->nama . '(' . $akreditasiProdi->akreditasi->tahun . ')';
        $model->isi_dokumen = $filename;
        $model->save(false);

        FileHelper::unlink("$path/$oldName");

    }

    private function tabel1($jenjang)
    {
        //get Kriteria 1 LK
        $tabel = $this->lk->k9LkProdiKriteria1s->k9LkProdiKriteria1Narasi;

        //1-1
        $crawler = new Crawler($tabel->_1__1);
        $data = $crawler->filter('tbody')->filter('tr')->each(function ($tr, $i) {
            return $tr->filter('td')->each(function ($td, $i) {
                return trim($td->text());
            });
        });
        array_pop($data);

        $contentStartRow = 12;
        $currentContentRow = 12;
        $currentWorksheet = 3;

        foreach ($data as $item) {
            $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentContentRow + 1, 1);
            $this->spreadsheet->getSheet($currentWorksheet)
                ->setCellValue('A' . $currentContentRow, $item[0])
                ->setCellValue('B' . $currentContentRow, $item[1])
                ->setCellValue('C' . $currentContentRow, $item[2])
                ->setCellValue('D' . $currentContentRow, $item[3])
                ->setCellValue('E' . $currentContentRow, $item[4])
                ->setCellValue('F' . $currentContentRow, $item[5])
                ->setCellValue('G' . $currentContentRow, $item[6])
                ->setCellValue('H' . $currentContentRow, $item[7])
                ->setCellValue('I' . $currentContentRow, $item[8])
                ->setCellValue('J' . $currentContentRow, $item[9]);

            $currentContentRow++;

        }

        $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentContentRow, 1);

        //1-2
        $crawler = new Crawler($tabel->_1__2);
        $data = $crawler->filter('tbody')->filter('tr')->each(function ($tr, $i) {
            return $tr->filter('td')->each(function ($td, $i) {
                return trim($td->text());
            });
        });
        array_pop($data);

        $contentStartRow = 12;
        $currentContentRow = 12;
        $currentWorksheet = 4;

        foreach ($data as $item) {
            $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentContentRow + 1, 1);
            $this->spreadsheet->getSheet($currentWorksheet)
                ->setCellValue('A' . $currentContentRow, $item[0])
                ->setCellValue('B' . $currentContentRow, $item[1])
                ->setCellValue('C' . $currentContentRow, $item[2])
                ->setCellValue('D' . $currentContentRow, $item[3])
                ->setCellValue('E' . $currentContentRow, $item[4])
                ->setCellValue('F' . $currentContentRow, $item[5])
                ->setCellValue('G' . $currentContentRow, $item[6])
                ->setCellValue('H' . $currentContentRow, $item[7])
                ->setCellValue('I' . $currentContentRow, $item[8])
                ->setCellValue('J' . $currentContentRow, $item[9]);

            $currentContentRow++;

        }

        $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentContentRow, 1);

        //1-3
        $crawler = new Crawler($tabel->_1__3);
        $data = $crawler->filter('tbody')->filter('tr')->each(function ($tr, $i) {
            return $tr->filter('td')->each(function ($td, $i) {
                return trim($td->text());
            });
        });
        array_pop($data);

        $contentStartRow = 12;
        $currentContentRow = 12;
        $currentWorksheet = 5;

        foreach ($data as $item) {
            $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentContentRow + 1, 1);
            $this->spreadsheet->getSheet($currentWorksheet)
                ->setCellValue('A' . $currentContentRow, $item[0])
                ->setCellValue('B' . $currentContentRow, $item[1])
                ->setCellValue('C' . $currentContentRow, $item[2])
                ->setCellValue('D' . $currentContentRow, $item[3])
                ->setCellValue('E' . $currentContentRow, $item[4])
                ->setCellValue('F' . $currentContentRow, $item[5])
                ->setCellValue('G' . $currentContentRow, $item[6])
                ->setCellValue('H' . $currentContentRow, $item[7])
                ->setCellValue('I' . $currentContentRow, $item[8])
                ->setCellValue('J' . $currentContentRow, $item[9]);

            $currentContentRow++;

        }

        $this->spreadsheet->getSheet(3)->removeRow($currentContentRow, 1);
    }

    private function tabel2a(string $jenjang)
    {
    }

}
