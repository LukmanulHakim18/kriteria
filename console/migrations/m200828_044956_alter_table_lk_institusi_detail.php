<?php

use yii\db\Migration;

/**
 * Class m200828_044956_alter_table_lk_institusi_detail
 */
class m200828_044956_alter_table_lk_institusi_detail extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-k9_lk_institusi_kt1_detail-k9_lk_institusi_kt1','{{k9_lk_institusi_kriteria1_detail}}');
        $this->dropForeignKey('fk-k9_lk_institusi_kt2_detail-k9_lk_institusi_kt2','{{k9_lk_institusi_kriteria2_detail}}');
        $this->dropForeignKey('fk-k9_lk_institusi_kt3_detail-k9_lk_institusi_kt3','{{k9_lk_institusi_kriteria3_detail}}');
        $this->dropForeignKey('fk-k9_lk_institusi_kt4_detail-k9_lk_institusi_kt4','{{k9_lk_institusi_kriteria4_detail}}');
        $this->dropForeignKey('fk-k9_lk_institusi_kt5_detail-k9_lk_institusi_kt5','{{k9_lk_institusi_kriteria5_detail}}');

        $this->addForeignKey('fk-k9_lk_institusi_kt1_detail-k9_lk_institusi_kt1', '{{%k9_lk_institusi_kriteria1_detail}}', 'id_lk_institusi_kriteria1', '{{%k9_lk_institusi_kriteria1}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk-k9_lk_institusi_kt2_detail-k9_lk_institusi_kt2', '{{%k9_lk_institusi_kriteria2_detail}}', 'id_lk_institusi_kriteria2', '{{%k9_lk_institusi_kriteria2}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk-k9_lk_institusi_kt3_detail-k9_lk_institusi_kt3', '{{%k9_lk_institusi_kriteria3_detail}}', 'id_lk_institusi_kriteria3', '{{%k9_lk_institusi_kriteria3}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk-k9_lk_institusi_kt4_detail-k9_lk_institusi_kt4', '{{%k9_lk_institusi_kriteria4_detail}}', 'id_lk_institusi_kriteria4', '{{%k9_lk_institusi_kriteria4}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk-k9_lk_institusi_kt5_detail-k9_lk_institusi_kt5', '{{%k9_lk_institusi_kriteria5_detail}}', 'id_lk_institusi_kriteria5', '{{%k9_lk_institusi_kriteria5}}', 'id', 'cascade', 'cascade');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-k9_lk_institusi_kt1_detail-k9_lk_institusi_kt1','{{k9_lk_institusi_kriteria1_detail}}');
        $this->dropForeignKey('fk-k9_lk_institusi_kt2_detail-k9_lk_institusi_kt2','{{k9_lk_institusi_kriteria2_detail}}');
        $this->dropForeignKey('fk-k9_lk_institusi_kt3_detail-k9_lk_institusi_kt3','{{k9_lk_institusi_kriteria3_detail}}');
        $this->dropForeignKey('fk-k9_lk_institusi_kt4_detail-k9_lk_institusi_kt4','{{k9_lk_institusi_kriteria4_detail}}');
        $this->dropForeignKey('fk-k9_lk_institusi_kt5_detail-k9_lk_institusi_kt5','{{k9_lk_institusi_kriteria5_detail}}');

        $this->addForeignKey('fk-k9_lk_institusi_kt1_detail-k9_lk_institusi_kt1', '{{%k9_lk_institusi_kriteria1_detail}}', 'id_lk_institusi_kriteria1', '{{%k9_lk_institusi_kriteria1}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk-k9_lk_institusi_kt2_detail-k9_lk_institusi_kt2', '{{%k9_lk_institusi_kriteria2_detail}}', 'id_lk_institusi_kriteria2', '{{%k9_lk_institusi_kriteria2}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk-k9_lk_institusi_kt3_detail-k9_lk_institusi_kt3', '{{%k9_lk_institusi_kriteria3_detail}}', 'id_lk_institusi_kriteria3', '{{%k9_lk_institusi_kriteria3}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk-k9_lk_institusi_kt4_detail-k9_lk_institusi_kt4', '{{%k9_lk_institusi_kriteria4_detail}}', 'id_lk_institusi_kriteria4', '{{%k9_lk_institusi_kriteria4}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk-k9_lk_institusi_kt5_detail-k9_lk_institusi_kt5', '{{%k9_lk_institusi_kriteria5_detail}}', 'id_lk_institusi_kriteria5', '{{%k9_lk_institusi_kriteria5}}', 'id', 'cascade', 'cascade');



    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200828_044956_alter_table_lk_institusi_detail cannot be reverted.\n";

        return false;
    }
    */
}
