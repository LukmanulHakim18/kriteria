<?php


namespace admin\models;


use common\models\kriteria9\akreditasi\K9AkreditasiInstitusi;
use common\models\kriteria9\led\institusi\K9LedInstitusi;
use common\models\kriteria9\led\institusi\K9LedInstitusiKriteria1;
use common\models\kriteria9\led\institusi\K9LedInstitusiKriteria2;
use common\models\kriteria9\led\institusi\K9LedInstitusiKriteria3;
use common\models\kriteria9\led\institusi\K9LedInstitusiKriteria4;
use common\models\kriteria9\led\institusi\K9LedInstitusiKriteria5;
use common\models\kriteria9\led\institusi\K9LedInstitusiKriteria6;
use common\models\kriteria9\led\institusi\K9LedInstitusiKriteria7;
use common\models\kriteria9\led\institusi\K9LedInstitusiKriteria8;
use common\models\kriteria9\led\institusi\K9LedInstitusiKriteria9;
use common\models\kriteria9\lk\institusi\K9LkInstitusi;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria1;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria2;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria3;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria4;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria5;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria6;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria7;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria8;
use common\models\kriteria9\lk\institusi\K9LkInstitusiKriteria9;
use InvalidArgumentException;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\db\Transaction;
use yii\helpers\FileHelper;

class K9AkreditasiInstitusiForm extends Model
{

    public $id_akreditasi;
    /**
     * @var K9AkreditasiInstitusi
     */
    private $_akreditasiInstitusi;

    /**
     * @var K9LkInstitusi
     */
    private $_lk_institusi;

    /**
     * @var K9LedInstitusi
     */
    private $_led_institusi;



    public function rules()
    {
        return [
            [['id_akreditasi'],'required'],
            [['id_akreditasi'],'integer'],
        ];
    }

    public function createAkreditasi(){
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $this->_akreditasiInstitusi = new K9AkreditasiInstitusi();
            $this->_akreditasiInstitusi->progress = 0;
            $this->_akreditasiInstitusi->id_akreditasi = $this->id_akreditasi;

            $this->_akreditasiInstitusi->save();

            $this->createFolder();
            $this->createLk($transaction);
            $this->createLed($transaction);

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw new Exception($e->getMessage());
        }


