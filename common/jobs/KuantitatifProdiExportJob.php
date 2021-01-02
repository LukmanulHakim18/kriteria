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
use yii\base\Exception;
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

    /**
     * @param \yii\queue\Queue $queue
     * @return mixed|void
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function execute($queue)
    {

        $reader = IOFactory::createReader('Xlsx');
        $this->spreadsheet = $reader->load($this->template);
        $this->export($queue);
    }

    /**
     * @param $queue
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    private function export($queue)
    {
        $akreditasiProdi = $this->lk->akreditasiProdi;
        $prodi = $akreditasiProdi->prodi;

        switch ($prodi->jenjang) {
            case ProgramStudi::JENJANG_DIPLOMA:
                $this->tabel1($prodi->jenjang);
                $this->tabel2($prodi->jenjang);
                $this->tabel3($prodi->jenjang);
                $this->tabel4($prodi->jenjang);
                $this->tabel5($prodi->jenjang);
                $this->tabel7($prodi->jenjang);
                $this->tabel8($prodi->jenjang);
                break;
            case ProgramStudi::JENJANG_SARJANA:
            case ProgramStudi::JENJANG_SARJANA_TERAPAN:
                $this->tabel1($prodi->jenjang);
                $this->tabel2($prodi->jenjang);
                $this->tabel3($prodi->jenjang);
                $this->tabel4($prodi->jenjang);
                $this->tabel5($prodi->jenjang);
                $this->tabel6($prodi->jenjang);
                $this->tabel7($prodi->jenjang);
                $this->tabel8($prodi->jenjang);
                break;
            case ProgramStudi::JENJANG_MAGISTER:
            case ProgramStudi::JENJANG_MAGISTER_TERAPAN:
            case ProgramStudi::JENJANG_DOKTOR:
            case ProgramStudi::JENJANG_DOKTOR_TERAPAN:
                $this->tabel1($prodi->jenjang);
                $this->tabel2($prodi->jenjang);
                $this->tabel3($prodi->jenjang);
                $this->tabel4($prodi->jenjang);
                $this->tabel5($prodi->jenjang);
                $this->tabel6($prodi->jenjang);
                $this->tabel8($prodi->jenjang);
                break;

            default:
                throw new Exception('Tidak ada jenjang');

        }

        $writer = IOFactory::createWriter($this->spreadsheet, 'Xlsx');

        $timestamp = Carbon::now()->timestamp;
        $filename = "$timestamp-matriks-kuantitatif-" . Inflector::slug($prodi->nama) . '.xlsx';


        $path = K9ProdiDirectoryHelper::getKuantitatifPath($akreditasiProdi);
        $writer->save("$path/$filename");

        $model = K9DataKuantitatifProdi::findOne(['id_akreditasi_prodi' => $akreditasiProdi->id]);
        if (!$model) {
            $model = new K9DataKuantitatifProdi();
            $model->id_akreditasi_prodi = $akreditasiProdi->id;
        } else {
            $oldName = $model->isi_dokumen;
            FileHelper::unlink("$path/$oldName");
        }
        $model->nama_dokumen = 'Matriks Kuantitatif ' . $prodi->nama . '(' . $akreditasiProdi->akreditasi->tahun . ')';
        $model->isi_dokumen = $filename;
        $model->save(false);
    }

    private function tabel1($jenjang)
    {
        //get Kriteria 1 LK
        $tabel = $this->lk->k9LkProdiKriteria1s->k9LkProdiKriteria1Narasi;

        //1-1
        $crawler = new Crawler($tabel->_1__1);
        $data = $this->filter($crawler);
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
                ->setCellValue('J' . $currentContentRow, $item[9] ?? '');

            $currentContentRow++;
        }

        $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentContentRow, 1);
        $this->spreadsheet->getSheet($currentWorksheet)->getCell('B' . ($currentContentRow + 1))->getCalculatedValue();

        //1-2
        $crawler = new Crawler($tabel->_1__2);
        $data = $this->filter($crawler);
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
                ->setCellValue('J' . $currentContentRow, $item[9] ?? '');

            $currentContentRow++;
        }

        $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentContentRow, 1);
        $this->spreadsheet->getSheet($currentWorksheet)->getCell('B' . ($currentContentRow + 1))->getCalculatedValue();

        //1-3
        $crawler = new Crawler($tabel->_1__3);
        $data = $this->filter($crawler);
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
                ->setCellValue('J' . $currentContentRow, $item[9] ?? '');

            $currentContentRow++;
        }

        $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentContentRow, 1);
        $this->spreadsheet->getSheet($currentWorksheet)->getCell('B' . ($currentContentRow + 1))->getCalculatedValue();

    }

    private function tabel2(string $jenjang)
    {
        // Kriteria2 Narasi LK
        $narasi = $this->lk->k9LkProdiKriteria2s->k9LkProdiKriteria2Narasi;


        //2a
        $crawler = new Crawler($narasi->_2_a);
        $data = $this->filter($crawler);
        array_pop($data);

        $contentStartRow = 6;
        $currentContentRow = 6;
        $currentWorksheet = 6;

        foreach ($data as $item) {
            $this->spreadsheet->getSheet($currentWorksheet)
                ->setCellValue('B' . $currentContentRow, $item[1])
                ->setCellValue('C' . $currentContentRow, $item[2])
                ->setCellValue('D' . $currentContentRow, $item[3])
                ->setCellValue('E' . $currentContentRow, $item[4])
                ->setCellValue('F' . $currentContentRow, $item[5])
                ->setCellValue('G' . $currentContentRow, $item[6])
                ->setCellValue('H' . $currentContentRow, $item[7]);
            $currentContentRow++;

        }


        //2b
        switch ($jenjang) {
            case ProgramStudi::JENJANG_SARJANA:
            case ProgramStudi::JENJANG_SARJANA_TERAPAN :
            case ProgramStudi::JENJANG_MAGISTER:
            case ProgramStudi::JENJANG_MAGISTER_TERAPAN:
            case ProgramStudi::JENJANG_DOKTOR :
            case ProgramStudi::JENJANG_DOKTOR_TERAPAN:

                $crawler = new Crawler($narasi->_2_b);
                $data = $this->filter($crawler);
                array_pop($data);


                $contentStartRow = 7;
                $currentContentRow = 7;
                $currentWorksheet = 7;

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
                        ->setCellValue('J' . $currentContentRow, $item[9])
                        ->setCellValue('K' . $currentContentRow, $item[10]);
                    $currentContentRow++;

                }

                $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentContentRow, 1);


                break;
        }
    }

    private function tabel3(string $jenjang)
    {
        //narasi
        $narasi = $this->lk->k9LkProdiKriteria3s->k9LkProdiKriteria3Narasi;

        //3a1
        $crawler = new Crawler($narasi->_3_a_1);
        $data = $this->filter($crawler);
        array_pop($data);

        $startRow = 14;
        $currentRow = 14;
        $currentWorksheet = 8;

        foreach ($data as $item) {
            $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentRow + 1, 1);
            $this->spreadsheet->getSheet($currentWorksheet)
                ->setCellValue('A' . $currentRow, $item[0])
                ->setCellValue('B' . $currentRow, $item[1])
                ->setCellValue('C' . $currentRow, $item[2])
                ->setCellValue('D' . $currentRow, $item[3])
                ->setCellValue('E' . $currentRow, $item[4])
                ->setCellValue('F' . $currentRow, $item[5])
                ->setCellValue('G' . $currentRow, $item[6])
                ->setCellValue('H' . $currentRow, $item[7])
                ->setCellValue('I' . $currentRow, $item[8])
                ->setCellValue('J' . $currentRow, $item[9])
                ->setCellValue('K' . $currentRow, $item[10])
                ->setCellValue('L' . $currentRow, $item[11])
                ->setCellValue('M' . $currentRow, $item[12]);
            $currentRow++;

        }
        $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow, 2);

        //3a2
        $crawler = new Crawler($narasi->_3_a_2);
        $data = $this->filter($crawler);
        $startRow = 7;
        $currentRow = 7;
        $currentWorksheet = 9;

        foreach ($data as $item) {
            $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentRow + 1, 1);
            $this->spreadsheet->getSheet($currentWorksheet)
                ->setCellValue('A' . $currentRow, $item[0])
                ->setCellValue('B' . $currentRow, $item[1])
                ->setCellValue('C' . $currentRow, $item[2])
                ->setCellValue('D' . $currentRow, $item[3])
                ->setCellValue('E' . $currentRow, $item[4])
                ->setCellValue('G' . $currentRow, $item[6])
                ->setCellValue('H' . $currentRow, $item[7])
                ->setCellValue('I' . $currentRow, $item[8]);
            $currentRow++;

        }
        $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);

        //3a3
        $crawler = new Crawler($narasi->_3_a_3);
        $data = $this->filter($crawler);
        array_pop($data);
        array_pop($data);

        $startRow = 11;
        $currentRow = 11;
        $currentWorksheet = 10;

        foreach ($data as $item) {
            $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentRow + 1, 1);
            $this->spreadsheet->getSheet($currentWorksheet)
                ->setCellValue('A' . $currentRow, $item[0])
                ->setCellValue('B' . $currentRow, $item[1])
                ->setCellValue('C' . $currentRow, $item[2])
                ->setCellValue('D' . $currentRow, $item[3])
                ->setCellValue('E' . $currentRow, $item[4])
                ->setCellValue('F' . $currentRow, $item[5])
                ->setCellValue('G' . $currentRow, $item[6])
                ->setCellValue('H' . $currentRow, $item[7])
                ->setCellValue('I' . $currentRow, $item[8])
                ->setCellValue('J' . $currentRow, $item[9])
                ->setCellValue('K' . $currentRow, $item[10]);
            $currentRow++;

        }
        $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);

        //3a4
        $crawler = new Crawler($narasi->_3_a_4);
        $data = $this->filter($crawler);
        array_pop($data);

        $startRow = 13;
        $currentRow = 13;
        $currentWorksheet = 11;

        foreach ($data as $item) {
            $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentRow + 1, 1);
            $this->spreadsheet->getSheet($currentWorksheet)
                ->setCellValue('A' . $currentRow, $item[0])
                ->setCellValue('B' . $currentRow, $item[1])
                ->setCellValue('C' . $currentRow, $item[2])
                ->setCellValue('D' . $currentRow, $item[3])
                ->setCellValue('E' . $currentRow, $item[4])
                ->setCellValue('F' . $currentRow, $item[5])
                ->setCellValue('G' . $currentRow, $item[6])
                ->setCellValue('H' . $currentRow, $item[7])
                ->setCellValue('I' . $currentRow, $item[8])
                ->setCellValue('J' . $currentRow, $item[9]);
            $currentRow++;

        }
        $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);

        if (!$jenjang === ProgramStudi::JENJANG_DIPLOMA || $jenjang === ProgramStudi::JENJANG_SARJANA_TERAPAN) {
            //3a5
            $crawler = new Crawler($narasi->_3_a_5);
            $data = $this->filter($crawler);
            $startRow = 6;
            $currentRow = 6;
            $currentWorksheet = 12;

            foreach ($data as $item) {
                $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentRow + 1, 1);
                $this->spreadsheet->getSheet($currentWorksheet)
                    ->setCellValue('A' . $currentRow, $item[0])
                    ->setCellValue('B' . $currentRow, $item[1])
                    ->setCellValue('C' . $currentRow, $item[2])
                    ->setCellValue('D' . $currentRow, $item[3])
                    ->setCellValue('E' . $currentRow, $item[4])
                    ->setCellValue('F' . $currentRow, $item[5])
                    ->setCellValue('G' . $currentRow, $item[6])
                    ->setCellValue('H' . $currentRow, $item[7])
                    ->setCellValue('I' . $currentRow, $item[8]);
                $currentRow++;

            }
            $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
        }

        //3b1
        $crawler = new Crawler($narasi->_3_b_1);
        $data = $this->filter($crawler);
        array_pop($data);

        $startRow = 10;
        $currentRow = 10;
        $currentWorksheet = 13;

        foreach ($data as $item) {
            $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentRow + 1, 1);
            $this->spreadsheet->getSheet($currentWorksheet)
                ->setCellValue('A' . $currentRow, $item[0])
                ->setCellValue('B' . $currentRow, $item[1])
                ->setCellValue('C' . $currentRow, $item[2])
                ->setCellValue('D' . $currentRow, $item[3])
                ->setCellValue('E' . $currentRow, $item[4])
                ->setCellValue('F' . $currentRow, $item[5])
                ->setCellValue('G' . $currentRow, $item[6])
                ->setCellValue('H' . $currentRow, $item[7]);
            $currentRow++;

        }
        $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);

        //3b2
        $crawler = new Crawler($narasi->_3_b_2);
        $data = $this->filter($crawler);
        array_pop($data);

        $startRow = 6;
        $currentRow = 6;
        $currentWorksheet = 14;

        foreach ($data as $item) {
            $this->spreadsheet->getSheet($currentWorksheet)
                ->setCellValue('C' . $currentRow, $item[2])
                ->setCellValue('D' . $currentRow, $item[3])
                ->setCellValue('E' . $currentRow, $item[4]);
            $currentRow++;

        }
        $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);

        //3b3
        $crawler = new Crawler($narasi->_3_b_3);
        $data = $this->filter($crawler);
        array_pop($data);

        $startRow = 6;
        $currentRow = 6;
        $currentWorksheet = 15;

        foreach ($data as $item) {
            $this->spreadsheet->getSheet($currentWorksheet)
                ->setCellValue('C' . $currentRow, $item[2])
                ->setCellValue('D' . $currentRow, $item[3])
                ->setCellValue('E' . $currentRow, $item[4]);
            $currentRow++;

        }
        $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);

        if ($jenjang === ProgramStudi::JENJANG_SARJANA || $jenjang === ProgramStudi::JENJANG_MAGISTER || $jenjang === ProgramStudi::JENJANG_DOKTOR) {
            //3b4 Non Terapan
            $crawler = new Crawler($narasi->_3_b_4);
            $data = $this->filter($crawler);
            array_pop($data);

            $startRow = 7;
            $currentRow = 7;
            $currentWorksheet = 16;

            foreach ($data as $item) {
                $this->spreadsheet->getSheet($currentWorksheet)
                    ->setCellValue('C' . $currentRow, $item[2])
                    ->setCellValue('D' . $currentRow, $item[3])
                    ->setCellValue('E' . $currentRow, $item[4]);
                $currentRow++;

            }
            $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
        } else {
            //3b4 Non Terapan
            $crawler = new Crawler($narasi->_3_b_4);
            $data = $this->filter($crawler);
            array_pop($data);

            $startRow = 7;
            $currentRow = 7;
            $currentWorksheet = 17;

            foreach ($data as $item) {
                $this->spreadsheet->getSheet($currentWorksheet)
                    ->setCellValue('C' . $currentRow, $item[2])
                    ->setCellValue('D' . $currentRow, $item[3])
                    ->setCellValue('E' . $currentRow, $item[4]);
                $currentRow++;

            }
            $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
        }

        if ($jenjang !== ProgramStudi::JENJANG_DIPLOMA) {
            //3b5
            $crawler = new Crawler($narasi->_3_b_5);
            $data = $this->filter($crawler);
            array_pop($data);

            $startRow = 6;
            $currentRow = 6;
            $currentWorksheet = 18;

            foreach ($data as $item) {
                $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentRow + 1, 1);
                $this->spreadsheet->getSheet($currentWorksheet)
                    ->setCellValue('A' . $currentRow, $item[0])
                    ->setCellValue('B' . $currentRow, $item[1])
                    ->setCellValue('C' . $currentRow, $item[2])
                    ->setCellValue('D' . $currentRow, $item[3]);
                $currentRow++;

            }
            $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
        }
        if ($jenjang === ProgramStudi::JENJANG_DIPLOMA || $jenjang === ProgramStudi::JENJANG_SARJANA_TERAPAN || $jenjang === ProgramStudi::JENJANG_MAGISTER_TERAPAN || $jenjang === ProgramStudi::JENJANG_DOKTOR_TERAPAN) {
            //3b6
            $crawler = new Crawler($narasi->_3_b_6);
            $data = $this->filter($crawler);
            array_pop($data);

            $startRow = 6;
            $currentRow = 6;
            $currentWorksheet = 19;

            foreach ($data as $item) {
                $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentRow + 1, 1);
                $this->spreadsheet->getSheet($currentWorksheet)
                    ->setCellValue('A' . $currentRow, $item[0])
                    ->setCellValue('B' . $currentRow, $item[1])
                    ->setCellValue('C' . $currentRow, $item[2])
                    ->setCellValue('D' . $currentRow, $item[3])
                    ->setCellValue('E' . $currentRow, $item[4])
                    ->setCellValue('F' . $currentRow, $item[5] ?? '');
                $currentRow++;

            }
            $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
        }

        //3b7-1
        $crawler = new Crawler($narasi->_3_b_7__1);
        $data = $this->filter($crawler);
        array_pop($data);

        $startRow = 7;
        $currentRow = 7;
        $currentWorksheet = 20;

        foreach ($data as $k => $item) {
            if ($k === 0) {
                continue;
            }
            $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentRow + 1, 1);
            $this->spreadsheet->getSheet($currentWorksheet)
                ->setCellValue('A' . $currentRow, $item[0])
                ->setCellValue('B' . $currentRow, $item[1])
                ->setCellValue('C' . $currentRow, $item[2])
                ->setCellValue('D' . $currentRow, $item[3]);
            $currentRow++;

        }
        $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);

        //3b7-2
        $crawler = new Crawler($narasi->_3_b_7__2);
        $data = $this->filter($crawler);
        array_pop($data);

        $startRow = 7;
        $currentRow = 7;
        $currentWorksheet = 21;

        foreach ($data as $k => $item) {
            if ($k === 0) {
                $currentRow++;
                continue;
            }
            $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentRow + 1, 1);
            $this->spreadsheet->getSheet($currentWorksheet)
                ->setCellValue('A' . $currentRow, $item[0])
                ->setCellValue('B' . $currentRow, $item[1])
                ->setCellValue('C' . $currentRow, $item[2])
                ->setCellValue('D' . $currentRow, $item[3]);
            $currentRow++;

        }
        $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);

        //3b7-3
        $crawler = new Crawler($narasi->_3_b_7__3);
        $data = $this->filter($crawler);
        array_pop($data);

        $startRow = 7;
        $currentRow = 7;
        $currentWorksheet = 22;

        foreach ($data as $k => $item) {
            if ($k === 0) {
                $currentRow++;
                continue;
            }
            $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentRow + 1, 1);
            $this->spreadsheet->getSheet($currentWorksheet)
                ->setCellValue('A' . $currentRow, $item[0])
                ->setCellValue('B' . $currentRow, $item[1])
                ->setCellValue('C' . $currentRow, $item[2])
                ->setCellValue('D' . $currentRow, $item[3]);
            $currentRow++;

        }
        $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);

        //3b7-4
        $crawler = new Crawler($narasi->_3_b_7__4);
        $data = $this->filter($crawler);
        array_pop($data);

        $startRow = 7;
        $currentRow = 7;
        $currentWorksheet = 23;

        foreach ($data as $k => $item) {
            if ($k === 0) {
                $currentRow++;
                continue;
            }
            $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentRow + 1, 1);
            $this->spreadsheet->getSheet($currentWorksheet)
                ->setCellValue('A' . $currentRow, $item[0])
                ->setCellValue('B' . $currentRow, $item[1])
                ->setCellValue('C' . $currentRow, $item[2])
                ->setCellValue('D' . $currentRow, $item[3]);
            $currentRow++;

        }
        $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
    }

    private function tabel4(string $jenjang)
    {
        $narasi = $this->lk->k9LkProdiKriteria4s->k9LkProdiKriteria4Narasi;

        //4
        $crawler = new Crawler($narasi->_4);
        $data = $this->filter($crawler);
        array_pop($data);

        $startRow = 7;
        $currentRow = 7;
        $currentWorksheet = 24;

        foreach ($data as $k => $item) {
            if ($k === 0 || $k === 6 || $k === 9) {
                $currentRow++;
                continue;
            }

            $this->spreadsheet->getSheet($currentWorksheet)
                ->setCellValue('C' . $currentRow, $item[2])
                ->setCellValue('D' . $currentRow, $item[3])
                ->setCellValue('E' . $currentRow, $item[4])
                ->setCellValue('G' . $currentRow, $item[5])
                ->setCellValue('H' . $currentRow, $item[6])
                ->setCellValue('I' . $currentRow, $item[7]);
            $currentRow++;

        }
        $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);

    }

    private function tabel5(string $jenjang)
    {
        $narasi = $this->lk->k9LkProdiKriteria5s->k9LkProdiKriteria5Narasi;

        //5a
        $crawler = new Crawler($narasi->_5_a);
        $data = $this->filter($crawler);
        array_pop($data);

        $startRow = 10;
        $currentRow = 10;
        $currentWorksheet = 25;

        foreach ($data as $k => $item) {

            $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentRow + 1, 1);
            $this->spreadsheet->getSheet($currentWorksheet)
                ->setCellValue('A' . $currentRow, $item[0])
                ->setCellValue('B' . $currentRow, $item[1])
                ->setCellValue('C' . $currentRow, $item[2])
                ->setCellValue('D' . $currentRow, $item[3])
                ->setCellValue('E' . $currentRow, $item[4])
                ->setCellValue('F' . $currentRow, $item[5])
                ->setCellValue('G' . $currentRow, $item[6])
                ->setCellValue('H' . $currentRow, $item[7])
                ->setCellValue('I' . $currentRow, $item[8])
                ->setCellValue('J' . $currentRow, $item[9])
                ->setCellValue('K' . $currentRow, $item[10])
                ->setCellValue('L' . $currentRow, $item[11])
                ->setCellValue('M' . $currentRow, $item[12])
                ->setCellValue('N' . $currentRow, $item[13])
                ->setCellValue('O' . $currentRow, $item[14]);
            $currentRow++;

        }
        $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);

        //5b
        $crawler = new Crawler($narasi->_5_b);
        $data = $this->filter($crawler);

        $startRow = 5;
        $currentRow = 5;
        $currentWorksheet = 26;

        foreach ($data as $k => $item) {

            $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentRow + 1, 1);
            $this->spreadsheet->getSheet($currentWorksheet)
                ->setCellValue('A' . $currentRow, $item[0])
                ->setCellValue('B' . $currentRow, $item[1])
                ->setCellValue('C' . $currentRow, $item[2])
                ->setCellValue('D' . $currentRow, $item[3])
                ->setCellValue('E' . $currentRow, $item[4])
                ->setCellValue('F' . $currentRow, $item[5] ?? '');
            $currentRow++;

        }
        $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);

        //5c
        $crawler = new Crawler($narasi->_5_c);
        $data = $this->filter($crawler);
        array_pop($data);


        $startRow = 6;
        $currentRow = 6;
        $currentWorksheet = 27;

        foreach ($data as $k => $item) {

            $this->spreadsheet->getSheet($currentWorksheet)
                ->setCellValue('C' . $currentRow, $item[0])
                ->setCellValue('D' . $currentRow, $item[1])
                ->setCellValue('E' . $currentRow, $item[2])
                ->setCellValue('F' . $currentRow, $item[3])
                ->setCellValue('G' . $currentRow, $item[4]);
            $currentRow++;

        }
        $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
    }

    private function tabel7(string $jenjang)
    {
        $narasi = $this->lk->k9LkProdiKriteria7s->k9LkProdiKriteria7Narasi;

        //7
        $crawler = new Crawler($narasi->_7);
        $data = $this->filter($crawler);
        array_pop($data);
        $startRow = 6;
        $currentRow = 6;
        $currentWorksheet = 30;

        foreach ($data as $k => $item) {

            $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentRow + 1, 1);
            $this->spreadsheet->getSheet($currentWorksheet)
                ->setCellValue('A' . $currentRow, $item[0])
                ->setCellValue('B' . $currentRow, $item[1])
                ->setCellValue('C' . $currentRow, $item[2])
                ->setCellValue('D' . $currentRow, $item[3])
                ->setCellValue('E' . $currentRow, $item[4])
                ->setCellValue('F' . $currentRow, $item[5]);
            $currentRow++;

        }
        $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
    }

    private function tabel8(string $jenjang)
    {
        $narasi = $this->lk->k9LkProdiKriteria8s->k9LkProdiKriteria8Narasi;

        //8a
        $crawler = new Crawler($narasi->_8_a);
        $data = $this->filter($crawler);
        $startRow = 6;
        $currentRow = 6;
        $currentWorksheet = 31;

        foreach ($data as $k => $item) {

            $this->spreadsheet->getSheet($currentWorksheet)
                ->setCellValue('C' . $currentRow, $item[2])
                ->setCellValue('D' . $currentRow, $item[3])
                ->setCellValue('E' . $currentRow, $item[4])
                ->setCellValue('F' . $currentRow, $item[5]);
            $currentRow++;

        }
        $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);

        //8b1
        $crawler = new Crawler($narasi->_8_b_1);
        $data = $this->filter($crawler);
        array_pop($data);
        $startRow = 10;
        $currentRow = 10;
        $currentWorksheet = 32;

        foreach ($data as $k => $item) {

            $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentRow + 1, 1);
            $this->spreadsheet->getSheet($currentWorksheet)
                ->setCellValue('A' . $currentRow, $item[0])
                ->setCellValue('B' . $currentRow, $item[1])
                ->setCellValue('C' . $currentRow, $item[2])
                ->setCellValue('D' . $currentRow, $item[3])
                ->setCellValue('E' . $currentRow, $item[4])
                ->setCellValue('F' . $currentRow, $item[5])
                ->setCellValue('G' . $currentRow, $item[6]);
            $currentRow++;

        }
        $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);

        if ($jenjang === ProgramStudi::JENJANG_DIPLOMA || $jenjang === ProgramStudi::JENJANG_SARJANA || $jenjang === ProgramStudi::JENJANG_SARJANA_TERAPAN) {
            $crawler = new Crawler($narasi->_8_b_2);
            $data = $this->filter($crawler);
            array_pop($data);
            $startRow = 11;
            $currentRow = 11;
            $currentWorksheet = 33;

            foreach ($data as $k => $item) {

                $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentRow + 1, 1);
                $this->spreadsheet->getSheet($currentWorksheet)
                    ->setCellValue('A' . $currentRow, $item[0])
                    ->setCellValue('B' . $currentRow, $item[1])
                    ->setCellValue('C' . $currentRow, $item[2])
                    ->setCellValue('D' . $currentRow, $item[3])
                    ->setCellValue('E' . $currentRow, $item[4])
                    ->setCellValue('F' . $currentRow, $item[5])
                    ->setCellValue('G' . $currentRow, $item[6]);
                $currentRow++;

            }
            $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
        }

        //8C
        $crawler = new Crawler($narasi->_8_c);
        $data = $this->filter($crawler);

        if ($jenjang === ProgramStudi::JENJANG_DIPLOMA) {
            $startRow = 7;
            $currentRow = 7;
            $currentWorksheet = 34;
            $startColumn = 'E';
            $startColumnIndex = 4;
            foreach ($data as $k => $item) {
                $this->spreadsheet->getSheet($currentWorksheet)->setCellValue('B' . $currentRow,
                    $item[1]);
                for ($i = $startColumnIndex; $i <= 8; $i++) {
                    $this->spreadsheet->getSheet($currentWorksheet)->setCellValue($startColumn . $currentRow,
                        $item[$i]);
                }
                $startColumnIndex++;
                $startColumn++;
                $currentRow++;
            }
            $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
        } elseif ($jenjang === ProgramStudi::JENJANG_SARJANA || $jenjang === ProgramStudi::JENJANG_SARJANA_TERAPAN) {
            $startRow = 15;
            $currentRow = 15;
            $currentWorksheet = 34;
            $startColumn = 'F';
            $startColumnIndex = 5;
            foreach ($data as $k => $item) {
                $this->spreadsheet->getSheet($currentWorksheet)->setCellValue('B' . $currentRow,
                    $item[1]);
                for ($i = $startColumnIndex; $i <= 10; $i++) {
                    $this->spreadsheet->getSheet($currentWorksheet)->setCellValue($startColumn . $currentRow,
                        $item[$i]);
                }
                $startColumnIndex++;
                $startColumn++;
                $currentRow++;
            }
            $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
        } elseif ($jenjang === ProgramStudi::JENJANG_MAGISTER || $jenjang === ProgramStudi::JENJANG_MAGISTER_TERAPAN) {
            $startRow = 24;
            $currentRow = 24;
            $currentWorksheet = 34;
            $startColumn = 'D';
            $startColumnIndex = 3;
            foreach ($data as $k => $item) {
                $this->spreadsheet->getSheet($currentWorksheet)->setCellValue('B' . $currentRow,
                    $item[1]);
                for ($i = $startColumnIndex; $i <= 7; $i++) {
                    $this->spreadsheet->getSheet($currentWorksheet)->setCellValue($startColumn . $currentRow,
                        $item[$i]);
                }
                $startColumnIndex++;
                $startColumn++;
                $currentRow++;
            }
            $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
        } elseif ($jenjang === ProgramStudi::JENJANG_DOKTOR || $jenjang === ProgramStudi::JENJANG_DOKTOR_TERAPAN) {
            $startRow = 32;
            $currentRow = 32;
            $currentWorksheet = 34;
            $startColumn = 'E';
            $startColumnIndex = 4;
            foreach ($data as $k => $item) {
                $this->spreadsheet->getSheet($currentWorksheet)->setCellValue('B' . $currentRow,
                    $item[1]);
                for ($i = $startColumnIndex; $i <= 10; $i++) {
                    $this->spreadsheet->getSheet($currentWorksheet)->setCellValue($startColumn . $currentRow,
                        $item[$i]);
                }
                $startColumnIndex++;
                $startColumn++;
                $currentRow++;
            }
            $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
        }


        //8d1
        $crawler = new Crawler($narasi->_8_d_1);
        $data = $this->filter($crawler);
        array_pop($data);
        if ($jenjang === ProgramStudi::JENJANG_DIPLOMA) {
            $startRow = 7;
            $currentRow = 7;
            $currentWorksheet = 35;

            foreach ($data as $k => $item) {

                $this->spreadsheet->getSheet($currentWorksheet)
                    ->setCellValue('B' . $currentRow, $item[1])
                    ->setCellValue('C' . $currentRow, $item[2])
                    ->setCellValue('D' . $currentRow, $item[3])
                    ->setCellValue('E' . $currentRow, $item[4])
                    ->setCellValue('F' . $currentRow, $item[5])
                    ->setCellValue('G' . $currentRow, $item[6]);
                $currentRow++;

            }
            $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
        } elseif ($jenjang === ProgramStudi::JENJANG_SARJANA) {
            $startRow = 16;
            $currentRow = 16;
            $currentWorksheet = 35;

            foreach ($data as $k => $item) {

                $this->spreadsheet->getSheet($currentWorksheet)
                    ->setCellValue('B' . $currentRow, $item[1])
                    ->setCellValue('C' . $currentRow, $item[2])
                    ->setCellValue('D' . $currentRow, $item[3])
                    ->setCellValue('E' . $currentRow, $item[4])
                    ->setCellValue('F' . $currentRow, $item[5]);
                $currentRow++;

            }
            $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
        } elseif ($jenjang === ProgramStudi::JENJANG_SARJANA_TERAPAN) {
            $startRow = 25;
            $currentRow = 25;
            $currentWorksheet = 35;

            foreach ($data as $k => $item) {

                $this->spreadsheet->getSheet($currentWorksheet)
                    ->setCellValue('B' . $currentRow, $item[1])
                    ->setCellValue('C' . $currentRow, $item[2])
                    ->setCellValue('D' . $currentRow, $item[3])
                    ->setCellValue('E' . $currentRow, $item[4])
                    ->setCellValue('F' . $currentRow, $item[5]);
                $currentRow++;

            }
            $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
        }

        //8d2
        if ($jenjang === ProgramStudi::JENJANG_DIPLOMA || $jenjang === ProgramStudi::JENJANG_SARJANA || $jenjang === ProgramStudi::JENJANG_SARJANA_TERAPAN || $jenjang === ProgramStudi::JENJANG_MAGISTER || $jenjang === ProgramStudi::JENJANG_MAGISTER_TERAPAN) {
            $crawler = new Crawler($narasi->_8_d_2);
            $data = $this->filter($crawler);
            array_pop($data);
            $startRow = 7;
            $currentRow = 7;
            $currentWorksheet = 36;

            foreach ($data as $k => $item) {

                $this->spreadsheet->getSheet($currentWorksheet)
                    ->setCellValue('B' . $currentRow, $item[1])
                    ->setCellValue('C' . $currentRow, $item[2])
                    ->setCellValue('D' . $currentRow, $item[3])
                    ->setCellValue('E' . $currentRow, $item[4])
                    ->setCellValue('F' . $currentRow, $item[5]);
                $currentRow++;

            }
            $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
        }

        //8e1
        if ($jenjang === ProgramStudi::JENJANG_DIPLOMA || $jenjang === ProgramStudi::JENJANG_SARJANA || $jenjang === ProgramStudi::JENJANG_SARJANA_TERAPAN) {

            $crawler = new Crawler($narasi->_8_e_1);
            $data = $this->filter($crawler);
            array_pop($data);
            $startRow = 7;
            $currentRow = 7;
            $currentWorksheet = 37;

            foreach ($data as $k => $item) {

                $this->spreadsheet->getSheet($currentWorksheet)
                    ->setCellValue('B' . $currentRow, $item[1])
                    ->setCellValue('C' . $currentRow, $item[2])
                    ->setCellValue('D' . $currentRow, $item[3])
                    ->setCellValue('E' . $currentRow, $item[4])
                    ->setCellValue('F' . $currentRow, $item[5]);
                $currentRow++;

            }
            $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
        }

        //ref 8e2
        if ($jenjang !== ProgramStudi::JENJANG_DOKTOR_TERAPAN || $jenjang !== ProgramStudi::JENJANG_DOKTOR) {

            $crawler = new Crawler($narasi->_8_e_2__ref);
            $data = $this->filter($crawler);
            array_pop($data);
            $startRow = 7;
            $currentRow = 7;
            $currentWorksheet = 38;

            foreach ($data as $k => $item) {

                $this->spreadsheet->getSheet($currentWorksheet)
                    ->setCellValue('B' . $currentRow, $item[1])
                    ->setCellValue('C' . $currentRow, $item[2]);
                $currentRow++;

            }
            $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);

            //8e2
            $crawler = new Crawler($narasi->_8_e_2);
            $data = $this->filter($crawler);
            array_pop($data);
            $startRow = 7;
            $currentRow = 7;
            $currentWorksheet = 39;

            foreach ($data as $k => $item) {

                $this->spreadsheet->getSheet($currentWorksheet)
                    ->setCellValue('C' . $currentRow, $item[2])
                    ->setCellValue('D' . $currentRow, $item[3])
                    ->setCellValue('E' . $currentRow, $item[4])
                    ->setCellValue('F' . $currentRow, $item[5])
                    ->setCellValue('G' . $currentRow, $item[6]);
                $currentRow++;

            }
            $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
        }

        //8f1
        if ($jenjang === ProgramStudi::JENJANG_SARJANA || $jenjang === ProgramStudi::JENJANG_MAGISTER || $jenjang === ProgramStudi::JENJANG_DOKTOR) {
            $crawler = new Crawler($narasi->_8_f_1);
            $data = $this->filter($crawler);
            array_pop($data);
            $startRow = 7;
            $currentRow = 7;
            $currentWorksheet = 40;

            foreach ($data as $k => $item) {

                $this->spreadsheet->getSheet($currentWorksheet)
                    ->setCellValue('C' . $currentRow, $item[2])
                    ->setCellValue('D' . $currentRow, $item[3])
                    ->setCellValue('E' . $currentRow, $item[4]);
                $currentRow++;

            }
            $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
        } else {
            $crawler = new Crawler($narasi->_8_f_1);
            $data = $this->filter($crawler);
            array_pop($data);
            $startRow = 7;
            $currentRow = 7;
            $currentWorksheet = 41;

            foreach ($data as $k => $item) {

                $this->spreadsheet->getSheet($currentWorksheet)
                    ->setCellValue('C' . $currentRow, $item[2])
                    ->setCellValue('D' . $currentRow, $item[3])
                    ->setCellValue('E' . $currentRow, $item[4]);
                $currentRow++;

            }
            $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
        }

        //8f2
        if ($jenjang === ProgramStudi::JENJANG_MAGISTER || $jenjang === ProgramStudi::JENJANG_MAGISTER_TERAPAN || $jenjang === ProgramStudi::JENJANG_DOKTOR || $jenjang === ProgramStudi::JENJANG_DOKTOR_TERAPAN) {
            $crawler = new Crawler($narasi->_8_f_2);
            $data = $this->filter($crawler);
            array_pop($data);
            $startRow = 6;
            $currentRow = 6;
            $currentWorksheet = 42;

            foreach ($data as $k => $item) {

                $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentRow + 1, 1);
                $this->spreadsheet->getSheet($currentWorksheet)
                    ->setCellValue('A' . $currentRow, $item[0])
                    ->setCellValue('B' . $currentRow, $item[1])
                    ->setCellValue('C' . $currentRow, $item[2])
                    ->setCellValue('D' . $currentRow, $item[3]);
                $currentRow++;

            }
            $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
        }

        // 8f3
        if ($jenjang === ProgramStudi::JENJANG_DIPLOMA || $jenjang === ProgramStudi::JENJANG_SARJANA_TERAPAN || $jenjang === ProgramStudi::JENJANG_MAGISTER_TERAPAN || $jenjang === ProgramStudi::JENJANG_DOKTOR_TERAPAN) {

            $crawler = new Crawler($narasi->_8_f_3);
            $data = $this->filter($crawler);
            array_pop($data);
            $startRow = 6;
            $currentRow = 6;
            $currentWorksheet = 43;

            foreach ($data as $k => $item) {

                $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentRow + 1, 1);
                $this->spreadsheet->getSheet($currentWorksheet)
                    ->setCellValue('A' . $currentRow, $item[0])
                    ->setCellValue('B' . $currentRow, $item[1])
                    ->setCellValue('C' . $currentRow, $item[2])
                    ->setCellValue('D' . $currentRow, $item[3])
                    ->setCellValue('E' . $currentRow, $item[4])
                    ->setCellValue('F' . $currentRow, $item[5] ?? '');
                $currentRow++;

            }
            $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
        }

        if ($jenjang !== ProgramStudi::JENJANG_DIPLOMA) {

            $crawler = new Crawler($narasi->_8_f_4__1);
            $data = $this->filter($crawler);
            array_pop($data);
            $startRow = 8;
            $currentRow = 8;
            $currentWorksheet = 44;

            foreach ($data as $k => $item) {

                if ($k === 0) {
                    $currentRow++;
                    continue;
                }
                $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentRow + 1, 1);
                $this->spreadsheet->getSheet($currentWorksheet)
                    ->setCellValue('A' . $currentRow, $item[0])
                    ->setCellValue('B' . $currentRow, $item[1])
                    ->setCellValue('C' . $currentRow, $item[2])
                    ->setCellValue('D' . $currentRow, $item[3]);
                $currentRow++;

            }
            $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);

            $crawler = new Crawler($narasi->_8_f_4__2);
            $data = $this->filter($crawler);
            array_pop($data);
            $startRow = 8;
            $currentRow = 8;
            $currentWorksheet = 45;

            foreach ($data as $k => $item) {

                if ($k === 0) {
                    $currentRow++;
                    continue;
                }
                $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentRow + 1, 1);
                $this->spreadsheet->getSheet($currentWorksheet)
                    ->setCellValue('A' . $currentRow, $item[0])
                    ->setCellValue('B' . $currentRow, $item[1])
                    ->setCellValue('C' . $currentRow, $item[2])
                    ->setCellValue('D' . $currentRow, $item[3]);
                $currentRow++;

            }
            $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
        }

        $crawler = new Crawler($narasi->_8_f_4__3);
        $data = $this->filter($crawler);
        array_pop($data);
        $startRow = 8;
        $currentRow = 8;
        $currentWorksheet = 46;

        foreach ($data as $k => $item) {

            if ($k === 0) {
                $currentRow++;
                continue;
            }
            $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentRow + 1, 1);
            $this->spreadsheet->getSheet($currentWorksheet)
                ->setCellValue('A' . $currentRow, $item[0])
                ->setCellValue('B' . $currentRow, $item[1])
                ->setCellValue('C' . $currentRow, $item[2])
                ->setCellValue('D' . $currentRow, $item[3]);
            $currentRow++;

        }
        $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);


        $crawler = new Crawler($narasi->_8_f_4__4);
        $data = $this->filter($crawler);
        array_pop($data);
        $startRow = 8;
        $currentRow = 8;
        $currentWorksheet = 47;

        foreach ($data as $k => $item) {

            if ($k === 0) {
                $currentRow++;
                continue;
            }
            $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentRow + 1, 1);
            $this->spreadsheet->getSheet($currentWorksheet)
                ->setCellValue('A' . $currentRow, $item[0])
                ->setCellValue('B' . $currentRow, $item[1])
                ->setCellValue('C' . $currentRow, $item[2])
                ->setCellValue('D' . $currentRow, $item[3]);
            $currentRow++;

        }
        $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
    }

    private function tabel6(string $jenjang)
    {
        //6a
        $narasi = $this->lk->k9LkProdiKriteria6s->k9LkProdiKriteria6Narasi;

        if ($jenjang !== ProgramStudi::JENJANG_DIPLOMA) {
            $crawler = new Crawler($narasi->_6_a);
            $data = $this->filter($crawler);
            array_pop($data);


            $startRow = 6;
            $currentRow = 6;
            $currentWorksheet = 28;

            foreach ($data as $k => $item) {

                $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentRow + 1, 1);
                $this->spreadsheet->getSheet($currentWorksheet)
                    ->setCellValue('A' . $currentRow, $item[0])
                    ->setCellValue('B' . $currentRow, $item[1])
                    ->setCellValue('C' . $currentRow, $item[2])
                    ->setCellValue('D' . $currentRow, $item[3])
                    ->setCellValue('E' . $currentRow, $item[4])
                    ->setCellValue('F' . $currentRow, $item[5]);
                $currentRow++;

            }
            $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
        }

        if ($jenjang === ProgramStudi::JENJANG_MAGISTER || $jenjang === ProgramStudi::JENJANG_MAGISTER_TERAPAN || $jenjang === ProgramStudi::JENJANG_DOKTOR || $jenjang === ProgramStudi::JENJANG_DOKTOR_TERAPAN) {
            $crawler = new Crawler($narasi->_6_b);
            $data = $this->filter($crawler);
            array_pop($data);


            $startRow = 6;
            $currentRow = 6;
            $currentWorksheet = 29;

            foreach ($data as $k => $item) {

                $this->spreadsheet->getSheet($currentWorksheet)->insertNewRowBefore($currentRow + 1, 1);
                $this->spreadsheet->getSheet($currentWorksheet)
                    ->setCellValue('A' . $currentRow, $item[0])
                    ->setCellValue('B' . $currentRow, $item[1])
                    ->setCellValue('C' . $currentRow, $item[2])
                    ->setCellValue('D' . $currentRow, $item[3])
                    ->setCellValue('E' . $currentRow, $item[4])
                    ->setCellValue('F' . $currentRow, $item[5]);
                $currentRow++;

            }
            $this->spreadsheet->getSheet($currentWorksheet)->removeRow($currentRow);
        }

    }

    protected function filter($crawler)
    {
        return $crawler->filter('tbody')->filter('tr')->each(function ($tr, $i) {
            return $tr->filter('td')->each(function ($td, $i) {
                return trim($td->text());
            });
        });
    }

}
