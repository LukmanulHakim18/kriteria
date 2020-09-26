<?php

namespace common\models\kriteria9\lk\institusi;

use common\helpers\kriteria9\K9InstitusiProgressHelper;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_lk_institusi_kriteria5".
 *
 * @property int $id
 * @property int $id_lk_institusi_kriteria5
 * @property string $_5_a_1
 * @property string $_5_a_2
 * @property string $_5_b_1
 * @property string $_5_b_2
 * @property string $_5_c_1
 * @property string $_5_c_2_a
 * @property string $_5_c_2_b
 * @property string $_5_c_2_c_1
 * @property string $_5_c_2_c_2
 * @property string $_5_c_2_d
 * @property string $_5_c_2_e
 * @property string $_5_c_2_f
 * @property string $_5_c_2_g
 * @property string $_5_d
 * @property string $_5_d_1
 * @property string $_5_d_2
 * @property string $_5_e
 * @property string $_5_e_1
 * @property string $_5_e_2
 * @property string $_5_f
 * @property string $_5_g
 * @property string $_5_h
 * @property double $progress
 * @property int $created_at
 * @property int $updated_at
 *
 * @property K9LkInstitusiKriteria5 $lkInstitusiKriteria5
 */
class K9LkInstitusiKriteria5Narasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_lk_institusi_kriteria5_narasi';
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
            [['id_lk_institusi_kriteria5', 'created_at', 'updated_at'], 'integer'],
            [['progress'], 'number'],
            [['_5_a_1', '_5_a_2', '_5_b_1', '_5_b_2', '_5_c_1', '_5_c_2_a', '_5_c_2_b', '_5_c_2_c_1', '_5_c_2_c_2', '_5_c_2_d', '_5_c_2_e', '_5_c_2_f', '_5_c_2_g', '_5_d', '_5_d_1', '_5_d_2', '_5_e', '_5_e_1', '_5_e_2', '_5_f', '_5_g', '_5_h'], 'string'],
            [['id_lk_institusi_kriteria5'], 'exist', 'skipOnError' => true, 'targetClass' => K9LkInstitusiKriteria5::className(), 'targetAttribute' => ['id_lk_institusi_kriteria5' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_lk_institusi_kriteria5' => 'Id Lk Institusi',
            '_5_a_1' => '5 A 1',
            '_5_a_2' => '5 A 2',
            '_5_b_1' => '5 B 1',
            '_5_b_2' => '5 B 2',
            '_5_c_1' => '5 C 1',
            '_5_c_2_a' => '5 C 2 A',
            '_5_c_2_b' => '5 C 2 B',
            '_5_c_2_c_1' => '5 C 2 C 1',
            '_5_c_2_c_2' => '5 C 2 C 2',
            '_5_c_2_d' => '5 C 2 D',
            '_5_c_2_e' => '5 C 2 E',
            '_5_c_2_f' => '5 C 2 F',
            '_5_c_2_g' => '5 C 2 G',
            '_5_d' => '5 D',
            '_5_d_1' => '5 D 1',
            '_5_d_2' => '5 D 2',
            '_5_e' => '5 E',
            '_5_e_1' => '5 E 1',
            '_5_e_2' => '5 E 2',
            '_5_f' => '5 F',
            '_5_g' => '5 G',
            '_5_h' => '5 H',
            'progress' => 'Progress',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLkInstitusiKriteria5()
    {
        return $this->hasOne(K9LkInstitusiKriteria5::className(), ['id' => 'id_lk_institusi_kriteria5']);
    }

}
