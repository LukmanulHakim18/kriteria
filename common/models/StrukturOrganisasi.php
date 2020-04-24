<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "struktur_organisasi".
 *
 * @property int $id
 * @property int|null $id_profil
 * @property int|null $parent
 * @property string|null $jabatan
 * @property string|null $nama
 * @property string|null $nipnik
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Profil $profil
 * @property StrukturOrganisasi $parentModel
 * @property StrukturOrganisasi[] $children
 */
class StrukturOrganisasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'struktur_organisasi';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ] ;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_profil', 'parent', 'created_at', 'updated_at'], 'integer'],
            [['jabatan', 'nama'], 'string', 'max' => 255],
            [['nipnik'], 'string', 'max' => 20],
            [['id_profil'], 'exist', 'skipOnError' => true, 'targetClass' => Profil::className(), 'targetAttribute' => ['id_profil' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_profil' => 'Id Profil',
            'parent' => 'Parent',
            'jabatan' => 'Jabatan',
            'nama' => 'Nama',
            'nipnik' => 'Nipnik',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Profil]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfil()
    {
        return $this->hasOne(Profil::className(), ['id' => 'id_profil']);
    }

    public function getParentModel(){
        return $this->hasOne(self::class,['parent'=>'id']);
    }

    public function getChildren(){
        return $this->hasMany(self::class,['id'=>'parent']);
    }
}
