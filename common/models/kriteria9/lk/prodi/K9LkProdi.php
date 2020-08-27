<?php

namespace common\models\kriteria9\lk\prodi;

use common\models\kriteria9\akreditasi\K9AkreditasiProdi;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_lk_prodi".
 *
 * @property int $id
 * @property int $id_akreditasi_prodi
 * @property double $progress
 * @property int $created_at
 * @property int $updated_at
 *
 * @property K9AkreditasiProdi $akreditasiProdi
 * @property K9LkProdiKriteria1Narasi $k9LkProdiKriteria1s
 * @property K9LkProdiKriteria2Narasi $k9LkProdiKriteria2s
 * @property K9LkProdiKriteria3Narasi $k9LkProdiKriteria3s
 * @property K9LkProdiKriteria4Narasi $k9LkProdiKriteria4s
 * @property K9LkProdiKriteria5Narasi $k9LkProdiKriteria5s
 * @property K9LkProdiKriteria6Narasi $k9LkProdiKriteria6s
 * @property K9LkProdiKriteria7Narasi $k9LkProdiKriteria7s
 * @property K9LkProdiKriteria8Narasi $k9LkProdiKriteria8s
 */
class K9LkProdi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_lk_prodi';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_akreditasi_prodi', 'created_at', 'updated_at'], 'integer'],
            [['progress'], 'number'],
            [['id_akreditasi_prodi'], 'exist', 'skipOnError' => true, 'targetClass' => K9AkreditasiProdi::className(), 'targetAttribute' => ['id_akreditasi_prodi' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_akreditasi_prodi' => 'Id Akreditasi Prodi',
            'progress' => 'Progress',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAkreditasiProdi()
    {
        return $this->hasOne(K9AkreditasiProdi::className(), ['id' => 'id_akreditasi_prodi']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkProdiKriteria1s()
    {
        return $this->hasOne(K9LkProdiKriteria1Narasi::className(), ['id_lk_prodi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkProdiKriteria2s()
    {
        return $this->hasOne(K9LkProdiKriteria2Narasi::className(), ['id_lk_prodi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkProdiKriteria3s()
    {
        return $this->hasOne(K9LkProdiKriteria3Narasi::className(), ['id_lk_prodi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkProdiKriteria4s()
    {
        return $this->hasOne(K9LkProdiKriteria4Narasi::className(), ['id_lk_prodi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkProdiKriteria5s()
    {
        return $this->hasOne(K9LkProdiKriteria5Narasi::className(), ['id_lk_prodi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkProdiKriteria6s()
    {
        return $this->hasOne(K9LkProdiKriteria6Narasi::className(), ['id_lk_prodi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkProdiKriteria7s()
    {
        return $this->hasOne(K9LkProdiKriteria7Narasi::className(), ['id_lk_prodi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkProdiKriteria8s()
    {
        return $this->hasOne(K9LkProdiKriteria8Narasi::className(), ['id_lk_prodi' => 'id']);
    }


    public function updateProgress()
    {
        $kriteria1 = $this->k9LkProdiKriteria1s->progress;
        $kriteria2 = $this->k9LkProdiKriteria2s->progress;
        $kriteria3 = $this->k9LkProdiKriteria3s->progress;
        $kriteria4 = $this->k9LkProdiKriteria4s->progress;
        $kriteria5 = $this->k9LkProdiKriteria5s->progress;
        $kriteria6 = $this->k9LkProdiKriteria6s->progress;
        $kriteria7 = $this->k9LkProdiKriteria7s->progress;
        $kriteria8 = $this->k9LkProdiKriteria8s->progress;
        $progress = round((($kriteria1 + $kriteria2 + $kriteria3 + $kriteria4 + $kriteria5 + $kriteria6 + $kriteria7 + $kriteria8) / 8), 2);
        $this->progress = $progress;

        $this->save(false);
    }
}
