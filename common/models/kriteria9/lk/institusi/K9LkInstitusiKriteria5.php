<?php

namespace common\models\kriteria9\lk\institusi;

use common\helpers\kriteria9\K9InstitusiProgressHelper;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_lk_institusi_kriteria5".
 *
 * @property int $id
 * @property int $id_lk_institusi
 * @property double $progress
 * @property int $created_at
 * @property int $updated_at
 *
 * @property K9LkInstitusi $lkInstitusi
 * @property K9LkInstitusiKriteria5Detail[] $k9LkInstitusiKriteria5Details
 */
class K9LkInstitusiKriteria5 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_lk_institusi_kriteria5';
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
    public function getK9LkInstitusiKriteria5Details()
    {
        return $this->hasMany(K9LkInstitusiKriteria5Detail::className(), ['id_lk_institusi_kriteria5' => 'id']);
    }

    public function updateProgress()
    {

        $dokumen = K9InstitusiProgressHelper::getDokumenLkProgress($this->id_lk_institusi,$this->getK9LkInstitusiKriteria5Details(), 5);

        $progress = round(($dokumen)/1,2);
        $this->progress = $progress;
        $this->save(false);
    }
}
