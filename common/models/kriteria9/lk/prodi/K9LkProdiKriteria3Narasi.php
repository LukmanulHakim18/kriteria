<?php

namespace common\models\kriteria9\lk\prodi;

use common\helpers\kriteria9\K9ProdiProgressHelper;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_lk_prodi_kriteria3".
 *
 * @property int $id
 * @property int $id_lk_prodi_kriteria3
 * @property double $progress
 * @property int $created_at
 * @property int $updated_at
 * @property string $_3_a_1
 * @property string $_3_a_2
 * @property string $_3_a_3
 * @property string $_3_a_4
 * @property string $_3_a_5
 * @property string $_3_b_1
 * @property string $_3_b_2
 * @property string $_3_b_3
 * @property string $_3_b_4
 * @property string $_3_b_5
 * @property string $_3_b_6
 * @property string $_3_b_7
 *
 * @property K9LkProdiKriteria3 $lkProdiKriteria3

 */
class K9LkProdiKriteria3Narasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_lk_prodi_kriteria3_narasi';
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
            [['id_lk_prodi_kriteria3', 'created_at', 'updated_at'], 'integer'],
            [['progress'], 'number'],
            [['_3_a_1', '_3_a_2', '_3_a_3', '_3_a_4', '_3_a_5', '_3_b_1', '_3_b_2', '_3_b_3', '_3_b_4', '_3_b_5', '_3_b_6', '_3_b_7'], 'string'],
            [['id_lk_prodi_kriteria3'], 'exist', 'skipOnError' => true, 'targetClass' => K9LkProdiKriteria3::className(), 'targetAttribute' => ['id_lk_prodi_kriteria3' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_lk_prodi_kriteria3' => 'Id Lk Prodi',
            '_3_a_1' => '3 A 1',
            '_3_a_2' => '3 A 2',
            '_3_a_3' => '3 A 3',
            '_3_a_4' => '3 A 4',
            '_3_a_5' => '3 A 5',
            '_3_b_1' => '3 B 1',
            '_3_b_2' => '3 B 2',
            '_3_b_3' => '3 B 3',
            '_3_b_4' => '3 B 4',
            '_3_b_5' => '3 B 5',
            '_3_b_6' => '3 B 6',
            '_3_b_7' => '3 B 7',
            'progress' => 'Progress',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLkProdiKriteria3()
    {
        return $this->hasOne(K9LkProdiKriteria3::className(), ['id' => 'id_lk_prodi_kriteria3']);
    }

}
