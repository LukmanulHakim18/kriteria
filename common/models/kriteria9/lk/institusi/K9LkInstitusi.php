<?php

namespace common\models\kriteria9\lk\institusi;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_lk_institusi".
 *
 * @property int $id
 * @property int $id_akreditasi_institusi
 * @property double $progress
 * @property int $created_at
 * @property int $updated_at
 *
 * @property K9AkreditasiInstitusi $akreditasiInstitusi
 * @property K9LkInstitusiKriteria1[] $k9LkInstitusiKriteria1s
 * @property K9LkInstitusiKriteria2[] $k9LkInstitusiKriteria2s
 * @property K9LkInstitusiKriteria3[] $k9LkInstitusiKriteria3s
 * @property K9LkInstitusiKriteria4[] $k9LkInstitusiKriteria4s
 * @property K9LkInstitusiKriteria5[] $k9LkInstitusiKriteria5s
 * @property K9LkInstitusiKriteria6[] $k9LkInstitusiKriteria6s
 * @property K9LkInstitusiKriteria7[] $k9LkInstitusiKriteria7s
 * @property K9LkInstitusiKriteria8[] $k9LkInstitusiKriteria8s
 * @property K9LkInstitusiKriteria9[] $k9LkInstitusiKriteria9s
 */
class K9LkInstitusi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_lk_institusi';
    }

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
            [['id_akreditasi_institusi', 'created_at', 'updated_at'], 'integer'],
            [['progress'], 'number'],
            [['id_akreditasi_institusi'], 'exist', 'skipOnError' => true, 'targetClass' => K9AkreditasiInstitusi::className(), 'targetAttribute' => ['id_akreditasi_institusi' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_akreditasi_institusi' => 'Id Akreditasi Institusi',
            'progress' => 'Progress',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAkreditasiInstitusi()
    {
        return $this->hasOne(K9AkreditasiInstitusi::className(), ['id' => 'id_akreditasi_institusi']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkInstitusiKriteria1s()
    {
        return $this->hasMany(K9LkInstitusiKriteria1::className(), ['id_lk_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkInstitusiKriteria2s()
    {
        return $this->hasMany(K9LkInstitusiKriteria2::className(), ['id_lk_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkInstitusiKriteria3s()
    {
        return $this->hasMany(K9LkInstitusiKriteria3::className(), ['id_lk_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkInstitusiKriteria4s()
    {
        return $this->hasMany(K9LkInstitusiKriteria4::className(), ['id_lk_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkInstitusiKriteria5s()
    {
        return $this->hasMany(K9LkInstitusiKriteria5::className(), ['id_lk_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkInstitusiKriteria6s()
    {
        return $this->hasMany(K9LkInstitusiKriteria6::className(), ['id_lk_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkInstitusiKriteria7s()
    {
        return $this->hasMany(K9LkInstitusiKriteria7::className(), ['id_lk_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkInstitusiKriteria8s()
    {
        return $this->hasMany(K9LkInstitusiKriteria8::className(), ['id_lk_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkInstitusiKriteria9s()
    {
        return $this->hasMany(K9LkInstitusiKriteria9::className(), ['id_lk_institusi' => 'id']);
    }
}
