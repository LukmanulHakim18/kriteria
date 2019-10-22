<?php

namespace common\models\kriteria9\lk;

use common\models\kriteria9\lk\fakultas\K9LkTemplateFakultas;
use common\models\kriteria9\lk\institusi\K9LkTemplateInstitusi;
use common\models\kriteria9\lk\prodi\K9LkTemplateProdi;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_lk_template".
 *
 * @property int $id
 * @property string $nomor_tabel
 * @property string $nama_file
 * @property string $untuk
 * @property int $created_at
 * @property int $updated_at
 *
 * @property K9LkTemplateFakultas[] $k9LkTemplateFakultas
 * @property K9LkTemplateInstitusi[] $k9LkTemplateInstitusis
 * @property K9LkTemplateProdi[] $k9LkTemplateProdis
 */
class K9LkTemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_lk_template';
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
            [['created_at', 'updated_at'], 'integer'],
            [['nomor_tabel', 'nama_file', 'untuk'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nomor_tabel' => 'Nomor Tabel',
            'nama_file' => 'Nama File',
            'untuk' => 'Untuk',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkTemplateFakultas()
    {
        return $this->hasMany(K9LkTemplateFakultas::className(), ['id_lk_template' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkTemplateInstitusis()
    {
        return $this->hasMany(K9LkTemplateInstitusi::className(), ['id_lk_template' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getK9LkTemplateProdis()
    {
        return $this->hasMany(K9LkTemplateProdi::className(), ['id_lk_template' => 'id']);
    }
}
