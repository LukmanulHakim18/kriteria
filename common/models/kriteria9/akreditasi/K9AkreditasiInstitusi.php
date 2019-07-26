<?php

namespace common\models\kriteria9\akreditasi;

use common\models\kriteria9\led\institusi\K9LedInstitusi;
use common\models\kriteria9\lk\institusi\K9LkInstitusi;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_akreditasi_institusi".
 *
 * @property int $id
 * @property int $id_akreditasi
 * @property float $progress
 * @property int $created_at
 * @property int $updated_at
 *
 * @property K9Akreditasi $akreditasi
 * @property K9LedInstitusi[] $k9LedInstitusis
 * @property K9LkInstitusi[] $k9LkInstitusis
 */
class K9AkreditasiInstitusi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_akreditasi_institusi';
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
            [['id_akreditasi', 'created_at', 'updated_at'], 'integer'],
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
    public function getK9LedInstitusis()
    {
        return $this->hasMany(K9LedInstitusi::className(), ['id_akreditasi_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkInstitusis()
    {
        return $this->hasMany(K9LkInstitusi::className(), ['id_akreditasi_institusi' => 'id']);
    }
}
