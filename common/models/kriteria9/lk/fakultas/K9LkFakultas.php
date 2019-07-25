<?php

namespace common\models\kriteria9\lk\fakultas;

use common\models\FakultasAkademi;
use common\models\kriteria9\akreditasi\K9Akreditasi;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_lk_fakultas".
 *
 * @property int $id
 * @property int $id_akreditasi
 * @property int $id_fakultas
 * @property double $progress
 * @property int $created_at
 * @property int $updated_at
 *
 * @property FakultasAkademi $fakultas
 * @property K9Akreditasi $akreditasi
 * @property K9LkFakultasKriteria1[] $k9LkFakultasKriteria1s
 * @property K9LkFakultasKriteria2[] $k9LkFakultasKriteria2s
 * @property K9LkFakultasKriteria3[] $k9LkFakultasKriteria3s
 * @property K9LkFakultasKriteria4[] $k9LkFakultasKriteria4s
 * @property K9LkFakultasKriteria5[] $k9LkFakultasKriteria5s
 * @property K9LkFakultasKriteria6[] $k9LkFakultasKriteria6s
 * @property K9LkFakultasKriteria7[] $k9LkFakultasKriteria7s
 * @property K9LkFakultasKriteria8[] $k9LkFakultasKriteria8s
 * @property K9LkFakultasKriteria9[] $k9LkFakultasKriteria9s
 */
class K9LkFakultas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_lk_fakultas';
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
            [['id_akreditasi', 'id_fakultas', 'created_at', 'updated_at'], 'integer'],
            [['progress'], 'number'],
            [['id_fakultas'], 'exist', 'skipOnError' => true, 'targetClass' => FakultasAkademi::className(), 'targetAttribute' => ['id_fakultas' => 'id']],
            [['id_akreditasi'], 'exist', 'skipOnError' => true, 'targetClass' => K9Akreditasi::className(), 'targetAttribute' => ['id_akreditasi' => 'id']],
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
    public function getFakultas()
    {
        return $this->hasOne(FakultasAkademi::className(), ['id' => 'id_fakultas']);
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
    public function getK9LkFakultasKriteria1s()
    {
        return $this->hasMany(K9LkFakultasKriteria1::className(), ['id_lk_fakultas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkFakultasKriteria2s()
    {
        return $this->hasMany(K9LkFakultasKriteria2::className(), ['id_lk_fakultas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkFakultasKriteria3s()
    {
        return $this->hasMany(K9LkFakultasKriteria3::className(), ['id_lk_fakultas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkFakultasKriteria4s()
    {
        return $this->hasMany(K9LkFakultasKriteria4::className(), ['id_lk_fakultas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkFakultasKriteria5s()
    {
        return $this->hasMany(K9LkFakultasKriteria5::className(), ['id_lk_fakultas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkFakultasKriteria6s()
    {
        return $this->hasMany(K9LkFakultasKriteria6::className(), ['id_lk_fakultas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkFakultasKriteria7s()
    {
        return $this->hasMany(K9LkFakultasKriteria7::className(), ['id_lk_fakultas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkFakultasKriteria8s()
    {
        return $this->hasMany(K9LkFakultasKriteria8::className(), ['id_lk_fakultas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkFakultasKriteria9s()
    {
        return $this->hasMany(K9LkFakultasKriteria9::className(), ['id_lk_fakultas' => 'id']);
    }
}
