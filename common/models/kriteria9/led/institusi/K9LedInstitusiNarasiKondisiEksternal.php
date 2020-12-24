<?php

namespace common\models\kriteria9\led\institusi;

use Yii;

/**
 * This is the model class for table "k9_led_institusi_narasi_kondisi_eksternal".
 *
 * @property int $id
 * @property int|null $id_led_institusi
 * @property string|null $_A
 * @property float|null $progress
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property K9LedInstitusi $ledInstitusi
 */
class K9LedInstitusiNarasiKondisiEksternal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_led_institusi_narasi_kondisi_eksternal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_led_institusi', 'created_at', 'updated_at'], 'integer'],
            [['_A'], 'string'],
            [['progress'], 'number'],
            [['id_led_institusi'], 'exist', 'skipOnError' => true, 'targetClass' => K9LedInstitusi::className(), 'targetAttribute' => ['id_led_institusi' => 'id']],
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
            '_A' => 'A',
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
}
