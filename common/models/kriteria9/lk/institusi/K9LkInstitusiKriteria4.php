<?php

namespace common\models\kriteria9\lk\institusi;

use common\helpers\kriteria9\K9InstitusiProgressHelper;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_lk_institusi_kriteria4".
 *
 * @property int $id
 * @property int $id_lk_institusi
 * @property string $_4_a
 * @property string $_4_b
 * @property double $progress
 * @property int $created_at
 * @property int $updated_at
 *
 * @property K9LkInstitusi $lkInstitusi
 * @property K9LkInstitusiKriteria4Detail[] $k9LkInstitusiKriteria4Details
 */
class K9LkInstitusiKriteria4 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_lk_institusi_kriteria4';
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
            [['id_lk_institusi', 'created_at', 'updated_at'], 'integer'],
            [['progress'], 'number'],
            [['_4_a', '_4_b'], 'string'],
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
    public function getLkInstitusi()
    {
        return $this->hasOne(K9LkInstitusi::className(), ['id' => 'id_lk_institusi']);
    }

    public function updateProgress()
    {

        $dokumen = K9InstitusiProgressHelper::getDokumenLkProgress($this->id_lk_institusi, $this->getK9LkInstitusiKriteria4Details(), 4);

        $progress = round(($dokumen) / 1, 2);
        $this->progress = $progress;
        $this->save(false);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkInstitusiKriteria4Details()
    {
        return $this->hasMany(K9LkInstitusiKriteria4Detail::className(), ['id_lk_institusi_kriteria4' => 'id']);
    }
}
