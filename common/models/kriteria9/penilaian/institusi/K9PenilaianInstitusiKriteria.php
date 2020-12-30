<?php

namespace common\models\kriteria9\penilaian\institusi;

use common\helpers\HitungPenilaianTrait;
use common\helpers\kriteria9\K9InstitusiJsonHelper;
use common\models\kriteria9\akreditasi\K9AkreditasiInstitusi;
use common\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_penilaian_institusi_kriteria".
 *
 * @property int $id
 * @property int|null $id_akreditasi_institusi
 * @property string|null $_1_4_1
 * @property string|null $_2_4_a_A
 * @property string|null $_2_4_a_B
 * @property string|null $_2_4_a_C
 * @property string|null $_2_4_a_D
 * @property string|null $_2_4_a_E
 * @property string|null $_2_4_b_A
 * @property string|null $_2_4_b_B
 * @property string|null $_2_4_b_C
 * @property string|null $_2_4_c_A
 * @property string|null $_2_4_c_B
 * @property string|null $_2_4_c_C
 * @property string|null $_2_4_c_D
 * @property string|null $_2_4_d__1_A__1
 * @property string|null $_2_4_d__1_B__1
 * @property string|null $_2_4_d__1_A__2
 * @property string|null $_2_4_d__1_B__2
 * @property string|null $_2_4_d__1_1
 * @property string|null $_2_4_d__1_2
 * @property string|null $_2_4_d__2_A
 * @property string|null $_2_4_d__2_B
 * @property string|null $_2_4_d__2_C
 * @property string|null $_2_4_d__2_D
 * @property string|null $_2_4_d__2_1
 * @property string|null $_2_5_1
 * @property string|null $_2_6_1
 * @property string|null $_2_7_1
 * @property string|null $_2_8_1
 * @property string|null $_3_4_a_1
 * @property string|null $_3_4_a_2
 * @property string|null $_3_4_a_3
 * @property string|null $_3_4_b_1
 * @property string|null $_4_4_a_1
 * @property string|null $_4_4_a_2
 * @property string|null $_4_4_a_3
 * @property string|null $_4_4_a_4
 * @property string|null $_4_4_a_5
 * @property string|null $_4_4_b_1
 * @property string|null $_4_4_b_2
 * @property string|null $_4_4_b_3
 * @property string|null $_4_4_c_1
 * @property string|null $_5_4_a_1
 * @property string|null $_5_4_a_2
 * @property string|null $_5_4_a_3
 * @property string|null $_5_4_a_4
 * @property string|null $_5_4_a_5
 * @property string|null $_5_4_a_6
 * @property string|null $_5_4_a_7
 * @property string|null $_5_4_b_A
 * @property string|null $_5_4_b_B
 * @property string|null $_5_4_b_C
 * @property string|null $_6_4_a_A
 * @property string|null $_6_4_a_B
 * @property string|null $_6_4_a_C
 * @property string|null $_6_4_b_A
 * @property string|null $_6_4_b_B
 * @property string|null $_6_4_b_C
 * @property string|null $_6_4_c_A
 * @property string|null $_6_4_c_B
 * @property string|null $_6_4_c_C
 * @property string|null $_6_4_d_A
 * @property string|null $_6_4_d_B
 * @property string|null $_6_4_d_C
 * @property string|null $_7_4_a_A
 * @property string|null $_7_4_a_B
 * @property string|null $_7_4_a_C
 * @property string|null $_7_4_a_D
 * @property string|null $_7_4_b_1
 * @property string|null $_8_4_a__1_A
 * @property string|null $_8_4_a__1_B
 * @property string|null $_8_4_a__1_C
 * @property string|null $_8_4_a__1_D
 * @property string|null $_8_4_a__2_1
 * @property string|null $_9_4_a_1
 * @property string|null $_9_4_a_2
 * @property string|null $_9_4_a_3
 * @property string|null $_9_4_a_4
 * @property string|null $_9_4_a_5
 * @property string|null $_9_4_a_6
 * @property string|null $_9_4_a_7
 * @property string|null $_9_4_a_8
 * @property string|null $_9_4_a_9
 * @property string|null $_9_4_a_10
 * @property string|null $_9_4_b_1
 * @property string|null $_9_4_b_2
 * @property string|null $_9_4_b_3
 * @property string|null $_9_4_b_4
 * @property int|null $total
 * @property string|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property K9AkreditasiInstitusi $akreditasiInstitusi
 * @property User $createdBy
 * @property User $updatedBy
 */
class K9PenilaianInstitusiKriteria extends \yii\db\ActiveRecord
{
    use HitungPenilaianTrait;

    const STATUS_READY = 'ready';
    const STATUS_FINSIH = 'finish';

