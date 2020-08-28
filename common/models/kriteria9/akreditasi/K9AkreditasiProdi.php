<?php

namespace common\models\kriteria9\akreditasi;

use common\models\kriteria9\led\prodi\K9LedProdi;
use common\models\kriteria9\lk\prodi\K9LkProdi;
use common\models\ProgramStudi;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_akreditasi_prodi".
 *
 * @property int $id
 * @property int $id_akreditasi
 * @property int $id_prodi
 * @property float $progress
 * @property int $created_at
 * @property int $updated_at
 *
 * @property K9Akreditasi $akreditasi
 * @property ProgramStudi $prodi
 * @property K9LedProdi $k9LedProdi
 * @property K9LkProdi $k9LkProdi
 */
class K9AkreditasiProdi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_akreditasi_prodi';
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
            [['id_akreditasi', 'id_prodi', 'created_at', 'updated_at'], 'integer'],
            [['id_akreditasi'], 'exist', 'skipOnError' => true, 'targetClass' => K9Akreditasi::className(), 'targetAttribute' => ['id_akreditasi' => 'id']],
            [['id_prodi'], 'exist', 'skipOnError' => true, 'targetClass' => ProgramStudi::className(), 'targetAttribute' => ['id_prodi' => 'id']],
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
            'id_prodi' => 'Id Prodi',
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
    public function getProdi()
    {
        return $this->hasOne(ProgramStudi::className(), ['id' => 'id_prodi']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LedProdi()
    {
        return $this->hasOne(K9LedProdi::className(), ['id_akreditasi_prodi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkProdi()
    {
        return $this->hasOne(K9LkProdi::className(), ['id_akreditasi_prodi' => 'id']);
    }

    public function updateProgress(){
        $led = $this->k9LedProdi->progress;
        $lk = $this->k9LkProdi->progress;

        $progress = round((($led+$lk)/2),2);
        $this->progress = $progress;

        return $this;
    }
}
