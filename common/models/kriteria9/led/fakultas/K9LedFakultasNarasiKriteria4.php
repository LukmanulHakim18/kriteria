<?php

namespace common\models\kriteria9\led\fakultas;

use common\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_led_fakultas_narasi_kriteria4".
 *
 * @property int $id
 * @property int $id_led_fakultas_kriteria4
 * @property string $_4_1
 * @property string $_4_2
 * @property string $_4_3
 * @property string $_4_4
 * @property string $_4_5
 * @property string $_4_6
 * @property string $_4_7
 * @property string $_4_8
 * @property string $_4_9
 * @property double $progress
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property K9LedFakultasKriteria4 $ledFakultasKriteria4
 */
class K9LedFakultasNarasiKriteria4 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_led_fakultas_narasi_kriteria4';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_led_fakultas_kriteria4', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['_4_1', '_4_2', '_4_3', '_4_4', '_4_5', '_4_6', '_4_7', '_4_8', '_4_9'], 'string'],
            [['progress'], 'number'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['id_led_fakultas_kriteria4'], 'exist', 'skipOnError' => true, 'targetClass' => K9LedFakultasKriteria4::className(), 'targetAttribute' => ['id_led_fakultas_kriteria4' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_led_fakultas_kriteria4' => 'Id Led Fakultas Kriteria4',
            '_4_1' => '4 1',
            '_4_2' => '4 2',
            '_4_3' => '4 3',
            '_4_4' => '4 4',
            '_4_5' => '4 5',
            '_4_6' => '4 6',
            '_4_7' => '4 7',
            '_4_8' => '4 8',
            '_4_9' => '4 9',
            'progress' => 'Progress',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLedFakultasKriteria4()
    {
        return $this->hasOne(K9LedFakultasKriteria4::className(), ['id' => 'id_led_fakultas_kriteria4']);
    }
}
