<?php

use yii\db\Migration;

/**
 * Class m200828_080808_add_column_to_lk_institusi
 */
class m200828_080808_add_column_to_lk_institusi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%k9_lk_institusi_kriteria5_narasi}}','_5_d',$this->text());
        $this->addColumn('{{%k9_lk_institusi_kriteria5_narasi}}','_5_e',$this->text());
        $this->dropColumn('{{%k9_lk_institusi_kriteria5_narasi}}','_5_g_2');
        $this->renameColumn('{{%k9_lk_institusi_kriteria5_narasi}}','_5_g_1','_5_g');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%k9_lk_institusi_kriteria5_narasi}}','_5_g','_5_g_1');
        $this->addColumn('{{%k9_lk_institusi_kriteria5_narasi}}','_5_g_2',$this->text());
        $this->dropColumn('{{%k9_lk_institusi_kriteria5_narasi}}','_5_e');
        $this->dropColumn('{{%k9_lk_institusi_kriteria5_narasi}}','_5_d');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200828_080808_add_column_to_lk_institusi cannot be reverted.\n";

        return false;
    }
    */
}
