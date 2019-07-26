<?php

namespace common\models\kriteria9\led\institusi;

use common\models\kriteria9\akreditasi\K9AkreditasiInstitusi;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_led_institusi".
 *
 * @property int $id
 * @property int $id_akreditasi_institusi
 * @property double $progress
 * @property int $created_at
 * @property int $updated_at
 *
 * @property K9AkreditasiInstitusi $akreditasiInstitusi
 * @property K9LedInstitusiKriteria1[] $k9LedInstitusiKriteria1s
 * @property K9LedInstitusiKriteria2[] $k9LedInstitusiKriteria2s
 * @property K9LedInstitusiKriteria3[] $k9LedInstitusiKriteria3s
 * @property K9LedInstitusiKriteria4[] $k9LedInstitusiKriteria4s
 * @property K9LedInstitusiKriteria5[] $k9LedInstitusiKriteria5s
 * @property K9LedInstitusiKriteria6[] $k9LedInstitusiKriteria6s
 * @property K9LedInstitusiKriteria7[] $k9LedInstitusiKriteria7s
 * @property K9LedInstitusiKriteria8[] $k9LedInstitusiKriteria8s
 * @property K9LedInstitusiKriteria9[] $k9LedInstitusiKriteria9s
 */
class K9LedInstitusi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_led_institusi';
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
    public function getK9LedInstitusiKriteria1s()
    {
        return $this->hasMany(K9LedInstitusiKriteria1::className(), ['id_led_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LedInstitusiKriteria2s()
    {
        return $this->hasMany(K9LedInstitusiKriteria2::className(), ['id_led_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LedInstitusiKriteria3s()
    {
        return $this->hasMany(K9LedInstitusiKriteria3::className(), ['id_led_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LedInstitusiKriteria4s()
    {
        return $this->hasMany(K9LedInstitusiKriteria4::className(), ['id_led_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LedInstitusiKriteria5s()
    {
        return $this->hasMany(K9LedInstitusiKriteria5::className(), ['id_led_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LedInstitusiKriteria6s()
    {
        return $this->hasMany(K9LedInstitusiKriteria6::className(), ['id_led_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LedInstitusiKriteria7s()
    {
        return $this->hasMany(K9LedInstitusiKriteria7::className(), ['id_led_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LedInstitusiKriteria8s()
    {
        return $this->hasMany(K9LedInstitusiKriteria8::className(), ['id_led_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LedInstitusiKriteria9s()
    {
        return $this->hasMany(K9LedInstitusiKriteria9::className(), ['id_led_institusi' => 'id']);
    }
}
