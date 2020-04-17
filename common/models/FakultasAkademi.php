<?php

namespace common\models;

use oxyaction\behaviors\RelatedPolymorphicBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "fakultas_akademi".
 *
 * @property int $id
 * @property string $kode
 * @property string $nama
 * @property string $dekan
 * @property int $jenis
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ProgramStudi[] $programStudis
 */
class FakultasAkademi extends \yii\db\ActiveRecord
{
    const FAKULTAS_AKADEMI = 'fakultasAkademi';
    const JENIS_FAKULTAS = 1;
    const JENIS_PASCA = 2;
    const JENIS_AKADEMI = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fakultas_akademi';
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
                'polymorphicType' => self::FAKULTAS_AKADEMI,
            ]
        ];
    }

    public function getJenisString(){
        $jenis = [
            self::JENIS_AKADEMI=> \Yii::t('app','Akademi'),
            self::JENIS_FAKULTAS => \Yii::t('app','Fakultas'),
            self::JENIS_PASCA=>\Yii::t('app','Pascasarjana')
        ];
        return $jenis[$this->jenis];
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
            'nama' => 'Nama Fakultas',
            'dekan' => 'Dekan/Direktur',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramStudis()
    {
        return $this->hasMany(ProgramStudi::className(), ['id_fakultas_akademi' => 'id']);
    }
}
