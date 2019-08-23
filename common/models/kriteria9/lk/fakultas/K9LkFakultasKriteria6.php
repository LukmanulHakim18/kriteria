<?php

namespace common\models\kriteria9\lk\fakultas;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_lk_fakultas_kriteria6".
 *
 * @property int $id
 * @property int $id_lk_fakultas
 * @property double $progress
 * @property int $created_at
 * @property int $updated_at
 *
 * @property K9LkFakultas $lkFakultas
 * @property K9LkFakultasKriteria6Detail[] $k9LkFakultasKriteria6Details
 */
class K9LkFakultasKriteria6 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_lk_fakultas_kriteria6';
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
            [['id_lk_fakultas', 'created_at', 'updated_at'], 'integer'],
            [['progress'], 'number'],
            [['id_lk_fakultas'], 'exist', 'skipOnError' => true, 'targetClass' => K9LkFakultas::className(), 'targetAttribute' => ['id_lk_fakultas' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_lk_fakultas' => 'Id Lk Fakultas',
            'progress' => 'Progress',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLkFakultas()
    {
        return $this->hasOne(K9LkFakultas::className(), ['id' => 'id_lk_fakultas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkFakultasKriteria6Details()
    {
        return $this->hasMany(K9LkFakultasKriteria6Detail::className(), ['id_lk_fakultas_kriteria6' => 'id']);
    }
}
