<?php

namespace common\models\kriteria9\led\institusi;

use common\models\kriteria9\lk\institusi\K9LkInstitusi;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_dokumen_led_institusi".
 *
 * @property int $id
 * @property int $external_id
 * @property string $type
 * @property string $kode_dokumen
 * @property string $nama_dokumen
 * @property string $bentuk_dokumen
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property K9LedInstitusi $ledInstitusi
 * @property K9LkInstitusi $lkInstitusi
 */
class K9InstitusiEksporDokumen extends \yii\db\ActiveRecord
{
    const TYPE_LED = 'led';
    const TYPE_LK = 'lk';

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'external_id' => 'ID Eksternal',
            'type' => 'Tipe',
            'kode_dokumen' => 'Kode Dokumen',
            'nama_dokumen' => 'Nama Dokumen',
            'bentuk_dokumen' => 'Bentuk Dokumen',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['external_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['nama_dokumen', 'bentuk_dokumen', 'kode_dokumen', 'type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_institusi_ekspor_dokumen';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLedInstitusi()
    {
        return $this->hasOne(K9LedInstitusi::className(),
            ['id' => 'external_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLkInstitusi()
    {
        return $this->hasOne(K9LkInstitusi::className(),
            ['id' => 'external_id']);
    }
}
