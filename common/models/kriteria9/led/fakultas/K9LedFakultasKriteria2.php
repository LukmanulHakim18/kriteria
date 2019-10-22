<?php

namespace common\models\kriteria9\led\fakultas;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_led_fakultas_kriteria2".
 *
 * @property int $id
 * @property int $id_led_fakultas
 * @property double $progress
 * @property int $created_at
 * @property int $updated_at
 *
 * @property K9LedFakultas $ledFakultas
 * @property K9LedFakultasKriteria2Detail[] $k9LedFakultasKriteria2Details
 * @property K9LedFakultasNarasiKriteria2[] $k9LedFakultasNarasiKriteria2s
 */
class K9LedFakultasKriteria2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_led_fakultas_kriteria2';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_led_fakultas', 'created_at', 'updated_at'], 'integer'],
            [['progress'], 'number'],
            [['id_led_fakultas'], 'exist', 'skipOnError' => true, 'targetClass' => K9LedFakultas::className(), 'targetAttribute' => ['id_led_fakultas' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_led_fakultas' => 'Id Led Fakultas',
            'progress' => 'Progress',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLedFakultas()
    {
        return $this->hasOne(K9LedFakultas::className(), ['id' => 'id_led_fakultas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LedFakultasKriteria2Details()
    {
        return $this->hasMany(K9LedFakultasKriteria2Detail::className(), ['id_led_fakultas_kriteria2' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LedFakultasNarasiKriteria2s()
    {
        return $this->hasMany(K9LedFakultasNarasiKriteria2::className(), ['id_led_fakultas_kriteria2' => 'id']);
    }
}
