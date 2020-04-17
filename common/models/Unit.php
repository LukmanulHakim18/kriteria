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
 */
class Unit extends \yii\db\ActiveRecord
{
    const UNIT = 'unit';
    const JENIS_UNIT = 0;
    const JENIS_LEMBAGA = 1;
    const JENIS_SATKER = 2;

    public function getJenisString(){
        $jenis = [
            self::JENIS_UNIT=>\Yii::t('app','Unit'),
            self::JENIS_LEMBAGA=>\Yii::t('app','Lembaga'),
            self::JENIS_SATKER=>\Yii::t('app','Satuan Kerja')
        ];
        return $jenis[$this->jenis];
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
            'polymorphic' => [
                'class' => RelatedPolymorphicBehavior::class,
                'polyRelations' => [
                    'profil' => Profil::class
                ],
                'polymorphicType' => self::UNIT,
            ]
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
}
