<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fakultas_akademi".
 *
 * @property int $id
 * @property string $kode
 * @property string $nama
 * @property string $dekan
 * @property int $created_at
 * @property int $updated_at
 *
 * @property K9LedFakultas[] $k9LedFakultas
 * @property K9LkFakultas[] $k9LkFakultas
 * @property ProgramStudi[] $programStudis
 */
class FakultasAkademi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fakultas_akademi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['kode', 'nama', 'dekan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode' => 'Kode',
            'nama' => 'Nama',
            'dekan' => 'Dekan',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LedFakultas()
    {
        return $this->hasMany(K9LedFakultas::className(), ['id_akreditasi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkFakultas()
    {
        return $this->hasMany(K9LkFakultas::className(), ['id_fakultas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramStudis()
    {
        return $this->hasMany(ProgramStudi::className(), ['id_fakultas_akademi' => 'id']);
    }
}
