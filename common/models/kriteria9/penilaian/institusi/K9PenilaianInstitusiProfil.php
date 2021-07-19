<?php

namespace common\models\kriteria9\penilaian\institusi;

use common\helpers\HitungPenilaianTrait;
use common\helpers\kriteria9\K9InstitusiJsonHelper;
use common\models\kriteria9\akreditasi\K9AkreditasiInstitusi;
use common\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_penilaian_institusi_profil".
 *
 * @property int $id
 * @property int|null $id_akreditasi_institusi
 * @property string|null $_1
 * @property int|null $total
 * @property string|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property K9AkreditasiInstitusi $akreditasiInstitusi
 * @property User $createdBy
 * @property User $updatedBy
 */
class K9PenilaianInstitusiProfil extends \yii\db\ActiveRecord
{
    use HitungPenilaianTrait;

    const STATUS_READY = 'ready';
    const STATUS_FINSIH = 'finish';

    const STATUS_PENILAIAN = [self::STATUS_READY => self::STATUS_READY, self::STATUS_FINSIH => self::STATUS_FINSIH];

    public function afterSave($insert, $changedAttributes)
    {

        if ($this->status === self::STATUS_FINSIH) {
            $this->akreditasiInstitusi->updateSkor();
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_akreditasi_institusi' => 'Id Akreditasi Institusi',
            '_1' => '1',
            'total' => 'Total',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $json = K9InstitusiJsonHelper::getJsonPenilaianProfil();

        $indikator = [];
        foreach ($json->indikators as $ind) {
            $indikator[] = $ind->nomor;
        }

        $exclude = [
            'id',
            'id_akreditasi_institusi',
            'total',
            'status',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by'
        ];

        $skor = $this->hitung($this, $exclude, $indikator);
        $this->total = $skor;
        return parent::beforeSave($insert);
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
            [['id_akreditasi_institusi', 'total', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['_1'], 'string'],
            [['status'], 'string', 'max' => 255],
            [
                ['id_akreditasi_institusi'],
                'exist',
                'skipOnError' => true,
                'targetClass' => K9AkreditasiInstitusi::className(),
                'targetAttribute' => ['id_akreditasi_institusi' => 'id']
            ],
            [
                ['created_by'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['created_by' => 'id']
            ],
            [
                ['updated_by'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['updated_by' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_penilaian_institusi_profil';
    }

    /**
     * Gets query for [[AkreditasiInstitusi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAkreditasiInstitusi()
    {
        return $this->hasOne(K9AkreditasiInstitusi::className(), ['id' => 'id_akreditasi_institusi']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
}
