<?php

namespace common\models\kriteria9\led\fakultas;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_led_fakultas_narasi_kriteria3".
 *
 * @property int $id
 * @property int $id_led_fakultas_kriteria3
 * @property string $_3_1
 * @property string $_3_2
 * @property string $_3_3
 * @property string $_3_4
 * @property string $_3_5
 * @property string $_3_6
 * @property string $_3_7
 * @property string $_3_8
 * @property string $_3_9
 * @property double $progress
 * @property int $created_at
 * @property int $updated_at
 *
 * @property K9LedFakultas $ledFakultasKriteria3
 */
class K9LedFakultasNarasiKriteria3 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_led_fakultas_narasi_kriteria3';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_led_fakultas_kriteria3', 'created_at', 'updated_at'], 'integer'],
            [['_3_1', '_3_2', '_3_3', '_3_4', '_3_5', '_3_6', '_3_7', '_3_8', '_3_9'], 'string'],
            [['progress'], 'number'],
            [['id_led_fakultas_kriteria3'], 'exist', 'skipOnError' => true, 'targetClass' => K9LedFakultas::className(), 'targetAttribute' => ['id_led_fakultas_kriteria3' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_led_fakultas_kriteria3' => 'Id Led Fakultas Kriteria3',
            '_3_1' => '3 1',
            '_3_2' => '3 2',
            '_3_3' => '3 3',
            '_3_4' => '3 4',
            '_3_5' => '3 5',
            '_3_6' => '3 6',
            '_3_7' => '3 7',
            '_3_8' => '3 8',
            '_3_9' => '3 9',
            'progress' => 'Progress',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLedFakultasKriteria3()
    {
        return $this->hasOne(K9LedFakultas::className(), ['id' => 'id_led_fakultas_kriteria3']);
    }
}
