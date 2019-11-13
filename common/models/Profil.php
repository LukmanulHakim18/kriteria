<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profil".
 *
 * @property int $id
 * @property int $id_foreign_key
 * @property string $tipe
 * @property string $visi
 * @property string $misi
 * @property string $tujuan
 * @property string $sasaran
 * @property string $motto
 * @property string $sambutan
 * @property int $created_at
 * @property int $updated_at
 */
class Profil extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profil';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_foreign_key', 'created_at', 'updated_at'], 'integer'],
            [['sambutan'], 'string'],
            [['tipe', 'visi', 'misi', 'tujuan', 'sasaran', 'motto'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_foreign_key' => 'Id Foreign Key',
            'tipe' => 'Tipe',
            'visi' => 'Visi',
            'misi' => 'Misi',
            'tujuan' => 'Tujuan',
            'sasaran' => 'Sasaran',
            'motto' => 'Motto',
            'sambutan' => 'Sambutan',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
