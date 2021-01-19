<?php

namespace common\models\kriteria9\lk\institusi;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_lk_institusi_kriteria3".
 *
 * @property int $id
 * @property int $id_lk_institusi_kriteria3
 * @property string $_3_a_1
 * @property string $_3_a_2
 * @property string $_3_a_3
 * @property string $_3_a_4
 * @property string $_3_b
 * @property string $_3_c_1
 * @property string $_3_c_2
 * @property string $_3_d
 * @property double $progress
 * @property int $created_at
 * @property int $updated_at
 *
 * @property K9LkInstitusiKriteria3 $lkInstitusiKriteria3
 */
class K9LkInstitusiKriteria3Narasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_lk_institusi_kriteria3_narasi';
    }

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
            [['id_lk_institusi_kriteria3', 'created_at', 'updated_at'], 'integer'],
            [['progress'], 'number'],
            [['_3_a_1', '_3_a_2', '_3_a_3', '_3_a_4', '_3_b', '_3_c_1', '_3_c_2', '_3_d'], 'string'],
            [
                ['id_lk_institusi_kriteria3'],
                'exist',
                'skipOnError' => true,
                'targetClass' => K9LkInstitusiKriteria3::className(),
                'targetAttribute' => ['id_lk_institusi_kriteria3' => 'id']
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
            'id_lk_institusi_kriteria3' => 'Id Lk Institusi',
            '_3_a_1' => '3.a.1',
            '_3_a_2' => '3.a.2',
            '_3_a_3' => '3.a.3',
            '_3_a_4' => '3.a.4',
            '_3_b' => '3.b',
            '_3_c_1' => '3.c.1',
            '_3_c_2' => '3.c.2',
            '_3_d' => '3.d',
            'progress' => 'Progress',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLkInstitusiKriteria3()
    {
        return $this->hasOne(K9LkInstitusiKriteria3::className(), ['id' => 'id_lk_institusi_kriteria3']);
    }

}
