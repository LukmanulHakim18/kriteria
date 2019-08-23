<?php

namespace common\models\kriteria9\led\prodi;

use Yii;

/**
 * This is the model class for table "k9_led_prodi_narasi_kriteria1".
 *
 * @property int $id
 * @property int $id_led_prodi_kriteria1
 * @property string $_1_1
 * @property string $_1_2
 * @property string $_1_3
 * @property string $_1_4
 * @property string $_1_5
 * @property string $_1_6
 * @property string $_1_7
 * @property string $_1_8
 * @property string $_1_9
 * @property double $progress
 * @property int $created_at
 * @property int $updated_at
 *
 * @property K9LedProdi $ledProdiKriteria1
 */
class K9LedProdiNarasiKriteria1 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_led_prodi_narasi_kriteria1';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_led_prodi_kriteria1', 'created_at', 'updated_at'], 'integer'],
            [['_1_1', '_1_2', '_1_3', '_1_4', '_1_5', '_1_6', '_1_7', '_1_8', '_1_9'], 'string'],
            [['progress'], 'number'],
            [['id_led_prodi_kriteria1'], 'exist', 'skipOnError' => true, 'targetClass' => K9LedProdi::className(), 'targetAttribute' => ['id_led_prodi_kriteria1' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_led_prodi_kriteria1' => 'Id Led Prodi Kriteria1',
            '_1_1' => '1 1',
            '_1_2' => '1 2',
            '_1_3' => '1 3',
            '_1_4' => '1 4',
            '_1_5' => '1 5',
            '_1_6' => '1 6',
            '_1_7' => '1 7',
            '_1_8' => '1 8',
            '_1_9' => '1 9',
            'progress' => 'Progress',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLedProdiKriteria1()
    {
        return $this->hasOne(K9LedProdi::className(), ['id' => 'id_led_prodi_kriteria1']);
    }
}
