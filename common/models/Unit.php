<?php

namespace common\models;

use oxyaction\behaviors\RelatedPolymorphicBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "unit".
 *
 * @property int $id
 * @property string $nama
 * @property int $jenis
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Profil $profil
 */
class Unit extends \yii\db\ActiveRecord
{
    const UNIT = 'unit';
    const JENIS_UNIT = 0;
    const JENIS_LEMBAGA = 1;
    const JENIS_SATKER = 2;

    const JENIS = [
        self::JENIS_UNIT=>'Unit',
        self::JENIS_LEMBAGA=>'Lembaga',
        self::JENIS_SATKER=>'Satuan Kerja'
    ];
    public function getJenisString(){
        return self::JENIS[$this->jenis];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'unit';
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
            [['created_at', 'updated_at','jenis'], 'integer'],
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
            'jenis'=>\Yii::t('app','Jenis'),
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function actionProfil(){
        return $this->hasOne(Profil::class,['external_id'=>'id'])->andWhere(['type'=>self::UNIT]);
    }
}
