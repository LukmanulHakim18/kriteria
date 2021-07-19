<?php

namespace common\models\kriteria9\akreditasi;

use common\models\kriteria9\kuantitatif\institusi\K9DataKuantitatifInstitusi;
use common\models\kriteria9\led\institusi\K9LedInstitusi;
use common\models\kriteria9\lk\institusi\K9LkInstitusi;
use common\models\kriteria9\penilaian\institusi\K9PenilaianInstitusiAnalisis;
use common\models\kriteria9\penilaian\institusi\K9PenilaianInstitusiEksternal;
use common\models\kriteria9\penilaian\institusi\K9PenilaianInstitusiKriteria;
use common\models\kriteria9\penilaian\institusi\K9PenilaianInstitusiProfil;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_akreditasi_institusi".
 *
 * @property int $id
 * @property int $id_akreditasi
 * @property int $created_at
 * @property int $updated_at
 * @property double $progress
 * @property int $skor
 *
 * @property K9Akreditasi $akreditasi
 * @property K9LedInstitusi $k9LedInstitusi
 * @property K9LkInstitusi $k9LkInstitusi
 * @property K9DataKuantitatifInstitusi $kuantitatif
 * @property K9PenilaianInstitusiEksternal $penilaianEksternal
 * @property K9PenilaianInstitusiProfil $penilaianProfil
 * @property K9PenilaianInstitusiKriteria $penilaianKriteria
 * @property K9PenilaianInstitusiAnalisis $penilaianAnalisis
 */
class K9AkreditasiInstitusi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_akreditasi' => 'Id Akreditasi',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'progress' => 'Progress',
            'skor' => 'Skor'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_akreditasi', 'created_at', 'updated_at', 'skor'], 'integer'],
            [['progress'], 'number'],
            [
                ['id_akreditasi'],
                'exist',
                'skipOnError' => true,
                'targetClass' => K9Akreditasi::className(),
                'targetAttribute' => ['id_akreditasi' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_akreditasi_institusi';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAkreditasi()
    {
        return $this->hasOne(K9Akreditasi::className(), ['id' => 'id_akreditasi']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LedInstitusi()
    {
        return $this->hasOne(K9LedInstitusi::className(), ['id_akreditasi_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkInstitusi()
    {
        return $this->hasOne(K9LkInstitusi::className(), ['id_akreditasi_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKuantitatif()
    {
        return $this->hasOne(K9DataKuantitatifInstitusi::class, ['id_akreditasi_institusi' => 'id']);
    }

    public function updateProgress()
    {
        $led = $this->k9LedInstitusi->progress;
        $lk = $this->k9LkInstitusi->progress;

        $progress = round((($led + $lk) / 2), 2);
        $this->progress = $progress;
        return $this;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPenilaianEksternal()
    {
        return $this->hasOne(K9PenilaianInstitusiEksternal::class, ['id_akreditasi_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPenilaianProfil()
    {
        return $this->hasOne(K9PenilaianInstitusiProfil::class, ['id_akreditasi_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPenilaianKriteria()
    {
        return $this->hasOne(K9PenilaianInstitusiKriteria::class, ['id_akreditasi_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPenilaianAnalisis()
    {
        return $this->hasOne(K9PenilaianInstitusiAnalisis::class, ['id_akreditasi_institusi' => 'id']);
    }

    public function updateSkor()
    {
        $eksternal = $this->penilaianEksternal;
        $profil = $this->penilaianProfil;
        $kriteria = $this->penilaianKriteria;
        $analisis = $this->penilaianAnalisis;
        $skor = $eksternal->total + $profil->total + $kriteria->total + $analisis->total;
        $this->skor = $skor;
        $this->save(false);
    }
}
