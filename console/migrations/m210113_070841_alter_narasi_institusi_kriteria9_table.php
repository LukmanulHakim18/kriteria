<?php

use yii\db\Migration;

/**
 * Class m210113_070841_alter_narasi_institusi_kriteria9_table
 */
class m210113_070841_alter_narasi_institusi_kriteria9_table extends Migration
{
    use \common\helpers\TextTypesTrait;

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%k9_led_institusi_narasi_kriteria9}}', '_9_1', '_9_4_a');
        $this->addColumn('{{%k9_led_institusi_narasi_kriteria9}}', '_9_4_b', $this->longText());
        $this->renameColumn('{{%k9_led_institusi_narasi_kriteria9}}', '_9_3', '_9_8');
        $this->renameColumn('{{%k9_led_institusi_narasi_kriteria9}}', '_9_4', '_9_7');
        $this->renameColumn('{{%k9_led_institusi_narasi_kriteria9}}', '_9_2', '_9_9');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%k9_led_institusi_narasi_kriteria9}}', '_9_4_a', '_9_1');
        $this->dropColumn('{{%k9_led_institusi_narasi_kriteria9}}', '_9_4_b');
        $this->renameColumn('{{%k9_led_institusi_narasi_kriteria9}}', '_9_8', '_9_3');
        $this->renameColumn('{{%k9_led_institusi_narasi_kriteria9}}', '_9_7', '_9_4');
        $this->renameColumn('{{%k9_led_institusi_narasi_kriteria9}}', '_9_9', '_9_2');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210113_070841_alter_narasi_institusi_kriteria9_table cannot be reverted.\n";

        return false;
    }
    */
}
