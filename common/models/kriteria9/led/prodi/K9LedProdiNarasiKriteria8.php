<?php

namespace common\models\kriteria9\led\prodi;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_led_prodi_narasi_kriteria8".
 *
 * @property int $id
 * @property int $id_led_prodi_kriteria8
 * @property string $_8_1
 * @property string $_8_2
 * @property string $_8_3
 * @property string $_8_4
 * @property string $_8_5
 * @property string $_8_6
 * @property string $_8_7
 * @property string $_8_8
 * @property string $_8_9
 * @property double $progress
 * @property int $created_at
 * @property int $updated_at
 *
 * @property K9LedProdi $ledProdiKriteria8
 */
class K9LedProdiNarasiKriteria8 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_led_prodi_narasi_kriteria8';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_led_prodi_kriteria8', 'created_at', 'updated_at'], 'integer'],
            [['_8_1', '_8_2', '_8_3', '_8_4', '_8_5', '_8_6', '_8_7', '_8_8', '_8_9'], 'string'],
            [['progress'], 'number'],
            [['id_led_prodi_kriteria8'], 'exist', 'skipOnError' => true, 'targetClass' => K9LedProdi::className(), 'targetAttribute' => ['id_led_prodi_kriteria8' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_led_prodi_kriteria8' => 'Id Led Prodi Kriteria8',
            '_8_1' => '8 1',
            '_8_2' => '8 2',
            '_8_3' => '8 3',
            '_8_4' => '8 4',
            '_8_5' => '8 5',
            '_8_6' => '8 6',
            '_8_7' => '8 7',
            '_8_8' => '8 8',
            '_8_9' => '8 9',
            'progress' => 'Progress',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLedProdiKriteria8()
    {
        return $this->hasOne(K9LedProdi::className(), ['id' => 'id_led_prodi_kriteria8']);
    }
}
