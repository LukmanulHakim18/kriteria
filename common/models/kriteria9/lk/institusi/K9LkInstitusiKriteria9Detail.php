<?php

namespace common\models\kriteria9\lk\institusi;

use common\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_lk_institusi_kriteria9_detail".
 *
 * @property int $id
 * @property int $id_lk_institusi_kriteria9
 * @property string $kode_dokumen
 * @property string $nama_dokumen
 * @property string $isi_dokumen
 * @property string $bentuk_dokumen
 * @property string $jenis_dokumen
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property K9LkInstitusiKriteria9 $lkInstitusiKriteria9
 * @property User $createdBy
 * @property User $updatedBy
 */
class K9LkInstitusiKriteria9Detail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_lk_institusi_kriteria9_detail';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_lk_institusi_kriteria9', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['kode_dokumen', 'nama_dokumen', 'isi_dokumen', 'bentuk_dokumen', 'jenis_dokumen'], 'string', 'max' => 255],
            [['id_lk_institusi_kriteria9'], 'exist', 'skipOnError' => true, 'targetClass' => K9LkInstitusiKriteria9::className(), 'targetAttribute' => ['id_lk_institusi_kriteria9' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_lk_institusi_kriteria9' => 'Id Lk Institusi Kriteria9',
            'kode_dokumen' => 'Kode Dokumen',
            'nama_dokumen' => 'Nama Dokumen',
            'isi_dokumen' => 'Isi Dokumen',
            'bentuk_dokumen' => 'Bentuk Dokumen',
            'jenis_dokumen' => 'Jenis Dokumen',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLkInstitusiKriteria9()
    {
        return $this->hasOne(K9LkInstitusiKriteria9::className(), ['id' => 'id_lk_institusi_kriteria9']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->lkInstitusiKriteria9->updateProgress();
        $this->lkInstitusiKriteria9->lkInstitusi->updateProgress();
        $this->lkInstitusiKriteria9->lkInstitusi->akreditasiInstitusi->updateProgress();
        return parent::afterSave($insert, $changedAttributes);
    }

    public function afterDelete()
    {
        $this->lkInstitusiKriteria9->updateProgress();
        $this->lkInstitusiKriteria9->lkInstitusi->updateProgress();
        $this->lkInstitusiKriteria9->lkInstitusi->akreditasiInstitusi->updateProgress();
        parent::afterDelete();
    }
}
