<?php

namespace common\models\kriteria9\lk\institusi;

use common\helpers\kriteria9\K9InstitusiProgressHelper;
use Yii;

/**
 * This is the model class for table "k9_lk_institusi_kriteria3".
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
 * @property K9LkInstitusiKriteria3Detail[] $k9LkInstitusiKriteria3Details
 * @property K9LkInstitusiKriteria3Narasi $k9LkInstitusiKriteria3Narasi
 */
class K9LkInstitusiKriteria3 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_lk_institusi_kriteria3';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_lk_institusi', 'created_at', 'updated_at'], 'integer'],
            [['progress_narasi', 'progress_dokumen'], 'number'],
            [['id_lk_institusi'], 'exist', 'skipOnError' => true, 'targetClass' => K9LkInstitusi::className(), 'targetAttribute' => ['id_lk_institusi' => 'id']],
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
     * Gets query for [[K9LkInstitusiKriteria3Details]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkInstitusiKriteria3Details()
    {
        return $this->hasMany(K9LkInstitusiKriteria3Detail::className(), ['id_lk_institusi_kriteria3' => 'id']);
    }

    /**
     * Gets query for [[K9LkInstitusiKriteria3Narasis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkInstitusiKriteria3Narasi()
    {
        return $this->hasOne(K9LkInstitusiKriteria3Narasi::className(), ['id_lk_institusi_kriteria3' => 'id']);
    }

    public function getProgress(){
        if ($this->progress_dokumen === 0.0){
            return $this->progress_narasi;
        }
        return round(( $this->progress_narasi + $this->progress_dokumen)/2,2);
    }
    public function updateProgressNarasi(){

        $this->progress_narasi = $this->k9LkInstitusiKriteria3Narasi->progress;
        return $this;
    }
    public function updateProgressDokumen()
    {
        $dokumen = K9InstitusiProgressHelper::getDokumenLkProgress($this, $this->getK9LkInstitusiKriteria3Details(), 3);
        $progress = round($dokumen, 2);
        $this->progress_dokumen = $progress;
        return $this;
    }
}
