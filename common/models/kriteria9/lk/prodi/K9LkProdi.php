<?php

namespace common\models\kriteria9\lk\prodi;

use common\models\kriteria9\akreditasi\K9AkreditasiProdi;
use Yii;
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
 * @property K9LkProdiKriteria1[] $k9LkProdiKriteria1s
 * @property K9LkProdiKriteria2[] $k9LkProdiKriteria2s
 * @property K9LkProdiKriteria3[] $k9LkProdiKriteria3s
 * @property K9LkProdiKriteria4[] $k9LkProdiKriteria4s
 * @property K9LkProdiKriteria5[] $k9LkProdiKriteria5s
 * @property K9LkProdiKriteria6[] $k9LkProdiKriteria6s
 * @property K9LkProdiKriteria7[] $k9LkProdiKriteria7s
 * @property K9LkProdiKriteria8[] $k9LkProdiKriteria8s
 * @property K9LkProdiKriteria9[] $k9LkProdiKriteria9s
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
        return $this->hasMany(K9LkProdiKriteria1::className(), ['id_lk_prodi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkProdiKriteria2s()
    {
        return $this->hasMany(K9LkProdiKriteria2::className(), ['id_lk_prodi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkProdiKriteria3s()
    {
        return $this->hasMany(K9LkProdiKriteria3::className(), ['id_lk_prodi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkProdiKriteria4s()
    {
        return $this->hasMany(K9LkProdiKriteria4::className(), ['id_lk_prodi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkProdiKriteria5s()
    {
        return $this->hasMany(K9LkProdiKriteria5::className(), ['id_lk_prodi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkProdiKriteria6s()
    {
        return $this->hasMany(K9LkProdiKriteria6::className(), ['id_lk_prodi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkProdiKriteria7s()
    {
        return $this->hasMany(K9LkProdiKriteria7::className(), ['id_lk_prodi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkProdiKriteria8s()
    {
        return $this->hasMany(K9LkProdiKriteria8::className(), ['id_lk_prodi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkProdiKriteria9s()
    {
        return $this->hasMany(K9LkProdiKriteria9::className(), ['id_lk_prodi' => 'id']);
    }
}
