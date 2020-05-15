<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "berkas".
 *
 * @property int $id
 * @property int|null $external_id
 * @property string|null $type
 * @property string|null $nama_berkas
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property DetailBerkas[] $detailBerkas
 */
class Berkas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'berkas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['external_id', 'created_at', 'updated_at'], 'integer'],
            [['type', 'nama_berkas'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'external_id' => 'External ID',
            'type' => 'Type',
            'nama_berkas' => 'Nama Berkas',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[DetailBerkas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDetailBerkas()
    {
        return $this->hasMany(DetailBerkas::className(), ['id_berkas' => 'id']);
    }
}
