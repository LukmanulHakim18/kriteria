<?php

namespace common\models\kriteria9\led\institusi;

use Yii;

/**
 * This is the model class for table "k9_led_institusi_narasi_profil_institusi".
 *
 * @property int $id
 * @property int|null $id_led_institusi
 * @property string|null $_1
 * @property string|null $_2
 * @property string|null $_3
 * @property string|null $_4
 * @property string|null $_5
 * @property string|null $_6
 * @property string|null $_7
 * @property string|null $_8
 * @property float|null $progress
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property K9LedInstitusi $ledInstitusi
 */
class K9LedInstitusiNarasiProfilInstitusi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'k9_led_institusi_narasi_profil_institusi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_led_institusi', 'created_at', 'updated_at'], 'integer'],
            [['_1', '_2', '_3', '_4', '_5', '_6', '_7', '_8'], 'string'],
            [['progress'], 'number'],
            [['id_led_institusi'], 'exist', 'skipOnError' => true, 'targetClass' => K9LedInstitusi::className(), 'targetAttribute' => ['id_led_institusi' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_led_institusi' => 'Id Led Institusi',
            '_1' => '1',
            '_2' => '2',
            '_3' => '3',
            '_4' => '4',
            '_5' => '5',
            '_6' => '6',
            '_7' => '7',
            '_8' => '8',
            'progress' => 'Progress',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[LedInstitusi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLedInstitusi()
    {
        return $this->hasOne(K9LedInstitusi::className(), ['id' => 'id_led_institusi']);
    }
}
