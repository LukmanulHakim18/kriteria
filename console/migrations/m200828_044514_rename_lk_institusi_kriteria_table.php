<?php

use yii\db\Migration;

/**
 * Class m200828_044514_rename_lk_institusi_kriteria_table
 */
class m200828_044514_rename_lk_institusi_kriteria_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->renameTable('k9_lk_institusi_kriteria1','k9_lk_institusi_kriteria1_narasi');
        $this->renameTable('k9_lk_institusi_kriteria2','k9_lk_institusi_kriteria2_narasi');
        $this->renameTable('k9_lk_institusi_kriteria3','k9_lk_institusi_kriteria3_narasi');
        $this->renameTable('k9_lk_institusi_kriteria4','k9_lk_institusi_kriteria4_narasi');
        $this->renameTable('k9_lk_institusi_kriteria5','k9_lk_institusi_kriteria5_narasi');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->renameTable('k9_lk_institusi_kriteria1_narasi','k9_lk_institusi_kriteria1');
        $this->renameTable('k9_lk_institusi_kriteria2_narasi','k9_lk_institusi_kriteria2');
        $this->renameTable('k9_lk_institusi_kriteria3_narasi','k9_lk_institusi_kriteria3');
        $this->renameTable('k9_lk_institusi_kriteria4_narasi','k9_lk_institusi_kriteria4');
        $this->renameTable('k9_lk_institusi_kriteria5_narasi','k9_lk_institusi_kriteria5');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200828_044514_rename_lk_institusi_kriteria_table cannot be reverted.\n";

        return false;
    }
    */
}
