<?php

namespace common\models\kriteria9\led\institusi;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_dokumen_led_institusi".
 *
 * @property int $id
 * @property int $id_led_institusi
 * @property string $kode_dokumen
 * @property string $nama_dokumen
 * @property string $bentuk_dokumen
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property K9LedInstitusi $ledInstitusi
 */
class K9InstitusiEksporDokumen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_dokumen_led_institusi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_led_institusi', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['nama_dokumen', 'bentuk_dokumen', 'kode_dokumen'], 'string', 'max' => 255],
            [
                ['id_led_institusi'],
                'exist',
                'skipOnError' => true,
                'targetClass' => K9LedInstitusi::className(),
                'targetAttribute' => ['id_led_institusi' => 'id']
            ],
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_led_institusi' => 'Id Led Institusi',
            'kode_dokumen' => 'Kode Dokumen',
            'nama_dokumen' => 'Nama Dokumen',
            'bentuk_dokumen' => 'Bentuk Dokumen',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLedInstitusi()
    {
        return $this->hasOne(K9LedInstitusi::className(), ['id' => 'id_led_institusi']);
    }
}
