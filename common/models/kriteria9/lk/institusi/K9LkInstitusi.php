<?php

namespace common\models\kriteria9\lk\institusi;

use common\models\kriteria9\akreditasi\K9AkreditasiInstitusi;
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
 * @property K9LkInstitusiKriteria1 $k9LkInstitusiKriteria1s
 * @property K9LkInstitusiKriteria2 $k9LkInstitusiKriteria2s
 * @property K9LkInstitusiKriteria3 $k9LkInstitusiKriteria3s
 * @property K9LkInstitusiKriteria4 $k9LkInstitusiKriteria4s
 * @property K9LkInstitusiKriteria5 $k9LkInstitusiKriteria5s
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
            TimestampBehavior::class,
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
        return $this->hasOne(K9LkInstitusiKriteria1::className(), ['id_lk_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkInstitusiKriteria2s()
    {
        return $this->hasOne(K9LkInstitusiKriteria2::className(), ['id_lk_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkInstitusiKriteria3s()
    {
        return $this->hasOne(K9LkInstitusiKriteria3::className(), ['id_lk_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkInstitusiKriteria4s()
    {
        return $this->hasOne(K9LkInstitusiKriteria4::className(), ['id_lk_institusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkInstitusiKriteria5s()
    {
        return $this->hasOne(K9LkInstitusiKriteria5::className(), ['id_lk_institusi' => 'id']);
    }


    public function updateProgress()
    {
        $kriteria1 = $this->k9LkInstitusiKriteria1s->progress;
        $kriteria2 = $this->k9LkInstitusiKriteria2s->progress;
        $kriteria3 = $this->k9LkInstitusiKriteria3s->progress;
        $kriteria4 = $this->k9LkInstitusiKriteria4s->progress;
        $kriteria5 = $this->k9LkInstitusiKriteria5s->progress;


        $progress = round((($kriteria1 + $kriteria2 + $kriteria3 + $kriteria4 + $kriteria5) / 5), 2);
        $this->progress = $progress;

        $this->save(false);
    }
}
