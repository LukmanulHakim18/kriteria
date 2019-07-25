<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profil_user".
 *
 * @property int $id
 * @property int $id_user
 * @property string $nama_lengkap
 * @property int $id_prodi
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ProgramStudi $prodi
 * @property User $user
 */
class ProfilUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profil_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'id_prodi', 'created_at', 'updated_at'], 'integer'],
            [['nama_lengkap'], 'string', 'max' => 255],
            [['id_prodi'], 'exist', 'skipOnError' => true, 'targetClass' => ProgramStudi::className(), 'targetAttribute' => ['id_prodi' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'nama_lengkap' => 'Nama Lengkap',
            'id_prodi' => 'Id Prodi',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProdi()
    {
        return $this->hasOne(ProgramStudi::className(), ['id' => 'id_prodi']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
}