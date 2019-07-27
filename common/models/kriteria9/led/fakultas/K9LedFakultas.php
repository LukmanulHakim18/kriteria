<?php

namespace common\models\kriteria9\led\fakultas;

use common\models\FakultasAkademi;
use common\models\kriteria9\akreditasi\K9Akreditasi;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_led_fakultas".
 *
 * @property int $id
 * @property int $id_akreditasi
 * @property int $id_fakultas
 * @property double $progress
 * @property int $created_at
 * @property int $updated_at
 *
 * @property K9Akreditasi $akreditasi
 * @property FakultasAkademi $fakultas
 * @property K9LedFakultasKriteria1[] $k9LedFakultasKriteria1s
 * @property K9LedFakultasKriteria2[] $k9LedFakultasKriteria2s
 * @property K9LedFakultasKriteria3[] $k9LedFakultasKriteria3s
 * @property K9LedFakultasKriteria4[] $k9LedFakultasKriteria4s
 * @property K9LedFakultasKriteria5[] $k9LedFakultasKriteria5s
 * @property K9LedFakultasKriteria6[] $k9LedFakultasKriteria6s
 * @property K9LedFakultasKriteria7[] $k9LedFakultasKriteria7s
 * @property K9LedFakultasKriteria8[] $k9LedFakultasKriteria8s
 * @property K9LedFakultasKriteria9[] $k9LedFakultasKriteria9s
 */
class K9LedFakultas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_led_fakultas';
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
            [['id_akreditasi', 'id_fakultas', 'created_at', 'updated_at'], 'integer'],
            [['progress'], 'number'],
            [['id_akreditasi'], 'exist', 'skipOnError' => true, 'targetClass' => K9Akreditasi::className(), 'targetAttribute' => ['id_akreditasi' => 'id']],
            [['id_akreditasi'], 'exist', 'skipOnError' => true, 'targetClass' => FakultasAkademi::className(), 'targetAttribute' => ['id_akreditasi' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_akreditasi' => 'Id Akreditasi',
            'id_fakultas' => 'Id Fakultas',
            'progress' => 'Progress',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
    public function getFakultas()
    {
        return $this->hasOne(FakultasAkademi::className(), ['id' => 'id_fakultas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LedFakultasKriteria1s()
    {
        return $this->hasMany(K9LedFakultasKriteria1::className(), ['id_led_fakultas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LedFakultasKriteria2s()
    {
        return $this->hasMany(K9LedFakultasKriteria2::className(), ['id_led_fakultas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LedFakultasKriteria3s()
    {
        return $this->hasMany(K9LedFakultasKriteria3::className(), ['id_led_fakultas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LedFakultasKriteria4s()
    {
        return $this->hasMany(K9LedFakultasKriteria4::className(), ['id_led_fakultas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LedFakultasKriteria5s()
    {
        return $this->hasMany(K9LedFakultasKriteria5::className(), ['id_led_fakultas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LedFakultasKriteria6s()
    {
        return $this->hasMany(K9LedFakultasKriteria6::className(), ['id_led_fakultas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LedFakultasKriteria7s()
    {
        return $this->hasMany(K9LedFakultasKriteria7::className(), ['id_led_fakultas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LedFakultasKriteria8s()
    {
        return $this->hasMany(K9LedFakultasKriteria8::className(), ['id_led_fakultas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LedFakultasKriteria9s()
    {
        return $this->hasMany(K9LedFakultasKriteria9::className(), ['id_led_fakultas' => 'id']);
    }
}
