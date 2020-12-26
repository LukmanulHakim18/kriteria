<?php


namespace admin\models;

use common\helpers\kriteria9\K9InstitusiJsonHelper;
use common\helpers\NomorKriteriaHelper;
use common\models\kriteria9\akreditasi\K9AkreditasiInstitusi;
use common\models\kriteria9\led\institusi\K9LedInstitusi;
use common\models\kriteria9\led\institusi\K9LedInstitusiNarasiAnalisis;
use common\models\kriteria9\led\institusi\K9LedInstitusiNarasiKondisiEksternal;
use common\models\kriteria9\led\institusi\K9LedInstitusiNarasiProfilInstitusi;
use common\models\kriteria9\lk\institusi\K9LkInstitusi;
use common\models\kriteria9\penilaian\institusi\K9PenilaianInstitusiAnalisis;
use common\models\kriteria9\penilaian\institusi\K9PenilaianInstitusiEksternal;
use common\models\kriteria9\penilaian\institusi\K9PenilaianInstitusiKriteria;
use common\models\kriteria9\penilaian\institusi\K9PenilaianInstitusiProfil;
use common\models\ProfilInstitusi;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\ArrayHelper;
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

    private $_profilInstitusi;

    public static function findOne($id)
    {
        $model = new K9AkreditasiInstitusiForm();
        $data = K9AkreditasiInstitusi::findOne($id);
        $model->id_akreditasi = $data->id_akreditasi;
        $model->_lk_institusi = $data->k9LkInstitusis;
        $model->_led_institusi = $data->k9LedInstitusis;
        $model->_akreditasiInstitusi = $data;


        return $model;
    }

    public function rules()
    {
        return [
            [['id_akreditasi'], 'required'],
            [['id_akreditasi'], 'integer'],
        ];
    }

    public function createAkreditasi()
    {
        $profil = ProfilInstitusi::find()->all();
        $this->_profilInstitusi = ArrayHelper::map($profil, 'nama', 'isi');
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $this->_akreditasiInstitusi = new K9AkreditasiInstitusi();
            $this->_akreditasiInstitusi->progress = 0;
            $this->_akreditasiInstitusi->id_akreditasi = $this->id_akreditasi;

            $this->_akreditasiInstitusi->save();

            $this->createFolder();
            $this->createLk();
            $this->createLed();
            $this->createPenilaian();

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


        $replacementInstitusi = [
            '{lembaga}' => $this->_akreditasiInstitusi->akreditasi->lembaga,
            '{jenis_akreditasi}' => $this->_akreditasiInstitusi->akreditasi->jenis_akreditasi,
            '{tahun}' => $this->_akreditasiInstitusi->akreditasi->tahun,
            '{level}' => 'institusi',
            '{id}' => '',
        ];

        $result = strtr($uploadPath, $replacementInstitusi);

        $pathP = $path . '/' . $result;

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

    private function createLk()
    {
        $this->_lk_institusi = new K9LkInstitusi();


        $this->_lk_institusi->id_akreditasi_institusi = $this->_akreditasiInstitusi->id;
        $this->_lk_institusi->progress = 0;


        $this->_lk_institusi->save(false);
        $json = K9InstitusiJsonHelper::getAllJsonLk($this->_profilInstitusi['jenis']);

        foreach ($json as /** @var Lk $kriteria */ $kriteria) {
            $kritClass = 'common\\models\\kriteria9\\lk\\institusi\\K9LkInstitusiKriteria' . $kriteria->kriteria;
            $kritModel = new $kritClass;
            $kritModel->setAttributes([
                'id_lk_institusi' => $this->_lk_institusi->id,
                'progress_narasi' => 0,
                'progress_dokumen' => 0
            ]);

            $kritModel->save(false);


            $class = 'common\\models\\kriteria9\\lk\\institusi\\K9LkInstitusiKriteria' . $kriteria->kriteria . 'Narasi';
            $attr = ['id_lk_institusi_kriteria' . $kriteria->kriteria => $kritModel->id, 'progress' => 0];

            $kriteriaInstitusi = new $class;
            $kriteriaInstitusi->setAttributes($attr);
            foreach ($kriteria->butir as $key => /** @var TabelLk */ $item) {
                $modelAttribute = NomorKriteriaHelper::changeToDbFormat($item->tabel);
                $kriteriaInstitusi->$modelAttribute = $item->template;
            }

            $kriteriaInstitusi->save();
        }
    }

    private function createLed()
    {
        $this->_led_institusi = new K9LedInstitusi();

        $this->_led_institusi->id_akreditasi_institusi = $this->_akreditasiInstitusi->id;
        $this->_led_institusi->progress = 0;


        $this->_led_institusi->save(false);

        $attr = ['id_led_institusi' => $this->_led_institusi->id, 'progress' => 0];

        for ($i = 1; $i <= 9; $i++) {
            $kriteria_class_path = 'common\\models\\kriteria9\\led\\institusi\\K9LedInstitusiKriteria' . $i;
            $kriteria_narasi_class_path = 'common\\models\\kriteria9\\led\\institusi\\K9LedInstitusiNarasiKriteria' . $i;

            $kriteriaInstitusi = new $kriteria_class_path;
            $kriteriaInstitusi->attributes = $attr;
            $kriteriaInstitusi->save();

            $narasi_attr = 'id_led_institusi_kriteria' . $i;
            $narasiKriteriaInstitusi = new $kriteria_narasi_class_path;
            $narasiKriteriaInstitusi->$narasi_attr = $kriteriaInstitusi->id;
            $narasiKriteriaInstitusi->progress = 0;

            $narasiKriteriaInstitusi->save();
        }

        $kondisiEksternal = new K9LedInstitusiNarasiKondisiEksternal();
        $profil = new K9LedInstitusiNarasiProfilInstitusi();
        $analisis = new K9LedInstitusiNarasiAnalisis();

        $kondisiEksternal->id_led_institusi = $this->_led_institusi->id;
        $kondisiEksternal->progress = 0;

        $profil->id_led_institusi = $this->_led_institusi->id;
        $profil->progress = 0;

        $analisis->id_led_institusi = $this->_led_institusi->id;
        $analisis->progress = 0;

        $kondisiEksternal->save();
        $profil->save();
        $analisis->save();
    }

    private function createPenilaian()
    {
        $eksternal = new K9PenilaianInstitusiEksternal();
        $profil = new K9PenilaianInstitusiProfil();
        $kriteria = new K9PenilaianInstitusiKriteria();
        $analisis = new K9PenilaianInstitusiAnalisis();

        $attr = [
            'id_akreditasi_institusi' => $this->_akreditasiInstitusi->id,
            'status' => 'ready'
        ];

        $eksternal->setAttributes($attr);
        $profil->setAttributes($attr);
        $kriteria->setAttributes($attr);
        $analisis->setAttributes($attr);

        $eksternal->save(false);
        $profil->save(false);
        $kriteria->save(false);
        $analisis->save(false);
    }
}
