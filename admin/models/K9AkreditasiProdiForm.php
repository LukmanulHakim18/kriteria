<?php


namespace admin\models;

use common\helpers\kriteria9\K9ProdiJsonHelper;
use common\models\kriteria9\akreditasi\K9AkreditasiProdi;
use common\models\kriteria9\led\Led;
use common\models\kriteria9\led\prodi\K9LedProdi;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria1;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria2;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria3;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria4;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria5;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria6;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria7;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria8;
use common\models\kriteria9\led\prodi\K9LedProdiKriteria9;
use common\models\kriteria9\led\prodi\K9LedProdiNarasiAnalisis;
use common\models\kriteria9\led\prodi\K9LedProdiNarasiKondisiEksternal;
use common\models\kriteria9\led\prodi\K9LedProdiNarasiKriteria1;
use common\models\kriteria9\led\prodi\K9LedProdiNarasiKriteria2;
use common\models\kriteria9\led\prodi\K9LedProdiNarasiKriteria3;
use common\models\kriteria9\led\prodi\K9LedProdiNarasiKriteria4;
use common\models\kriteria9\led\prodi\K9LedProdiNarasiKriteria5;
use common\models\kriteria9\led\prodi\K9LedProdiNarasiKriteria6;
use common\models\kriteria9\led\prodi\K9LedProdiNarasiKriteria7;
use common\models\kriteria9\led\prodi\K9LedProdiNarasiKriteria8;
use common\models\kriteria9\led\prodi\K9LedProdiNarasiKriteria9;
use common\models\kriteria9\led\prodi\K9LedProdiNarasiProfilUpps;
use common\models\kriteria9\lk\Lk;
use common\models\kriteria9\lk\prodi\K9LkProdi;
use common\models\kriteria9\lk\TabelLk;
use InvalidArgumentException;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\db\Transaction;
use yii\helpers\FileHelper;
use yii\helpers\Json;

class K9AkreditasiProdiForm extends Model
{

    public $id_akreditasi;
    public $id_prodi;

    /**
     * @var K9AkreditasiProdi
     */
    private $_akreditasiProdi;

    /**
     * @var K9LedProdi
     */
    private $_led_prodi;
    /**
     * @var K9LkProdi
     */
    private $_lk_prodi;

