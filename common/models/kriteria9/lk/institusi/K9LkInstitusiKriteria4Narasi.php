<?php

namespace common\models\kriteria9\lk\institusi;

use common\helpers\kriteria9\K9InstitusiProgressHelper;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_lk_institusi_kriteria4".
 *
 * @property int $id
 * @property int $id_lk_institusi_kriteria4
 * @property string $_4_a
 * @property string $_4_b
 * @property double $progress
 * @property int $created_at
 * @property int $updated_at
 *
 * @property K9LkInstitusiKriteria4 $lkInstitusiKriteria4
 */
class K9LkInstitusiKriteria4Narasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_lk_institusi_kriteria4_narasi';
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
            [['id_lk_institusi_kriteria4', 'created_at', 'updated_at'], 'integer'],
            [['progress'], 'number'],
            [['_4_a', '_4_b'], 'string'],
            [['id_lk_institusi_kriteria4'], 'exist', 'skipOnError' => true, 'targetClass' => K9LkInstitusiKriteria4::className(), 'targetAttribute' => ['id_lk_institusi_kriteria4' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_lk_institusi_kriteria4' => 'Id Lk Institusi',
            '_4_a' => '4 A',
            '_4_b' => '4 B',
            'progress' => 'Progress',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLkInstitusiKriteria4()
    {
        return $this->hasOne(K9LkInstitusiKriteria4::className(), ['id' => 'id_lk_institusi_kriteria4']);
    }
}