        return true;
    }

    private function createFolder()
    {
        $uploadPath = Yii::$app->params['uploadPath'];
        $path = Yii::getAlias('@uploadAkreditasi');


            $replacementsProdi = [
                '{lembaga}'=>$this->_akreditasiInstitusi->akreditasi->lembaga,
                '{jenis_akreditasi}'=>$this->_akreditasiInstitusi->akreditasi->jenis_akreditasi,
                '{tahun}'=>$this->_akreditasiInstitusi->akreditasi->tahun,
                '{level}'=>'institusi',
                '{id}'=>'',
            ];

            $result = strtr($uploadPath,$replacementsProdi);

            $pathP = $path.'/'.$result;

            $pathLedSumber = $pathP . '/led/sumber';
            $pathLedPendukung = $pathP . '/led/pendukung';
            $pathLedLainnya = $pathP . '/led/lainnya';

            $pathLkSumber = $pathP . '/lk/sumber';
            $pathLkPendukung = $pathP . '/lk/pendukung';
            $pathLkLainnya = $pathP . '/lk/lainnya';


        try {
            FileHelper::createDirectory($pathLedSumber);
            FileHelper::createDirectory($pathLedPendukung);
            FileHelper::createDirectory($pathLedLainnya);
            FileHelper::createDirectory($pathLkSumber);
            FileHelper::createDirectory($pathLkPendukung);
            FileHelper::createDirectory($pathLkLainnya);
        } catch (Exception $e) {
            throw $e;
        }




    }

    /**
     * @param $transaction Transaction
     * @throws Exception
     */
    private function createLk($transaction)
    {
        $this->_lk_institusi = new K9LkInstitusi();


        $this->_lk_institusi->id_akreditasi_institusi = $this->_akreditasiInstitusi->id;
        $this->_lk_institusi->progress = 0;




        if (!$this->_lk_institusi->save(false)) {
            $transaction->rollback();
            throw new InvalidArgumentException($this->_lk_institusi->errors);

        }

        $attr = ['id_lk_institusi' => $this->_lk_institusi->id, 'progress' => 0];

        $kriteria1Institusi = new K9LkInstitusiKriteria1();
        $kriteria2Institusi = new K9LkInstitusiKriteria2();
        $kriteria3Institusi = new K9LkInstitusiKriteria3();
        $kriteria4Institusi = new K9LkInstitusiKriteria4();
        $kriteria5Institusi = new K9LkInstitusiKriteria5();
        $kriteria6Institusi = new K9LkInstitusiKriteria6();
        $kriteria7Institusi = new K9LkInstitusiKriteria7();
        $kriteria8Institusi = new K9LkInstitusiKriteria8();
        $kriteria9Institusi = new K9LkInstitusiKriteria9();


        $kriteria1Institusi->attributes = $attr;
        $kriteria2Institusi->attributes = $attr;
        $kriteria3Institusi->attributes = $attr;
        $kriteria4Institusi->attributes = $attr;
        $kriteria5Institusi->attributes = $attr;
        $kriteria6Institusi->attributes = $attr;
        $kriteria7Institusi->attributes = $attr;
        $kriteria8Institusi->attributes = $attr;
        $kriteria9Institusi->attributes = $attr;



        if (!$kriteria1Institusi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria1Institusi->errors);
        }

        if (!$kriteria2Institusi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria2Institusi->errors);
        }
        if (!$kriteria3Institusi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria3Institusi->errors);
        }

        if (!$kriteria4Institusi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria4Institusi->errors);
        }

        if (!$kriteria5Institusi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria5Institusi->errors);
        }

        if (!$kriteria6Institusi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria6Institusi->errors);
        }
        if (!$kriteria7Institusi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria7Institusi->errors);
        }
        if (!$kriteria8Institusi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria8Institusi->errors);
        }
        if (!$kriteria9Institusi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria9Institusi->errors);
        }

        $this->createFolder();


    }

    /**
     * @param $transaction Transaction
     */
    private function createLed($transaction)
    {
        $this->_led_institusi = new K9LedInstitusi();

        $this->_led_institusi->id_akreditasi_institusi = $this->_akreditasiInstitusi->id;
        $this->_led_institusi->progress = 0;


        if (!$this->_led_institusi->save(false)) {
            $transaction->rollback();
            throw new InvalidArgumentException($this->_led_institusi->errors);

        }

        $attr = ['id_led_institusi' => $this->_led_institusi->id, 'progress' => 0];

        $kriteria1Institusi = new K9LedInstitusiKriteria1();
        $kriteria2Institusi = new K9LedInstitusiKriteria2();
        $kriteria3Institusi = new K9LedInstitusiKriteria3();
        $kriteria4Institusi = new K9LedInstitusiKriteria4();
        $kriteria5Institusi = new K9LedInstitusiKriteria5();
        $kriteria6Institusi = new K9LedInstitusiKriteria6();
        $kriteria7Institusi = new K9LedInstitusiKriteria7();
        $kriteria8Institusi = new K9LedInstitusiKriteria8();
        $kriteria9Institusi = new K9LedInstitusiKriteria9();


        $kriteria1Institusi->attributes = $attr;
        $kriteria2Institusi->attributes = $attr;
        $kriteria3Institusi->attributes = $attr;
        $kriteria4Institusi->attributes = $attr;
        $kriteria5Institusi->attributes = $attr;
        $kriteria6Institusi->attributes = $attr;
        $kriteria7Institusi->attributes = $attr;
        $kriteria8Institusi->attributes = $attr;
        $kriteria9Institusi->attributes = $attr;



        if (!$kriteria1Institusi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria1Institusi->errors);
        }

        if (!$kriteria2Institusi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria2Institusi->errors);
        }
        if (!$kriteria3Institusi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria3Institusi->errors);
        }

        if (!$kriteria4Institusi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria4Institusi->errors);
        }

        if (!$kriteria5Institusi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria5Institusi->errors);
        }

        if (!$kriteria6Institusi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria6Institusi->errors);
        }
        if (!$kriteria7Institusi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria7Institusi->errors);
        }
        if (!$kriteria8Institusi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria8Institusi->errors);
        }
        if (!$kriteria9Institusi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria9Institusi->errors);
        }

    }

    public static function findOne($id){
        $model = new K9AkreditasiInstitusiForm();
        $data = K9AkreditasiInstitusi::findOne($id);
        $model->id_akreditasi = $data->id_akreditasi;
        $model->_lk_institusi = $data->k9LkInstitusis;
        $model->_led_institusi = $data->k9LedInstitusis;
        $model->_akreditasiInstitusi = $data;

        return $model;

    }
}