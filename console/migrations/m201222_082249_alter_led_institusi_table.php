<?php

use yii\db\Migration;

/**
 * Class m201222_082249_alter_led_institusi_table
 */
class m201222_082249_alter_led_institusi_table extends Migration
{
    use \common\helpers\TextTypesTrait;

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // delete 1.8 - 1.9
        $this->dropColumn('{{%k9_led_institusi_narasi_kriteria1}}', '_1_8');
        $this->dropColumn('{{%k9_led_institusi_narasi_kriteria1}}', '_1_9');

        // change 2.4 to 2.4.a
        $this->renameColumn('{{%k9_led_institusi_narasi_kriteria2}}', '_2_4', '_2_4_a');

        // add 2.4.b - 2.4.e
        $this->addColumn('{{%k9_led_institusi_narasi_kriteria2}}', '_2_4_b', $this->longText());
        $this->addColumn('{{%k9_led_institusi_narasi_kriteria2}}', '_2_4_c', $this->longText());
        $this->addColumn('{{%k9_led_institusi_narasi_kriteria2}}', '_2_4_d', $this->longText());
        $this->addColumn('{{%k9_led_institusi_narasi_kriteria2}}', '_2_4_e', $this->longText());

        // change 3.4 to 3.4.a
        $this->renameColumn('{{%k9_led_institusi_narasi_kriteria3}}', '_3_4', '_3_4_a');

        // add 3.4.b
        $this->addColumn('{{%k9_led_institusi_narasi_kriteria3}}', '_3_4_b', $this->longText());

        // change 4.4 to 4.4.a
        $this->renameColumn('{{%k9_led_institusi_narasi_kriteria4}}', '_4_4', '_4_4_a');

        // add 4.4.b - 4.4.c
        $this->addColumn('{{%k9_led_institusi_narasi_kriteria4}}', '_4_4_b', $this->longText());
        $this->addColumn('{{%k9_led_institusi_narasi_kriteria4}}', '_4_4_c', $this->longText());

        // change 5.4 to 5.4.a
        $this->renameColumn('{{%k9_led_institusi_narasi_kriteria5}}', '_5_4', '_5_4_a');

        // add 5.4.b - 5.4.c
        $this->addColumn('{{%k9_led_institusi_narasi_kriteria5}}', '_5_4_b', $this->longText());
        $this->addColumn('{{%k9_led_institusi_narasi_kriteria5}}', '_5_4_c', $this->longText());

        // change 6.4 to 6.4.a
        $this->renameColumn('{{%k9_led_institusi_narasi_kriteria6}}', '_6_4', '_6_4_a');

        // add 6.4.b - 6.4.d
        $this->addColumn('{{%k9_led_institusi_narasi_kriteria6}}', '_6_4_b', $this->longText());
        $this->addColumn('{{%k9_led_institusi_narasi_kriteria6}}', '_6_4_c', $this->longText());
        $this->addColumn('{{%k9_led_institusi_narasi_kriteria6}}', '_6_4_d', $this->longText());

        //remove 9.7 -  9.9
        $this->dropColumn('{{%k9_led_institusi_narasi_kriteria9}}', '_9_7');
        $this->dropColumn('{{%k9_led_institusi_narasi_kriteria9}}', '_9_8');
        $this->dropColumn('{{%k9_led_institusi_narasi_kriteria9}}', '_9_9');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // delete 1.8 - 1.9
        $this->addColumn('{{%k9_led_institusi_narasi_kriteria1}}', '_1_8', $this->longText());
        $this->addColumn('{{%k9_led_institusi_narasi_kriteria1}}', '_1_9', $this->longText());

        // change 2.4 to 2.4.a
        $this->renameColumn('{{%k9_led_institusi_narasi_kriteria2}}', '_2_4_a', '_2_4');

        // add 2.4.b - 2.4.e
        $this->dropColumn('{{%k9_led_institusi_narasi_kriteria2}}', '_2_4_b');
        $this->dropColumn('{{%k9_led_institusi_narasi_kriteria2}}', '_2_4_c');
        $this->dropColumn('{{%k9_led_institusi_narasi_kriteria2}}', '_2_4_d');
        $this->dropColumn('{{%k9_led_institusi_narasi_kriteria2}}', '_2_4_e');

        // change 3.4 to 3.4.a
        $this->renameColumn('{{%k9_led_institusi_narasi_kriteria3}}', '_3_4', '_3_4_a');

        // add 3.4.b
        $this->dropColumn('{{%k9_led_institusi_narasi_kriteria3}}', '_3_4_b');

        // change 4.4 to 4.4.a
        $this->renameColumn('{{%k9_led_institusi_narasi_kriteria4}}', '_4_4', '_4_4_a');

        // add 4.4.b - 4.4.c
        $this->dropColumn('{{%k9_led_institusi_narasi_kriteria4}}', '_4_4_b');
        $this->dropColumn('{{%k9_led_institusi_narasi_kriteria4}}', '_4_4_c');

        // change 5.4 to 5.4.a
        $this->renameColumn('{{%k9_led_institusi_narasi_kriteria5}}', '_5_4', '_5_4_a');

        // add 5.4.b - 5.4.c
        $this->dropColumn('{{%k9_led_institusi_narasi_kriteria5}}', '_5_4_b');
        $this->dropColumn('{{%k9_led_institusi_narasi_kriteria5}}', '_5_4_c');

        // change 6.4 to 6.4.a
        $this->renameColumn('{{%k9_led_institusi_narasi_kriteria6}}', '_6_4', '_6_4_a');

        // add 6.4.b - 6.4.d
        $this->dropColumn('{{%k9_led_institusi_narasi_kriteria6}}', '_6_4_b');
        $this->dropColumn('{{%k9_led_institusi_narasi_kriteria6}}', '_6_4_c');
        $this->dropColumn('{{%k9_led_institusi_narasi_kriteria6}}', '_6_4_d');

        //remove 9.7 -  9.9
        $this->addColumn('{{%k9_led_institusi_narasi_kriteria9}}', '_9_7', $this->longText());
        $this->addColumn('{{%k9_led_institusi_narasi_kriteria9}}', '_9_8', $this->longText());
        $this->addColumn('{{%k9_led_institusi_narasi_kriteria9}}', '_9_9', $this->longText());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201222_082249_alter_led_institusi_table cannot be reverted.\n";

        return false;
    }
    */
}
