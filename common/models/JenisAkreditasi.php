<?php

namespace common\models;

use common\models\kriteria9\akreditasi\K9Akreditasi;
use Yii;

/**
 * This is the model class for table "jenis_akreditasi".
 *
 * @property int $id
 * @property string $nama
 * @property int $created_at
 * @property int $updated_at
 *
 * @property K9Akreditasi[] $k9Akreditasis
 */
class JenisAkreditasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jenis_akreditasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['nama'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9Akreditasis()
    {
        return $this->hasMany(K9Akreditasi::className(), ['id_jenis_akreditasi' => 'id']);
    }
}
