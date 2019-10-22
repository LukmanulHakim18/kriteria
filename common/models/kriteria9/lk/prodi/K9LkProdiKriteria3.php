<?php

namespace common\models\kriteria9\lk\prodi;

use common\helpers\kriteria9\K9ProdiProgressHelper;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_lk_prodi_kriteria3".
 *
 * @property int $id
 * @property int $id_lk_prodi
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
 * @property string $_3_b_5_1
 * @property string $_3_b_5_2
 * @property string $_3_b_5_3
 * @property string $_3_b_5_4
 * @property string $_3_b_6
 * @property string $_3_b_7
 *
 * @property K9LkProdi $lkProdi
 * @property K9LkProdiKriteria3Detail[] $k9LkProdiKriteria3Details
 */
class K9LkProdiKriteria3 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_lk_prodi_kriteria3';
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
            [['id_lk_prodi', 'created_at', 'updated_at'], 'integer'],
            [['progress'], 'number'],
            [['_3_a_1', '_3_a_2', '_3_a_3', '_3_a_4', '_3_a_5', '_3_b_1', '_3_b_2', '_3_b_3', '_3_b_4', '_3_b_5_1', '_3_b_5_2', '_3_b_5_3', '_3_b_5_4', '_3_b_6', '_3_b_7'], 'string'],
            [['id_lk_prodi'], 'exist', 'skipOnError' => true, 'targetClass' => K9LkProdi::className(), 'targetAttribute' => ['id_lk_prodi' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_lk_prodi' => 'Id Lk Prodi',
            '_3_a_1' => '3 A 1',
            '_3_a_2' => '3 A 2',
            '_3_a_3' => '3 A 3',
            '_3_a_4' => '3 A 4',
            '_3_a_5' => '3 A 5',
            '_3_b_1' => '3 B 1',
            '_3_b_2' => '3 B 2',
            '_3_b_3' => '3 B 3',
            '_3_b_4' => '3 B 4',
            '_3_b_5_1' => '3 B 5 1',
            '_3_b_5_2' => '3 B 5 2',
            '_3_b_5_3' => '3 B 5 3',
            '_3_b_5_4' => '3 B 5 4',
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
    public function getLkProdi()
    {
        return $this->hasOne(K9LkProdi::className(), ['id' => 'id_lk_prodi']);
    }

    public function updateProgress()
    {
        $dokumen = K9ProdiProgressHelper::getDokumenLkProgress($this->id_lk_prodi, $this->getK9LkProdiKriteria3Details(), 3);

        $progress = round(($dokumen) / 1, 2);
        $this->progress = $progress;
        $this->save(false);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkProdiKriteria3Details()
    {
        return $this->hasMany(K9LkProdiKriteria3Detail::className(), ['id_lk_prodi_kriteria3' => 'id']);
    }
}
