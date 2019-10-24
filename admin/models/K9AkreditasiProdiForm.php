<?php


namespace admin\models;


use common\models\kriteria9\akreditasi\K9AkreditasiProdi;
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
use common\models\kriteria9\led\prodi\K9LedProdiNarasiKriteria1;
use common\models\kriteria9\led\prodi\K9LedProdiNarasiKriteria2;
use common\models\kriteria9\led\prodi\K9LedProdiNarasiKriteria3;
use common\models\kriteria9\led\prodi\K9LedProdiNarasiKriteria4;
use common\models\kriteria9\led\prodi\K9LedProdiNarasiKriteria5;
use common\models\kriteria9\led\prodi\K9LedProdiNarasiKriteria6;
use common\models\kriteria9\led\prodi\K9LedProdiNarasiKriteria7;
use common\models\kriteria9\led\prodi\K9LedProdiNarasiKriteria8;
use common\models\kriteria9\led\prodi\K9LedProdiNarasiKriteria9;
use common\models\kriteria9\lk\prodi\K9LkProdi;
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

        $fileJson = 'lkps_prodi_s1.json';
        $json = Json::decode(file_get_contents(Yii::getAlias('@common/required/kriteria9/aps/' . $fileJson)));
        $attr = ['id_lk_prodi' => $this->_lk_prodi->id, 'progress' => 0];
        foreach ($json as $kriteria) {
            $class = 'common\\models\\kriteria9\\lk\\prodi\\K9LkProdiKriteria' . $kriteria['kriteria'];
            $kriteriaProdi = new $class;
            $kriteriaProdi->setAttributes($attr);
            foreach ($kriteria['butir'] as $key => $item) {
                $modelAttribute = '_' . str_replace('.', '_', $item['nomor']);
                $kriteriaProdi->$modelAttribute = $item['template'];
                if (!$kriteriaProdi->save) {
                    $transaction->rollBack();
                    throw new InvalidArgumentException($kriteriaProdi->errors);
                }
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

        $kriteria1Prodi = new K9LedProdiKriteria1();
        $kriteria2Prodi = new K9LedProdiKriteria2();
        $kriteria3Prodi = new K9LedProdiKriteria3();
        $kriteria4Prodi = new K9LedProdiKriteria4();
        $kriteria5Prodi = new K9LedProdiKriteria5();
        $kriteria6Prodi = new K9LedProdiKriteria6();
        $kriteria7Prodi = new K9LedProdiKriteria7();
        $kriteria8Prodi = new K9LedProdiKriteria8();
        $kriteria9Prodi = new K9LedProdiKriteria9();

        $narasiKriteria1Prodi = new K9LedProdiNarasiKriteria1();
        $narasiKriteria2Prodi = new K9LedProdiNarasiKriteria2();
        $narasiKriteria3Prodi = new K9LedProdiNarasiKriteria3();
        $narasiKriteria4Prodi = new K9LedProdiNarasiKriteria4();
        $narasiKriteria5Prodi = new K9LedProdiNarasiKriteria5();
        $narasiKriteria6Prodi = new K9LedProdiNarasiKriteria6();
        $narasiKriteria7Prodi = new K9LedProdiNarasiKriteria7();
        $narasiKriteria8Prodi = new K9LedProdiNarasiKriteria8();
        $narasiKriteria9Prodi = new K9LedProdiNarasiKriteria9();


        $kriteria1Prodi->attributes = $attr;
        $kriteria2Prodi->attributes = $attr;
        $kriteria3Prodi->attributes = $attr;
        $kriteria4Prodi->attributes = $attr;
        $kriteria5Prodi->attributes = $attr;
        $kriteria6Prodi->attributes = $attr;
        $kriteria7Prodi->attributes = $attr;
        $kriteria8Prodi->attributes = $attr;
        $kriteria9Prodi->attributes = $attr;


        if (!$kriteria1Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria1Prodi->errors);
        }
        $narasiKriteria1Prodi->id_led_prodi_kriteria1 = $kriteria1Prodi->id;
        $narasiKriteria1Prodi->progress = 0;

        if (!$kriteria2Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria2Prodi->errors);
        }
        $narasiKriteria2Prodi->id_led_prodi_kriteria2 = $kriteria2Prodi->id;
        $narasiKriteria2Prodi->progress = 0;

        if (!$kriteria3Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria3Prodi->errors);
        }

        $narasiKriteria3Prodi->id_led_prodi_kriteria3 = $kriteria3Prodi->id;
        $narasiKriteria3Prodi->progress = 0;

        if (!$kriteria4Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria4Prodi->errors);
        }

        $narasiKriteria4Prodi->id_led_prodi_kriteria4 = $kriteria4Prodi->id;
        $narasiKriteria4Prodi->progress = 0;

        if (!$kriteria5Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria5Prodi->errors);
        }

        $narasiKriteria5Prodi->id_led_prodi_kriteria5 = $kriteria5Prodi->id;
        $narasiKriteria5Prodi->progress = 0;

        if (!$kriteria6Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria6Prodi->errors);
        }
        $narasiKriteria6Prodi->id_led_prodi_kriteria6 = $kriteria6Prodi->id;
        $narasiKriteria6Prodi->progress = 0;

        if (!$kriteria7Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria7Prodi->errors);
        }
        $narasiKriteria7Prodi->id_led_prodi_kriteria7 = $kriteria7Prodi->id;
        $narasiKriteria7Prodi->progress = 0;

        if (!$kriteria8Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria8Prodi->errors);
        }
        $narasiKriteria8Prodi->id_led_prodi_kriteria8 = $kriteria8Prodi->id;
        $narasiKriteria8Prodi->progress = 0;

        if (!$kriteria9Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria9Prodi->errors);
        }
        $narasiKriteria9Prodi->id_led_prodi_kriteria9 = $kriteria9Prodi->id;
        $narasiKriteria9Prodi->progress = 0;

        if (!$narasiKriteria1Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($narasiKriteria1Prodi->errors);
        }
        if (!$narasiKriteria2Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($narasiKriteria2Prodi->errors);
        }
        if (!$narasiKriteria3Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($narasiKriteria3Prodi->errors);
        }
        if (!$narasiKriteria4Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($narasiKriteria4Prodi->errors);
        }
        if (!$narasiKriteria5Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($narasiKriteria6Prodi->errors);
        }
        if (!$narasiKriteria6Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($narasiKriteria6Prodi->errors);
        }

        if (!$narasiKriteria7Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($narasiKriteria7Prodi->errors);
        }

        if (!$narasiKriteria8Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($narasiKriteria8Prodi->errors);
        }

        if (!$narasiKriteria9Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($narasiKriteria9Prodi->errors);
        }


    }


}