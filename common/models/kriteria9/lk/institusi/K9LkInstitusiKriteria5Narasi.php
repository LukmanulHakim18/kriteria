<?php

namespace common\models\kriteria9\lk\institusi;

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
 * @property string $ref__5_d_1__5_d_2__5_e_2
 * @property string $_5_d_1
 * @property string $_5_d_2
 * @property string $ref__5_e_1
 * @property string $_5_e_1
 * @property string $_5_e_2
 * @property string $_5_f
 * @property string $_5_g
 * @property string $_5_h__1
 * @property string $_5_h__2
 * @property string $_5_h__3
 * @property string $_5_h__4
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
            [
                [
                    '_5_a_1',
                    '_5_a_2',
                    '_5_b_1',
                    '_5_b_2',
                    '_5_c_1',
                    '_5_c_2_a',
                    '_5_c_2_b',
                    '_5_c_2_c_1',
                    '_5_c_2_c_2',
                    '_5_c_2_d',
                    '_5_c_2_e',
                    '_5_c_2_f',
                    '_5_c_2_g',
                    'ref__5_d_1__5_d_2__5_e_2',
                    '_5_d_1',
                    '_5_d_2',
                    'ref__5_e_1',
                    '_5_e_1',
                    '_5_e_2',
                    '_5_f',
                    '_5_g',
                    '_5_h__1',
                    '_5_h__2',
                    '_5_h__3',
                    '_5_h__4'
                ],
                'string'
            ],
            [
                ['id_lk_institusi_kriteria5'],
                'exist',
                'skipOnError' => true,
                'targetClass' => K9LkInstitusiKriteria5::className(),
                'targetAttribute' => ['id_lk_institusi_kriteria5' => 'id']
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
            'id_lk_institusi_kriteria5' => 'Id Lk Institusi',
            '_5_a_1' => '5.a.1',
            '_5_a_2' => '5.a.2',
            '_5_b_1' => '5.b.1',
            '_5_b_2' => '5.b.2',
            '_5_c_1' => '5.c.1',
            '_5_c_2_a' => '5.c.2.a',
            '_5_c_2_b' => '5.c.2.b',
            '_5_c_2_c_1' => '5.c.2.c.1',
            '_5_c_2_c_2' => '5.c.2.c.2',
            '_5_c_2_d' => '5.c.2.d',
            '_5_c_2_e' => '5.c.2.e',
            '_5_c_2_f' => '5.c.2.f',
            '_5_c_2_g' => '5.c.2.g',
            'ref__5_d_1__5_d_2__5_e_2' => 'Referensi 5.d.1, 5.d.2, dan 5.e.2',
            '_5_d_1' => '5.d.1',
            '_5_d_2' => '5.d.2',
            'ref__5_e_1' => 'Referensi 5.e.1 ',
            '_5_e_1' => '5.e.1',
            '_5_e_2' => '5.e.2',
            '_5_f' => '5.f',
            '_5_g' => '5.g',
            '_5_h__1' => '5.h-1',
            '_5_h__2' => '5.h-2',
            '_5_h__3' => '5.h-3',
            '_5_h__4' => '5.h-4',
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