    const STATUS_PENILAIAN = [self::STATUS_READY => self::STATUS_READY, self::STATUS_FINSIH => self::STATUS_FINSIH];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_penilaian_institusi_kriteria';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_akreditasi_institusi', 'total', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [
                [
                    '_1_4_1',
                    '_2_4_a_A',
                    '_2_4_a_B',
                    '_2_4_a_C',
                    '_2_4_a_D',
                    '_2_4_a_E',
                    '_2_4_b_A',
                    '_2_4_b_B',
                    '_2_4_b_C',
                    '_2_4_c_A',
                    '_2_4_c_B',
                    '_2_4_c_C',
                    '_2_4_c_D',
                    '_2_4_d__1_A__1',
                    '_2_4_d__1_B__1',
                    '_2_4_d__1_A__2',
                    '_2_4_d__1_B__2',
                    '_2_4_d__1_1',
                    '_2_4_d__1_2',
                    '_2_4_d__2_A',
                    '_2_4_d__2_B',
                    '_2_4_d__2_C',
                    '_2_4_d__2_D',
                    '_2_4_d__2_1',
                    '_2_5_1',
                    '_2_6_1',
                    '_2_7_1',
                    '_2_8_1',
                    '_3_4_a_1',
                    '_3_4_a_2',
                    '_3_4_a_3',
                    '_3_4_b_1',
                    '_4_4_a_1',
                    '_4_4_a_2',
                    '_4_4_a_3',
                    '_4_4_a_4',
                    '_4_4_a_5',
                    '_4_4_b_1',
                    '_4_4_b_2',
                    '_4_4_b_3',
                    '_4_4_c_1',
                    '_5_4_a_1',
                    '_5_4_a_2',
                    '_5_4_a_3',
                    '_5_4_a_4',
                    '_5_4_a_5',
                    '_5_4_a_6',
                    '_5_4_a_7',
                    '_5_4_b_A',
                    '_5_4_b_B',
                    '_5_4_b_C',
                    '_6_4_a_A',
                    '_6_4_a_B',
                    '_6_4_a_C',
                    '_6_4_b_A',
                    '_6_4_b_B',
                    '_6_4_b_C',
                    '_6_4_c_A',
                    '_6_4_c_B',
                    '_6_4_c_C',
                    '_6_4_d_A',
                    '_6_4_d_B',
                    '_6_4_d_C',
                    '_7_4_a_A',
                    '_7_4_a_B',
                    '_7_4_a_C',
                    '_7_4_a_D',
                    '_7_4_b_1',
                    '_8_4_a__1_A',
                    '_8_4_a__1_B',
                    '_8_4_a__1_C',
                    '_8_4_a__1_D',
                    '_8_4_a__2_1',
                    '_9_4_a_1',
                    '_9_4_a_2',
                    '_9_4_a_3',
                    '_9_4_a_4',
                    '_9_4_a_5',
                    '_9_4_a_6',
                    '_9_4_a_7',
                    '_9_4_a_8',
                    '_9_4_a_9',
                    '_9_4_a_10',
                    '_9_4_b_1',
                    '_9_4_b_2',
                    '_9_4_b_3',
                    '_9_4_b_4'
                ],
                'string'
            ],
            [['status'], 'string', 'max' => 255],
            [
                ['id_akreditasi_institusi'],
                'exist',
                'skipOnError' => true,
                'targetClass' => K9AkreditasiInstitusi::className(),
                'targetAttribute' => ['id_akreditasi_institusi' => 'id']
            ],
            [
                ['created_by'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['created_by' => 'id']
            ],
            [
                ['updated_by'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['updated_by' => 'id']
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
            'id_akreditasi_institusi' => 'Id Akreditasi Institusi',
            '_1_4_1' => '1 4 1',
            '_2_4_a_A' => '2 4 A A',
            '_2_4_a_B' => '2 4 A B',
            '_2_4_a_C' => '2 4 A C',
            '_2_4_a_D' => '2 4 A D',
            '_2_4_a_E' => '2 4 A E',
            '_2_4_b_A' => '2 4 B A',
            '_2_4_b_B' => '2 4 B B',
            '_2_4_b_C' => '2 4 B C',
            '_2_4_c_A' => '2 4 C A',
            '_2_4_c_B' => '2 4 C B',
            '_2_4_c_C' => '2 4 C C',
            '_2_4_c_D' => '2 4 C D',
            '_2_4_d__1_A__1' => '2 4 D 1 A 1',
            '_2_4_d__1_B__1' => '2 4 D 1 B 1',
            '_2_4_d__1_A__2' => '2 4 D 1 A 2',
            '_2_4_d__1_B__2' => '2 4 D 1 B 2',
            '_2_4_d__1_1' => '2 4 D 1 1',
            '_2_4_d__1_2' => '2 4 D 1 2',
            '_2_4_d__2_A' => '2 4 D 2 A',
            '_2_4_d__2_B' => '2 4 D 2 B',
            '_2_4_d__2_C' => '2 4 D 2 C',
            '_2_4_d__2_D' => '2 4 D 2 D',
            '_2_4_d__2_1' => '2 4 D 2 1',
            '_2_5_1' => '2 5 1',
            '_2_6_1' => '2 6 1',
            '_2_7_1' => '2 7 1',
            '_2_8_1' => '2 8 1',
            '_3_4_a_1' => '3 4 A 1',
            '_3_4_a_2' => '3 4 A 2',
            '_3_4_a_3' => '3 4 A 3',
            '_3_4_b_1' => '3 4 B 1',
            '_4_4_a_1' => '4 4 A 1',
            '_4_4_a_2' => '4 4 A 2',
            '_4_4_a_3' => '4 4 A 3',
            '_4_4_a_4' => '4 4 A 4',
            '_4_4_a_5' => '4 4 A 5',
            '_4_4_b_1' => '4 4 B 1',
            '_4_4_b_2' => '4 4 B 2',
            '_4_4_b_3' => '4 4 B 3',
            '_4_4_c_1' => '4 4 C 1',
            '_5_4_a_1' => '5 4 A 1',
            '_5_4_a_2' => '5 4 A 2',
            '_5_4_a_3' => '5 4 A 3',
            '_5_4_a_4' => '5 4 A 4',
            '_5_4_a_5' => '5 4 A 5',
            '_5_4_a_6' => '5 4 A 6',
            '_5_4_a_7' => '5 4 A 7',
            '_5_4_b_A' => '5 4 B A',
            '_5_4_b_B' => '5 4 B B',
            '_5_4_b_C' => '5 4 B C',
            '_6_4_a_A' => '6 4 A A',
            '_6_4_a_B' => '6 4 A B',
            '_6_4_a_C' => '6 4 A C',
            '_6_4_b_A' => '6 4 B A',
            '_6_4_b_B' => '6 4 B B',
            '_6_4_b_C' => '6 4 B C',
            '_6_4_c_A' => '6 4 C A',
            '_6_4_c_B' => '6 4 C B',
            '_6_4_c_C' => '6 4 C C',
            '_6_4_d_A' => '6 4 D A',
            '_6_4_d_B' => '6 4 D B',
            '_6_4_d_C' => '6 4 D C',
            '_7_4_a_A' => '7 4 A A',
            '_7_4_a_B' => '7 4 A B',
            '_7_4_a_C' => '7 4 A C',
            '_7_4_a_D' => '7 4 A D',
            '_7_4_b_1' => '7 4 B 1',
            '_8_4_a__1_A' => '8 4 A 1 A',
            '_8_4_a__1_B' => '8 4 A 1 B',
            '_8_4_a__1_C' => '8 4 A 1 C',
            '_8_4_a__1_D' => '8 4 A 1 D',
            '_8_4_a__2_1' => '8 4 A 2 1',
            '_9_4_a_1' => '9 4 A 1',
            '_9_4_a_2' => '9 4 A 2',
            '_9_4_a_3' => '9 4 A 3',
            '_9_4_a_4' => '9 4 A 4',
            '_9_4_a_5' => '9 4 A 5',
            '_9_4_a_6' => '9 4 A 6',
            '_9_4_a_7' => '9 4 A 7',
            '_9_4_a_8' => '9 4 A 8',
            '_9_4_a_9' => '9 4 A 9',
            '_9_4_a_10' => '9 4 A 10',
            '_9_4_b_1' => '9 4 B 1',
            '_9_4_b_2' => '9 4 B 2',
            '_9_4_b_3' => '9 4 B 3',
            '_9_4_b_4' => '9 4 B 4',
            'total' => 'Total',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $json = K9InstitusiJsonHelper::getJsonPenilaianKriteria();

        $indikator = [];

        foreach ($json->butir as $butir1) {
            foreach ($butir1->butir as $butir2) {
                if (!empty($butir2->butir)) {
                    foreach ($butir2->butir as $butir3) {
                        foreach ($butir3->indikators as $ind) {
                            $indikator[] = $ind->nomor;
                        }
                    }
                } else {
                    foreach ($butir2->indikators as $ind) {
                        $indikator[] = $ind->nomor;
                    }
                }
            }
        }

        $exclude = [
            'id',
            'id_akreditasi_institusi',
            'total',
            'status',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by'
        ];

        $skor = $this->hitung($this, $exclude, $indikator);
        $this->total = $skor;
        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[AkreditasiInstitusi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAkreditasiInstitusi()
    {
        return $this->hasOne(K9AkreditasiInstitusi::className(), ['id' => 'id_akreditasi_institusi']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
}
