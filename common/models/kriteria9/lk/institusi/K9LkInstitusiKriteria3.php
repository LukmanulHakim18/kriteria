<?php

namespace common\models\kriteria9\lk\institusi;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_lk_institusi_kriteria3".
 *
 * @property int $id
 * @property int $id_lk_institusi
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
 * @property K9LkInstitusi $lkInstitusi
 * @property K9LkInstitusiKriteria3Detail[] $k9LkInstitusiKriteria3Details
 */
class K9LkInstitusiKriteria3 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_lk_institusi_kriteria3';
    }

    public function behaviors()
    {
        return [TimestampBehavior::class];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_lk_institusi', 'created_at', 'updated_at'], 'integer'],
            [['_3_a_1', '_3_a_2', '_3_a_3', '_3_a_4', '_3_b', '_3_c_1', '_3_c_2', '_3_d'], 'string'],
            [['progress'], 'number'],
            [['id_lk_institusi'], 'exist', 'skipOnError' => true, 'targetClass' => K9LkInstitusi::className(), 'targetAttribute' => ['id_lk_institusi' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_lk_institusi' => 'Id Lk Institusi',
            '_3_a_1' => '3 A 1',
            '_3_a_2' => '3 A 2',
            '_3_a_3' => '3 A 3',
            '_3_a_4' => '3 A 4',
            '_3_b' => '3 B',
            '_3_c_1' => '3 C 1',
            '_3_c_2' => '3 C 2',
            '_3_d' => '3 D',
            'progress' => 'Progress',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLkInstitusi()
    {
        return $this->hasOne(K9LkInstitusi::className(), ['id' => 'id_lk_institusi']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkInstitusiKriteria3Details()
    {
        return $this->hasMany(K9LkInstitusiKriteria3Detail::className(), ['id_lk_institusi_kriteria3' => 'id']);
    }
}
