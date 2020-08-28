<?php

namespace common\models\kriteria9\lk\institusi;

use common\helpers\kriteria9\K9InstitusiProgressHelper;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_lk_institusi_kriteria1".
 *
 * @property int $id
 * @property int $id_lk_institusi_kriteria1
 * @property string $_1_a
 * @property string $_1_b
 * @property string $_1_c
 * @property double $progress
 * @property int $created_at
 * @property int $updated_at
 *
 * @property K9LkInstitusiKriteria1 $lkInstitusiKriteria1
 */
class K9LkInstitusiKriteria1Narasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_lk_institusi_kriteria1_narasi';
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
            [['id_lk_institusi_kriteria1', 'created_at', 'updated_at'], 'integer'],
            [['progress'], 'number'],
            [['_1_a', '_1_b', '_1_c'], 'string'],
            [['id_lk_institusi_kriteria1'], 'exist', 'skipOnError' => true, 'targetClass' => K9LkInstitusiKriteria1::className(), 'targetAttribute' => ['id_lk_institusi_kriteria1' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_lk_institusi_kriteria1' => 'Id Lk Institusi',
            '_1_a' => '1 A',
            '_1_b' => '1 B',
            '_1_c' => '1 C',
            'progress' => 'Progress',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLkInstitusiKriteria1()
    {
        return $this->hasOne(K9LkInstitusiKriteria1::className(), ['id' => 'id_lk_institusi_kriteria1']);
    }

}
