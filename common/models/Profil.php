<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "profil".
 *
 * @property int $id
 * @property int $external_id
 * @property string $type
 * @property string $visi
 * @property string $misi
 * @property string $tujuan
 * @property string $sasaran
 * @property string $motto
 * @property string $sambutan
 * @property int $created_at
 * @property int $updated_at
 *
 * @property StrukturOrganisasi $sturktur
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

    public function behaviors()
    {
        return [TimestampBehavior::class];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['external_id', 'created_at', 'updated_at'], 'integer'],
            [['sambutan'], 'string'],
            [['type', 'visi', 'misi', 'tujuan', 'sasaran', 'motto'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'external_id' => 'Id Foreign Key',
            'type' => 'Tipe',
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

    public function getStrukturs(){
        return $this->hasMany(StrukturOrganisasi::class,['id_profil'=>'id']);
    }
}
