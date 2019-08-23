<?php

namespace common\models\kriteria9\led\institusi;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_led_institusi_narasi_kriteria2".
 *
 * @property int $id
 * @property int $id_led_institusi_kriteria2
 * @property string $_2_1
 * @property string $_2_2
 * @property string $_2_3
 * @property string $_2_4
 * @property string $_2_5
 * @property string $_2_6
 * @property string $_2_7
 * @property string $_2_8
 * @property string $_2_9
 * @property double $progress
 * @property int $created_at
 * @property int $updated_at
 *
 * @property K9LedInstitusi $ledInstitusiKriteria2
 */
class K9LedInstitusiNarasiKriteria2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_led_institusi_narasi_kriteria2';
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
            [['id_led_institusi_kriteria2', 'created_at', 'updated_at'], 'integer'],
            [['_2_1', '_2_2', '_2_3', '_2_4', '_2_5', '_2_6', '_2_7', '_2_8', '_2_9'], 'string'],
            [['progress'], 'number'],
            [['id_led_institusi_kriteria2'], 'exist', 'skipOnError' => true, 'targetClass' => K9LedInstitusi::className(), 'targetAttribute' => ['id_led_institusi_kriteria2' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_led_institusi_kriteria2' => 'Id Led Institusi Kriteria2',
            '_2_1' => '2 1',
            '_2_2' => '2 2',
            '_2_3' => '2 3',
            '_2_4' => '2 4',
            '_2_5' => '2 5',
            '_2_6' => '2 6',
            '_2_7' => '2 7',
            '_2_8' => '2 8',
            '_2_9' => '2 9',
            'progress' => 'Progress',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLedInstitusiKriteria2()
    {
        return $this->hasOne(K9LedInstitusi::className(), ['id' => 'id_led_institusi_kriteria2']);
    }
}
