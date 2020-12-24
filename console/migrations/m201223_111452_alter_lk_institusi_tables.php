<?php

use yii\db\Migration;

/**
 * Class m201223_111452_alter_lk_institusi_tables
 */
class m201223_111452_alter_lk_institusi_tables extends Migration
{
    use \common\helpers\TextTypesTrait;

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //rename _1_a ke 1_a_1
        $this->renameColumn('{{%k9_lk_institusi_kriteria1_narasi}}', '_1_a', '_1_a__1');

        //create _1_a_2 - _1_a_3
        $this->addColumn('{{%k9_lk_institusi_kriteria1_narasi}}', '_1_a__2', $this->longText());
        $this->addColumn('{{%k9_lk_institusi_kriteria1_narasi}}', '_1_a__3', $this->longText());

        //create ref-5.d.1-5.d.2-5.e.2
        $this->addColumn('{{%k9_lk_institusi_kriteria5_narasi}}', 'ref__5_d_1__5_d_2__5_e_2', $this->longText());

        //create ref-5.e.1
        $this->addColumn('{{%k9_lk_institusi_kriteria5_narasi}}', 'ref__5_e_1', $this->longText());

        //rename _5_h jadi _5_h__1
        $this->renameColumn('{{%k9_lk_institusi_kriteria5_narasi}}', '_5_h', '_5_h__1');

        //create _5_h__2 - _5_h__4
        $this->addColumn('{{%k9_lk_institusi_kriteria5_narasi}}', '_5_h__2', $this->longText());
        $this->addColumn('{{%k9_lk_institusi_kriteria5_narasi}}', '_5_h__3', $this->longText());
        $this->addColumn('{{%k9_lk_institusi_kriteria5_narasi}}', '_5_h__4', $this->longText());
        //hapus _5_d dan _5_e
        $this->dropColumn('{{%k9_lk_institusi_kriteria5_narasi}}', '_5_d');
        $this->dropColumn('{{%k9_lk_institusi_kriteria5_narasi}}', '_5_e');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        //rename _1_a ke 1_a_1
        $this->renameColumn('{{%k9_lk_institusi_kriteria1_narasi}}', '_1_a__1', '_1_a');

        //create _1_a_2 - _1_a_3
        $this->dropColumn('{{%k9_lk_institusi_kriteria1_narasi}}', '_1_a__2');
        $this->dropColumn('{{%k9_lk_institusi_kriteria1_narasi}}', '_1_a__3');

        //create ref-5.d.1-5.d.2-5.e.2
        $this->dropColumn('{{%k9_lk_institusi_kriteria5_narasi}}', 'ref__5_d_1__5_d_2__5_e_2');

        //create ref-5.e.1
        $this->dropColumn('{{%k9_lk_institusi_kriteria5_narasi}}', 'ref__5_e_1');

        //rename _5_h jadi _5_h__1
        $this->renameColumn('{{%k9_lk_institusi_kriteria5_narasi}}', '_5_h__1', '_5_h');

        //create _5_h__2 - _5_h__4
        $this->dropColumn('{{%k9_lk_institusi_kriteria5_narasi}}', '_5_h__2');
        $this->dropColumn('{{%k9_lk_institusi_kriteria5_narasi}}', '_5_h__3');
        $this->dropColumn('{{%k9_lk_institusi_kriteria5_narasi}}', '_5_h__4');
        //hapus _5_d dan _5_e
        $this->addColumn('{{%k9_lk_institusi_kriteria5_narasi}}', '_5_d', $this->longText());
        $this->addColumn('{{%k9_lk_institusi_kriteria5_narasi}}', '_5_e', $this->longText());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201223_111452_alter_lk_institusi_tables cannot be reverted.\n";

        return false;
    }
    */
}
