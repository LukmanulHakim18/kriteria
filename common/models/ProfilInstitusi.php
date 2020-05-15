<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profil_institusi".
 *
 * @property int $id
 * @property string|null $nama
 * @property string|null $isi
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class ProfilInstitusi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profil_institusi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['isi'], 'string'],
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
            'isi' => 'Isi',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
