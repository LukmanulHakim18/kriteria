<?php

namespace common\models\kriteria9\led\institusi;

use common\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "k9_led_institusi_narasi_kriteria6".
 *
 * @property int $id
 * @property int $id_led_institusi_kriteria6
 * @property string $_6_1
 * @property string $_6_2
 * @property string $_6_3
 * @property string $_6_4
 * @property string $_6_5
 * @property string $_6_6
 * @property string $_6_7
 * @property string $_6_8
 * @property string $_6_9
 * @property double $progress
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property K9LedInstitusiKriteria6 $ledInstitusiKriteria6
 */
class K9LedInstitusiNarasiKriteria6 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_led_institusi_narasi_kriteria6';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_led_institusi_kriteria6', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['_6_1', '_6_2', '_6_3', '_6_4', '_6_5', '_6_6', '_6_7', '_6_8', '_6_9'], 'string'],
            [['progress'], 'number'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['id_led_institusi_kriteria6'], 'exist', 'skipOnError' => true, 'targetClass' => K9LedInstitusiKriteria6::className(), 'targetAttribute' => ['id_led_institusi_kriteria6' => 'id']],
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
            'id_led_institusi_kriteria6' => 'Id Led Institusi Kriteria6',
            '_6_1' => '6 1',
            '_6_2' => '6 2',
            '_6_3' => '6 3',
            '_6_4' => '6 4',
            '_6_5' => '6 5',
            '_6_6' => '6 6',
            '_6_7' => '6 7',
            '_6_8' => '6 8',
            '_6_9' => '6 9',
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
    public function getLedInstitusiKriteria6()
    {
        return $this->hasOne(K9LedInstitusiKriteria6::className(), ['id' => 'id_led_institusi_kriteria6']);
    }
}
