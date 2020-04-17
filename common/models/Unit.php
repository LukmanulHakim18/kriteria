<?php

namespace common\models;

use oxyaction\behaviors\RelatedPolymorphicBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "unit".
 *
 * @property int $id
 * @property string $nama
 * @property int $created_at
 * @property int $updated_at
 */
class Unit extends \yii\db\ActiveRecord
{
    const UNIT = 'unit';

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
}
