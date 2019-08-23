<?php

namespace common\models\sertifikat;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

use yii\web\UploadedFile;

/**
 * This is the model class for table "sertifikat_institusi".
 *
 * @property int $id
 * @property string $nama_institusi
 * @property string $nama_lembaga
 * @property int $tgl_akreditasi
 * @property int $tgl_kadaluarsa
 * @property string $nomor_sk
 * @property string $nomor_sertifikat
 * @property int $nilai_angka
 * @property string $nilai_huruf
 * @property string $tahun_sk
 * @property int $tanggal_pengajuan
 * @property int $tanggal_diterima
 * @property int $is_publik
 * @property string $dokumen_sk
 * @property string $sertifikat
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class SertifikatInstitusi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sertifikat_institusi';
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
            [[ 'nilai_angka', 'is_publik', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['nama_institusi', 'nama_lembaga', 'nomor_sk', 'nomor_sertifikat', 'nilai_huruf', 'tahun_sk', 'dokumen_sk', 'sertifikat'], 'string', 'max' => 255],
            [['tgl_akreditasi','tgl_kadaluarsa','tanggal_diterima','tanggal_pengajuan'],'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_institusi' => 'Nama Institusi',
            'nama_lembaga' => 'Nama Lembaga',
            'tgl_akreditasi' => 'Tanggal Akreditasi',
            'tgl_kadaluarsa' => 'Tanggal Kadaluarsa',
            'nomor_sk' => 'Nomor SK',
            'nomor_sertifikat' => 'Nomor Sertifikat',
            'nilai_angka' => 'Nilai Angka',
            'nilai_huruf' => 'Nilai Huruf',
            'tahun_sk' => 'Tahun Sk',
            'tanggal_pengajuan' => 'Tanggal Pengajuan',
            'tanggal_diterima' => 'Tanggal Diterima',
            'is_publik' => 'Dokumen Publik',
            'dokumen_sk' => 'Dokumen SK',
            'sertifikat' => 'Sertifikat',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $path = Yii::getAlias('@uploadAkreditasi/sertifikat/institusi');
            $this->sertifikat->saveAs($path.'/' . $this->sertifikat->baseName . '.' . $this->sertifikat->extension);
            return true;
        } else {
            return false;
        }
    }

}
