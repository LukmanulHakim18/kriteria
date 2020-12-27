<?php

namespace common\models\kriteria9\led\institusi;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_led_institusi_narasi_analisis".
 *
 * @property int $id
 * @property int|null $id_led_institusi
 * @property string|null $_1
 * @property string|null $_2
 * @property string|null $_3
 * @property string|null $_4
 * @property float|null $progress
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property K9LedInstitusi $ledInstitusi
 * @property K9LedInstitusiNonKriteriaDokumen[] $documents
 */
class K9LedInstitusiNarasiAnalisis extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_led_institusi_narasi_analisis';
    }

    public function behaviors()
    {
        return [TimestampBehavior::class];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_led_institusi', 'created_at', 'updated_at'], 'integer'],
            [['_1', '_2', '_3', '_4'], 'string'],
            [['progress'], 'number'],
            [
                ['id_led_institusi'],
                'exist',
                'skipOnError' => true,
                'targetClass' => K9LedInstitusi::className(),
                'targetAttribute' => ['id_led_institusi' => 'id']
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
            '_1' => '1',
            '_2' => '2',
            '_3' => '3',
            '_4' => '4',
            'progress' => 'Progress',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
     * @return \yii\db\ActiveQuery
     */
    public function getDocuments()
    {
        return $this->hasMany(K9LedInstitusiNonKriteriaDokumen::class,
            ['id_led_institusi' => 'id_led_institusi'])->andWhere([
            'like',
            'kode_dokumen',
            'D.%',
            false
        ]);
    }
}
