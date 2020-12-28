<?php

namespace common\models\kriteria9\lk\institusi;

use common\helpers\kriteria9\K9InstitusiProgressHelper;

/**
 * This is the model class for table "k9_lk_institusi_kriteria1".
 *
 * @property int $id
 * @property int|null $id_lk_institusi
 * @property float|null $progress_narasi
 * @property float|null $progress_dokumen
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property float $progress
 *
 * @property K9LkInstitusi $lkInstitusi
 * @property K9LkInstitusiKriteria1Detail[] $k9LkInstitusiKriteria1Details
 * @property K9LkInstitusiKriteria1Narasi $k9LkInstitusiKriteria1Narasi
 */
class K9LkInstitusiKriteria1 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_lk_institusi_kriteria1';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_lk_institusi', 'created_at', 'updated_at'], 'integer'],
            [['progress_narasi', 'progress_dokumen'], 'number'],
            [
                ['id_lk_institusi'],
                'exist',
                'skipOnError' => true,
                'targetClass' => K9LkInstitusi::className(),
                'targetAttribute' => ['id_lk_institusi' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_lk_institusi' => 'Id Lk Institusi',
            'progress_narasi' => 'Progress Narasi',
            'progress_dokumen' => 'Progress Dokumen',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[LkInstitusi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLkInstitusi()
    {
        return $this->hasOne(K9LkInstitusi::className(), ['id' => 'id_lk_institusi']);
    }

    /**
     * Gets query for [[K9LkInstitusiKriteria1Narasis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkInstitusiKriteria1Narasi()
    {
        return $this->hasOne(K9LkInstitusiKriteria1Narasi::className(), ['id_lk_institusi_kriteria1' => 'id']);
    }

    public function getProgress()
    {
        return round(($this->progress_narasi + $this->progress_dokumen) / 2, 2);
    }

    public function updateProgressNarasi()
    {

        $this->progress_narasi = $this->k9LkInstitusiKriteria1Narasi->progress;
        return $this;
    }

    public function updateProgressDokumen()
    {
        $dokumen = K9InstitusiProgressHelper::getDokumenLkProgress($this, $this->getK9LkInstitusiKriteria1Details(), 1);
        $progress = round($dokumen, 2);
        $this->progress_dokumen = $progress;
        return $this;
    }

    /**
     * Gets query for [[K9LkInstitusiKriteria1Details]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkInstitusiKriteria1Details()
    {
        return $this->hasMany(K9LkInstitusiKriteria1Detail::className(), ['id_lk_institusi_kriteria1' => 'id']);
    }
}
