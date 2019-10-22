<?php

namespace common\models\kriteria9\lk\fakultas;

use common\models\kriteria9\lk\K9LkTemplate;
use common\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_lk_template_fakultas".
 *
 * @property int $id
 * @property int $id_lk_fakultas
 * @property int $id_lk_template
 * @property string $nama_file
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property K9LkFakultas $lkFakultas
 * @property K9LkTemplate $lkTemplate
 * @property User $createdBy
 * @property User $updatedBy
 */
class K9LkTemplateFakultas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_lk_template_fakultas';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_lk_fakultas', 'id_lk_template', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['nama_file'], 'string', 'max' => 255],
            [['id_lk_fakultas'], 'exist', 'skipOnError' => true, 'targetClass' => K9LkFakultas::className(), 'targetAttribute' => ['id_lk_fakultas' => 'id']],
            [['id_lk_template'], 'exist', 'skipOnError' => true, 'targetClass' => K9LkTemplate::className(), 'targetAttribute' => ['id_lk_template' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_lk_fakultas' => 'Id Lk Fakultas',
            'id_lk_template' => 'Id Lk Template',
            'nama_file' => 'Nama File',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLkFakultas()
    {
        return $this->hasOne(K9LkFakultas::className(), ['id' => 'id_lk_fakultas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLkTemplate()
    {
        return $this->hasOne(K9LkTemplate::className(), ['id' => 'id_lk_template']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
}
