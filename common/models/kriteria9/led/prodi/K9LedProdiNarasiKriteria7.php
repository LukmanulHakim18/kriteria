<?php

namespace common\models\kriteria9\led\prodi;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_led_prodi_narasi_kriteria7".
 *
 * @property int $id
 * @property int $id_led_prodi_kriteria7
 * @property string $_7_1
 * @property string $_7_2
 * @property string $_7_3
 * @property string $_7_4
 * @property string $_7_5
 * @property string $_7_6
 * @property string $_7_7
 * @property string $_7_8
 * @property string $_7_9
 * @property double $progress
 * @property int $created_at
 * @property int $updated_at
 *
 * @property K9LedProdi $ledProdiKriteria7
 */
class K9LedProdiNarasiKriteria7 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_led_prodi_narasi_kriteria7';
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
            [['id_led_prodi_kriteria7', 'created_at', 'updated_at'], 'integer'],
            [['_7_1', '_7_2', '_7_3', '_7_4', '_7_5', '_7_6', '_7_7', '_7_8', '_7_9'], 'string'],
            [['progress'], 'number'],
            [['id_led_prodi_kriteria7'], 'exist', 'skipOnError' => true, 'targetClass' => K9LedProdi::className(), 'targetAttribute' => ['id_led_prodi_kriteria7' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_led_prodi_kriteria7' => 'Id Led Prodi Kriteria7',
            '_7_1' => '7 1',
            '_7_2' => '7 2',
            '_7_3' => '7 3',
            '_7_4' => '7 4',
            '_7_5' => '7 5',
            '_7_6' => '7 6',
            '_7_7' => '7 7',
            '_7_8' => '7 8',
            '_7_9' => '7 9',
            'progress' => 'Progress',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLedProdiKriteria7()
    {
        return $this->hasOne(K9LedProdi::className(), ['id' => 'id_led_prodi_kriteria7']);
    }
}
