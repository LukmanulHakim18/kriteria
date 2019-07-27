<?php


namespace admin\models;


use common\models\kriteria9\akreditasi\K9AkreditasiProdi;
use common\models\kriteria9\led\fakultas\K9LedFakultas;
use common\models\kriteria9\led\fakultas\K9LedFakultasKriteria1;
use common\models\kriteria9\led\fakultas\K9LedFakultasKriteria2;
use common\models\kriteria9\led\fakultas\K9LedFakultasKriteria3;
use common\models\kriteria9\led\fakultas\K9LedFakultasKriteria4;
use common\models\kriteria9\led\fakultas\K9LedFakultasKriteria5;
use common\models\kriteria9\led\fakultas\K9LedFakultasKriteria6;
use common\models\kriteria9\led\fakultas\K9LedFakultasKriteria7;
use common\models\kriteria9\led\fakultas\K9LedFakultasKriteria8;
use common\models\kriteria9\led\fakultas\K9LedFakultasKriteria9;
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
use common\models\kriteria9\lk\fakultas\K9LkFakultas;
use common\models\kriteria9\lk\fakultas\K9LkFakultasKriteria1;
use common\models\kriteria9\lk\fakultas\K9LkFakultasKriteria2;
use common\models\kriteria9\lk\fakultas\K9LkFakultasKriteria3;
use common\models\kriteria9\lk\fakultas\K9LkFakultasKriteria4;
use common\models\kriteria9\lk\fakultas\K9LkFakultasKriteria5;
use common\models\kriteria9\lk\fakultas\K9LkFakultasKriteria6;
use common\models\kriteria9\lk\fakultas\K9LkFakultasKriteria7;
use common\models\kriteria9\lk\fakultas\K9LkFakultasKriteria8;
use common\models\kriteria9\lk\fakultas\K9LkFakultasKriteria9;
use common\models\kriteria9\lk\prodi\K9LkProdi;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria1;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria2;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria3;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria4;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria5;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria6;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria7;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria8;
use common\models\kriteria9\lk\prodi\K9LkProdiKriteria9;
use Exception;
use InvalidArgumentException;
use RuntimeException;
use Yii;
use yii\base\Model;
use yii\db\Transaction;
use yii\helpers\FileHelper;

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

    /**
     * @var K9LedFakultas
     */
    private $_led_fakultas;
    /**
     * @var K9LkFakultas
     */
    private $_lk_fakultas;


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


    private function createFolder($params)
    {
        $uploadPath = Yii::$app->params['uploadPath'];
        $path = Yii::getAlias('@uploadAkreditasi');


        if($params === 'prodi'){
            $replacementsProdi = [
                '{lembaga}'=>$this->_akreditasiProdi->akreditasi->lembaga,
                '{jenis_akreditasi}'=>$this->_akreditasiProdi->akreditasi->jenis_akreditasi,
                '{tahun}'=>$this->_akreditasiProdi->akreditasi->tahun,
                '{level}'=>'prodi',
                '{id}'=>$this->_akreditasiProdi->id_prodi,
            ];

            $resultProdi = strtr($uploadPath,$replacementsProdi);

            $pathP = $path.'/'.$resultProdi;

            $pathLedSumber = $pathP . '/led/sumber';
            $pathLedPendukung = $pathP . '/led/pendukung';
            $pathLedLainnya = $pathP . '/led/lainnya';

            $pathLkSumber = $pathP . '/lk/sumber';
            $pathLkPendukung = $pathP . '/lk/pendukung';
            $pathLkLainnya = $pathP . '/lk/lainnya';


            FileHelper::createDirectory($pathLedSumber);
            FileHelper::createDirectory($pathLedPendukung);
            FileHelper::createDirectory($pathLedLainnya);
            FileHelper::createDirectory($pathLkSumber);
            FileHelper::createDirectory($pathLkPendukung);
            FileHelper::createDirectory($pathLkLainnya);

        }
        elseif($params === 'fakultas'){
            $replacementsFakultas = [
                '{lembaga}'=>$this->_akreditasiProdi->akreditasi->lembaga,
                '{jenis_akreditasi}'=>$this->_akreditasiProdi->akreditasi->jenis_akreditasi,
                '{tahun}'=>$this->_akreditasiProdi->akreditasi->tahun,
                '{level}'=>'fakultas',
                '{id}'=>$this->_akreditasiProdi->prodi->id_fakultas_akademi,
            ];

            $resultFakultas = strtr($uploadPath,$replacementsFakultas);

            $pathF = $path.'/'.$resultFakultas;
            $pathFLedSumber = $pathF . '/led/sumber';
            $pathFLedPendukung = $pathF . '/led/pendukung';
            $pathFLedLainnya = $pathF . '/led/lainnya';

            $pathFLkSumber = $pathF . '/lk/sumber';
            $pathFLkPendukung = $pathF . '/lk/pendukung';
            $pathFLkLainnya = $pathF . '/lk/lainnya';

            FileHelper::createDirectory($pathFLedSumber);
            FileHelper::createDirectory($pathFLedPendukung);
            FileHelper::createDirectory($pathFLedLainnya);
            FileHelper::createDirectory($pathFLkSumber);
            FileHelper::createDirectory($pathFLkPendukung);
            FileHelper::createDirectory($pathFLkLainnya);

        }






    }

    /**
     * @param $transaction Transaction
     */
    private function createLk($transaction)
    {
        $this->_lk_prodi = new K9LkProdi();


        $this->_lk_prodi->id_akreditasi_prodi = $this->_akreditasiProdi->id;
        $this->_lk_prodi->progress = 0;


        $cekFakultas = K9LkFakultas::find()->where(['id_akreditasi' => $this->id_akreditasi, 'id_fakultas' => $this->_akreditasiProdi->prodi->id_fakultas_akademi])->all();
        if (empty($cekFakultas)) {
            $this->_lk_fakultas = new K9LkFakultas();
            $this->_lk_fakultas->id_akreditasi = $this->id_akreditasi;
            $this->_lk_fakultas->id_fakultas = $this->_akreditasiProdi->prodi->id_fakultas_akademi;
            $this->_lk_fakultas->progress = 0;
            if (!$this->_lk_fakultas->save(false)) {
                $transaction->rollBack();
                throw new InvalidArgumentException($this->_lk_fakultas->errors);
            }

            $attr = ['id_lk_fakultas' => $this->_lk_fakultas->id, 'progress' => 0];

            $kriteria1Fakultas = new K9LkFakultasKriteria1();
            $kriteria2Fakultas = new K9LkFakultasKriteria2();
            $kriteria3Fakultas = new K9LkFakultasKriteria3();
            $kriteria4Fakultas = new K9LkFakultasKriteria4();
            $kriteria5Fakultas = new K9LkFakultasKriteria5();
            $kriteria6Fakultas = new K9LkFakultasKriteria6();
            $kriteria7Fakultas = new K9LkFakultasKriteria7();
            $kriteria8Fakultas = new K9LkFakultasKriteria8();
            $kriteria9Fakultas = new K9LkFakultasKriteria9();


            $kriteria1Fakultas->attributes = $attr;
            $kriteria2Fakultas->attributes = $attr;
            $kriteria3Fakultas->attributes = $attr;
            $kriteria4Fakultas->attributes = $attr;
            $kriteria5Fakultas->attributes = $attr;
            $kriteria6Fakultas->attributes = $attr;
            $kriteria7Fakultas->attributes = $attr;
            $kriteria8Fakultas->attributes = $attr;
            $kriteria9Fakultas->attributes = $attr;


            if (!$kriteria1Fakultas->save()) {
                $transaction->rollBack();
                throw new InvalidArgumentException($kriteria1Fakultas->errors);
            }
            if (!$kriteria2Fakultas->save()) {
                $transaction->rollBack();
                throw new InvalidArgumentException($kriteria2Fakultas->errors);
            }
            if (!$kriteria3Fakultas->save()) {
                $transaction->rollBack();
                throw new InvalidArgumentException($kriteria3Fakultas->errors);
            }
            if (!$kriteria4Fakultas->save()) {
                $transaction->rollBack();
                throw new InvalidArgumentException($kriteria4Fakultas->errors);
            }
            if (!$kriteria5Fakultas->save()) {
                $transaction->rollBack();
                throw new InvalidArgumentException($kriteria5Fakultas->errors);
            }
            if (!$kriteria6Fakultas->save()) {
                $transaction->rollBack();
                throw new InvalidArgumentException($kriteria6Fakultas->errors);
            }
            if (!$kriteria7Fakultas->save()) {
                $transaction->rollBack();
                throw new InvalidArgumentException($kriteria7Fakultas->errors);
            }

            if (!$kriteria8Fakultas->save()) {
                $transaction->rollBack();
                throw new InvalidArgumentException($kriteria8Fakultas->errors);
            }

            if (!$kriteria9Fakultas->save()) {
                $transaction->rollBack();
                throw new InvalidArgumentException($kriteria9Fakultas->errors);
            }

            $this->createFolder('fakultas');

        }


        if (!$this->_lk_prodi->save(false)) {
            $transaction->rollback();
            throw new InvalidArgumentException($this->_lk_prodi->errors);

        }

        $attr = ['id_lk_prodi' => $this->_lk_prodi->id, 'progress' => 0];

        $kriteria1Prodi = new K9LkProdiKriteria1();
        $kriteria2Prodi = new K9LkProdiKriteria2();
        $kriteria3Prodi = new K9LkProdiKriteria3();
        $kriteria4Prodi = new K9LkProdiKriteria4();
        $kriteria5Prodi = new K9LkProdiKriteria5();
        $kriteria6Prodi = new K9LkProdiKriteria6();
        $kriteria7Prodi = new K9LkProdiKriteria7();
        $kriteria8Prodi = new K9LkProdiKriteria8();
        $kriteria9Prodi = new K9LkProdiKriteria9();


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

        if (!$kriteria2Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria2Prodi->errors);
        }
        if (!$kriteria3Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria3Prodi->errors);
        }

        if (!$kriteria4Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria4Prodi->errors);
        }

        if (!$kriteria5Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria5Prodi->errors);
        }

        if (!$kriteria6Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria6Prodi->errors);
        }
        if (!$kriteria7Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria7Prodi->errors);
        }
        if (!$kriteria8Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria8Prodi->errors);
        }
        if (!$kriteria9Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria9Prodi->errors);
        }

        $this->createFolder('prodi');


    }

    /**
     * @param $transaction Transaction
     */
    private function createLed($transaction)
    {
        $this->_led_prodi = new K9LedProdi();


        $this->_led_prodi->id_akreditasi_prodi = $this->_akreditasiProdi->id;
        $this->_led_prodi->progress = 0;


        $cekFakultas = K9LedFakultas::find()->where(['id_akreditasi' => $this->id_akreditasi, 'id_fakultas' => $this->_akreditasiProdi->prodi->id_fakultas_akademi])->all();
        if (empty($cekFakultas)) {
            $this->_led_fakultas = new K9LedFakultas();
            $this->_led_fakultas->id_akreditasi = $this->id_akreditasi;
            $this->_led_fakultas->id_fakultas = $this->_akreditasiProdi->prodi->id_fakultas_akademi;
            $this->_led_fakultas->progress = 0;
            if (!$this->_led_fakultas->save(false)) {
                $transaction->rollBack();
                throw new InvalidArgumentException($this->_led_fakultas->errors);
            }

            $attr = ['id_led_fakultas' => $this->_led_fakultas->id, 'progress' => 0];

            $kriteria1Fakultas = new K9LedFakultasKriteria1();
            $kriteria2Fakultas = new K9LedFakultasKriteria2();
            $kriteria3Fakultas = new K9LedFakultasKriteria3();
            $kriteria4Fakultas = new K9LedFakultasKriteria4();
            $kriteria5Fakultas = new K9LedFakultasKriteria5();
            $kriteria6Fakultas = new K9LedFakultasKriteria6();
            $kriteria7Fakultas = new K9LedFakultasKriteria7();
            $kriteria8Fakultas = new K9LedFakultasKriteria8();
            $kriteria9Fakultas = new K9LedFakultasKriteria9();


            $kriteria1Fakultas->attributes = $attr;
            $kriteria2Fakultas->attributes = $attr;
            $kriteria3Fakultas->attributes = $attr;
            $kriteria4Fakultas->attributes = $attr;
            $kriteria5Fakultas->attributes = $attr;
            $kriteria6Fakultas->attributes = $attr;
            $kriteria7Fakultas->attributes = $attr;
            $kriteria8Fakultas->attributes = $attr;
            $kriteria9Fakultas->attributes = $attr;


            if (!$kriteria1Fakultas->save()) {
                $transaction->rollBack();
                throw new InvalidArgumentException($kriteria1Fakultas->errors);
            }
            if (!$kriteria2Fakultas->save()) {
                $transaction->rollBack();
                throw new InvalidArgumentException($kriteria2Fakultas->errors);
            }
            if (!$kriteria3Fakultas->save()) {
                $transaction->rollBack();
                throw new InvalidArgumentException($kriteria3Fakultas->errors);
            }
            if (!$kriteria4Fakultas->save()) {
                $transaction->rollBack();
                throw new InvalidArgumentException($kriteria4Fakultas->errors);
            }
            if (!$kriteria5Fakultas->save()) {
                $transaction->rollBack();
                throw new InvalidArgumentException($kriteria5Fakultas->errors);
            }
            if (!$kriteria6Fakultas->save()) {
                $transaction->rollBack();
                throw new InvalidArgumentException($kriteria6Fakultas->errors);
            }
            if (!$kriteria7Fakultas->save()) {
                $transaction->rollBack();
                throw new InvalidArgumentException($kriteria7Fakultas->errors);
            }

            if (!$kriteria8Fakultas->save()) {
                $transaction->rollBack();
                throw new InvalidArgumentException($kriteria7Fakultas->errors);
            }

            if (!$kriteria9Fakultas->save()) {
                $transaction->rollBack();
                throw new InvalidArgumentException($kriteria7Fakultas->errors);
            }

        }


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

        if (!$kriteria2Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria2Prodi->errors);
        }
        if (!$kriteria3Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria3Prodi->errors);
        }

        if (!$kriteria4Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria4Prodi->errors);
        }

        if (!$kriteria5Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria5Prodi->errors);
        }

        if (!$kriteria6Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria6Prodi->errors);
        }
        if (!$kriteria7Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria7Prodi->errors);
        }
        if (!$kriteria8Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria7Prodi->errors);
        }
        if (!$kriteria9Prodi->save()) {
            $transaction->rollBack();
            throw new InvalidArgumentException($kriteria7Prodi->errors);
        }




    }

    public static function findOne($id)
    {

        $model = new K9AkreditasiProdiForm();
        $data = K9AkreditasiProdi::findOne($id);
        $id_akreditasi = $data->id_akreditasi;

        $model->id_prodi = $data->id_prodi;
        $model->id_akreditasi = $data->id_akreditasi;
        $model->_lk_prodi = $data->k9LkProdis;
        $model->_lk_fakultas = K9LkFakultas::findOne(['id_akreditasi' => $id_akreditasi]);
        $model->_led_prodi = $data->k9LedProdis;
        $model->_led_fakultas = K9LedFakultas::findOne(['id_akreditasi' => $id_akreditasi]);

        return $model;
    }


}