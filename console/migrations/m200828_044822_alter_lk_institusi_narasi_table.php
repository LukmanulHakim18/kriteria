<?php

use yii\db\Migration;

/**
 * Class m200828_044822_alter_lk_institusi_narasi_table
 */
class m200828_044822_alter_lk_institusi_narasi_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-k9_lk_institusi_kt1-k9_lk_institusi','{{k9_lk_institusi_kriteria1_narasi}}');
        $this->dropForeignKey('fk-k9_lk_institusi_kt2-k9_lk_institusi','{{k9_lk_institusi_kriteria2_narasi}}');
        $this->dropForeignKey('fk-k9_lk_institusi_kt3-k9_lk_institusi','{{k9_lk_institusi_kriteria3_narasi}}');
        $this->dropForeignKey('fk-k9_lk_institusi_kt4-k9_lk_institusi','{{k9_lk_institusi_kriteria4_narasi}}');
        $this->dropForeignKey('fk-k9_lk_institusi_kt5-k9_lk_institusi','{{k9_lk_institusi_kriteria5_narasi}}');


        $this->renameColumn('{{k9_lk_institusi_kriteria1_narasi}}','id_lk_institusi','id_lk_institusi_kriteria1');
        $this->renameColumn('{{k9_lk_institusi_kriteria2_narasi}}','id_lk_institusi','id_lk_institusi_kriteria2');
        $this->renameColumn('{{k9_lk_institusi_kriteria3_narasi}}','id_lk_institusi','id_lk_institusi_kriteria3');
        $this->renameColumn('{{k9_lk_institusi_kriteria4_narasi}}','id_lk_institusi','id_lk_institusi_kriteria4');
        $this->renameColumn('{{k9_lk_institusi_kriteria5_narasi}}','id_lk_institusi','id_lk_institusi_kriteria5');

        $this->addForeignKey('fk-k9_lk_ins_k1_n-k9_lk_ins_k1','{{%k9_lk_institusi_kriteria1_narasi}}','id_lk_institusi_kriteria1','{{%k9_lk_institusi_kriteria1}}','id','cascade','cascade');
        $this->addForeignKey('fk-k9_lk_ins_k2_n-k9_lk_ins_k2','{{%k9_lk_institusi_kriteria2_narasi}}','id_lk_institusi_kriteria2','{{%k9_lk_institusi_kriteria2}}','id','cascade','cascade');
        $this->addForeignKey('fk-k9_lk_ins_k3_n-k9_lk_ins_k3','{{%k9_lk_institusi_kriteria3_narasi}}','id_lk_institusi_kriteria3','{{%k9_lk_institusi_kriteria3}}','id','cascade','cascade');
        $this->addForeignKey('fk-k9_lk_ins_k4_n-k9_lk_ins_k4','{{%k9_lk_institusi_kriteria4_narasi}}','id_lk_institusi_kriteria4','{{%k9_lk_institusi_kriteria4}}','id','cascade','cascade');
        $this->addForeignKey('fk-k9_lk_ins_k5_n-k9_lk_ins_k5','{{%k9_lk_institusi_kriteria5_narasi}}','id_lk_institusi_kriteria5','{{%k9_lk_institusi_kriteria5}}','id','cascade','cascade');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-k9_lk_ins_k1_n-k9_lk_ins_k1','{{%k9_lk_institusi_kriteria1_narasi}}');
        $this->dropForeignKey('fk-k9_lk_ins_k2_n-k9_lk_ins_k2','{{%k9_lk_institusi_kriteria2_narasi}}');
        $this->dropForeignKey('fk-k9_lk_ins_k3_n-k9_lk_ins_k3','{{%k9_lk_institusi_kriteria3_narasi}}');
        $this->dropForeignKey('fk-k9_lk_ins_k4_n-k9_lk_ins_k4','{{%k9_lk_institusi_kriteria4_narasi}}');
        $this->dropForeignKey('fk-k9_lk_ins_k5_n-k9_lk_ins_k5','{{%k9_lk_institusi_kriteria5_narasi}}');


        $this->renameColumn('{{k9_lk_institusi_kriteria1_narasi}}','id_lk_institusi_kriteria1','id_lk_institusi');
        $this->renameColumn('{{k9_lk_institusi_kriteria2_narasi}}','id_lk_institusi_kriteria2','id_lk_institusi');
        $this->renameColumn('{{k9_lk_institusi_kriteria3_narasi}}','id_lk_institusi_kriteria3','id_lk_institusi');
        $this->renameColumn('{{k9_lk_institusi_kriteria4_narasi}}','id_lk_institusi_kriteria4','id_lk_institusi');
        $this->renameColumn('{{k9_lk_institusi_kriteria5_narasi}}','id_lk_institusi_kriteria5','id_lk_institusi');



        $this->addForeignKey('fk-k9_lk_institusi_kt1-k9_lk_institusi', '{{k9_lk_institusi_kriteria1_narasi}}', 'id_lk_institusi', '{{%k9_lk_institusi}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk-k9_lk_institusi_kt2-k9_lk_institusi', '{{k9_lk_institusi_kriteria2_narasi}}', 'id_lk_institusi', '{{%k9_lk_institusi}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk-k9_lk_institusi_kt3-k9_lk_institusi', '{{k9_lk_institusi_kriteria3_narasi}}', 'id_lk_institusi', '{{%k9_lk_institusi}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk-k9_lk_institusi_kt4-k9_lk_institusi', '{{k9_lk_institusi_kriteria4_narasi}}', 'id_lk_institusi', '{{%k9_lk_institusi}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk-k9_lk_institusi_kt5-k9_lk_institusi', '{{k9_lk_institusi_kriteria5_narasi}}', 'id_lk_institusi', '{{%k9_lk_institusi}}', 'id', 'cascade', 'cascade');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200828_044822_alter_lk_institusi_narasi_table cannot be reverted.\n";

        return false;
    }
    */
}
