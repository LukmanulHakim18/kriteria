<?php

namespace common\models\kriteria9\led\institusi;

use common\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_led_institusi_non_kriteria_dokumen".
 *
 * @property int $id
 * @property int|null $id_led_institusi
 * @property string|null $kode_dokumen
 * @property string|null $nama_dokumen
 * @property string|null $isi_dokumen
 * @property string|null $bentuk_dokumen
 * @property string|null $jenis_dokumen
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property K9LedInstitusi $ledInstitusi
 * @property User $createdAt
 * @property User $updatedAt
 */
class K9LedInstitusiNonKriteriaDokumen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_led_institusi_non_kriteria_dokumen';
    }

    public function behaviors()
    {
        return [TimestampBehavior::class, BlameableBehavior::class];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_led_institusi', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['isi_dokumen'], 'string'],
            [['kode_dokumen', 'nama_dokumen', 'bentuk_dokumen', 'jenis_dokumen'], 'string', 'max' => 255],
            [
                ['id_led_institusi'],
                'exist',
                'skipOnError' => true,
                'targetClass' => K9LedInstitusi::className(),
                'targetAttribute' => ['id_led_institusi' => 'id']
            ],
            [
                ['created_at'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['created_at' => 'id']
            ],
            [
                ['updated_at'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['updated_at' => 'id']
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
            'id_led_institusi' => 'Id Led Institusi',
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
     * Gets query for [[LedInstitusi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLedInstitusi()
    {
        return $this->hasOne(K9LedInstitusi::className(), ['id' => 'id_led_institusi']);
    }

    /**
     * Gets query for [[CreatedAt]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedAt()
    {
        return $this->hasOne(User::className(), ['id' => 'created_at']);
    }

    /**
     * Gets query for [[UpdatedAt]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedAt()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_at']);
    }
}