    public static function findOne($id)
    {

        $model = new K9AkreditasiProdiForm();
        $data = K9AkreditasiProdi::findOne($id);
        $id_akreditasi = $data->id_akreditasi;
        $model->id_prodi = $data->id_prodi;
        $model->id_akreditasi = $data->id_akreditasi;
        $model->_lk_prodi = $data->k9LkProdis;
        $model->_led_prodi = $data->k9LedProdis;

        return $model;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id_akreditasi', 'id_prodi'], 'required'],
            [['id_prodi', 'id_akreditasi'], 'integer'],
        ];
    }

    /**
     * @throws Exception
     */
    public function createAkreditasi()
    {


        $transaction = Yii::$app->db->beginTransaction();


        try {
            $this->_akreditasiProdi = new K9AkreditasiProdi();
            $this->_akreditasiProdi->progress = 0;
            $this->_akreditasiProdi->id_akreditasi = $this->id_akreditasi;
            $this->_akreditasiProdi->id_prodi = $this->id_prodi;

            $this->_akreditasiProdi->save();

            $this->createLk($transaction);
            $this->createLed($transaction);

            $transaction->commit();
        } catch (\ErrorException $e) {
            $transaction->rollBack();
            throw new Exception($e->getMessage());
        }


        return true;
    }

    /**
     * @param $transaction Transaction
     */
    private function createLk($transaction)
    {
        $this->_lk_prodi = new K9LkProdi();


        $this->_lk_prodi->id_akreditasi_prodi = $this->_akreditasiProdi->id;
        $this->_lk_prodi->progress = 0;

        if (!$this->_lk_prodi->save(false)) {
            $transaction->rollback();
            throw new InvalidArgumentException($this->_lk_prodi->errors);
        }

        $prodi = $this->_akreditasiProdi->prodi;
        $fileJson = 'lkps_prodi_' . $prodi->jenjang . '.json';
        $json = K9ProdiJsonHelper::getAllJsonLk($prodi->jenjang);
        foreach ($json as /** @var Lk $kriteria */ $kriteria) {
            $kritClass = 'common\\models\\kriteria9\\lk\\prodi\\K9LkProdiKriteria' . $kriteria->kriteria;
            $kritProdi = new $kritClass;
            $kritProdi->setAttributes(['id_lk_prodi'=>$this->_lk_prodi->id,'progress_narasi'=>0,'progress_dokumen'=>0]);

            if (!$kritProdi->save(false)) {
                $transaction->rollBack();
                throw new InvalidArgumentException($kritProdi->errors);
            }

            $class = 'common\\models\\kriteria9\\lk\\prodi\\K9LkProdiKriteria' . $kriteria->kriteria . 'Narasi';
            $kriteriaProdi = new $class;

            $attr = ['id_lk_prodi_kriteria' . $kriteria->kriteria => $kritProdi->id, 'progress' => 0];
            $kriteriaProdi->setAttributes($attr);
            foreach ($kriteria->butir as $key => /** @var $item TabelLk */$item) {
                $modelAttribute = '_' . str_replace('.', '_', $item->tabel);
                $kriteriaProdi->$modelAttribute = $item->template;
            }
            if (!$kriteriaProdi->save()) {
                $transaction->rollBack();
                throw new InvalidArgumentException($kriteriaProdi->errors);
            }
        }
        $this->createFolder();
    }

    /**
     * @throws Exception
     */
    private function createFolder()
    {
        $uploadPath = Yii::$app->params['uploadPath'];
        $path = Yii::getAlias('@uploadAkreditasi');


        $replacementsProdi = [
            '{lembaga}' => $this->_akreditasiProdi->akreditasi->lembaga,
            '{jenis_akreditasi}' => $this->_akreditasiProdi->akreditasi->jenis_akreditasi,
            '{tahun}' => $this->_akreditasiProdi->akreditasi->tahun,
            '{level}' => 'prodi',
            '{id}' => $this->_akreditasiProdi->id_prodi,
        ];

        $resultProdi = strtr($uploadPath, $replacementsProdi);

        $pathP = $path . '/' . $resultProdi;

        $pathLedSumber = $pathP . '/led/sumber';
        $pathLedPendukung = $pathP . '/led/pendukung';
        $pathLedLainnya = $pathP . '/led/lainnya';

        $pathLkSumber = $pathP . '/lk/sumber';
        $pathLkPendukung = $pathP . '/lk/pendukung';
        $pathLkLainnya = $pathP . '/lk/lainnya';

        $pathMatriks = $pathP . '/matriks-kuantitatif';


        try {
            FileHelper::createDirectory($pathLedSumber);
            FileHelper::createDirectory($pathLedPendukung);
            FileHelper::createDirectory($pathLedLainnya);
            FileHelper::createDirectory($pathLkSumber);
            FileHelper::createDirectory($pathLkPendukung);
            FileHelper::createDirectory($pathLkLainnya);
            FileHelper::createDirectory($pathMatriks);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $transaction Transaction
     */
    private function createLed($transaction)
    {
        $this->_led_prodi = new K9LedProdi();


        $this->_led_prodi->id_akreditasi_prodi = $this->_akreditasiProdi->id;
        $this->_led_prodi->progress = 0;

        if (!$this->_led_prodi->save(false)) {
            $transaction->rollback();
            throw new InvalidArgumentException($this->_led_prodi->errors);
        }

        $attr = ['id_led_prodi' => $this->_led_prodi->id, 'progress' => 0];

        $kondisiEksternal  = new K9LedProdiNarasiKondisiEksternal();
        $profilUpps = new K9LedProdiNarasiProfilUpps();
        $analisis = new K9LedProdiNarasiAnalisis();

        $kondisiEksternal->attributes = $attr;
        $profilUpps->attributes = $attr;
        $analisis->attributes = $attr;

        if(!$kondisiEksternal->save()){
            $transaction->rollBack();

            throw new \yii\db\Exception($kondisiEksternal->errors);
        }
        if(!$profilUpps->save()){
            $transaction->rollBack();

            throw new \yii\db\Exception($profilUpps->errors);
        }
        if(!$analisis->save()){
            $transaction->rollBack();

            throw new \yii\db\Exception($analisis->errors);
        }
        for ($i = 1; $i <= 9; $i++) {

            $kriteria_class_path = 'common\\models\\kriteria9\\led\\prodi\\K9LedProdiKriteria' . $i;
            $kriteria_narasi_class_path = 'common\\models\kriteria9\\led\\prodi\\K9LedProdiNarasiKriteria' . $i;

            $kriteriaProdi = new $kriteria_class_path;
            $kriteriaProdi->attributes = $attr;

            if (!$kriteriaProdi->save()) {
                $transaction->rollBack();
                throw new InvalidArgumentException($kriteriaProdi->errors);
            }
            $narasiAttr = 'id_led_prodi_kriteria'.$i;

            $narasiKriteriaProdi = new $kriteria_narasi_class_path;
            $narasiKriteriaProdi->$narasiAttr = $kriteriaProdi->id;
            $narasiKriteriaProdi->progress = 0;

            if (!$narasiKriteriaProdi->save()) {
                $transaction->rollBack();
                throw new InvalidArgumentException($narasiKriteriaProdi->errors);
            }
        }
    }
}
