<?php

use common\helpers\TextTypesTrait;
use yii\db\Migration;

/**
 * Class m201224_105323_create_penilaians_institusi_tables
 */
class m201224_105323_create_penilaians_institusi_tables extends Migration
{
    use TextTypesTrait;

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        //tabel kondisi eksternal
        $this->createTable('{{%k9_penilaian_institusi_eksternal}}', [
            'id' => $this->primaryKey(),
            'id_akreditasi_institusi' => $this->integer(),
            '_1' => $this->longText(),
            'total' => $this->integer(),
            'status' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer()
        ], $tableOptions);

        $this->addForeignKey('fk-pen_inst_eks-akre_inst', '{{%k9_penilaian_institusi_eksternal}}',
            'id_akreditasi_institusi', '{{%k9_akreditasi_institusi}}', 'id', 'cascade', 'cascade');

        $this->addForeignKey('fk-pen_inst_eks-user_crd', '{{%k9_penilaian_institusi_eksternal}}', 'created_by',
            '{{%user}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk-pen_inst_eks-user_upd', '{{%k9_penilaian_institusi_eksternal}}', 'updated_by',
            '{{%user}}', 'id', 'cascade', 'cascade');
        //tabel profil institusi
        $this->createTable('{{%k9_penilaian_institusi_profil}}', [
            'id' => $this->primaryKey(),
            'id_akreditasi_institusi' => $this->integer(),
            '_1' => $this->longText(),
            'total' => $this->integer(),
            'status' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer()
        ], $tableOptions);

        $this->addForeignKey('fk-pen_inst_prf-akre_inst', '{{%k9_penilaian_institusi_profil}}',
            'id_akreditasi_institusi', '{{%k9_akreditasi_institusi}}', 'id', 'cascade', 'cascade');

        $this->addForeignKey('fk-pen_inst_prf-user_crd', '{{%k9_penilaian_institusi_profil}}', 'created_by',
            '{{%user}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk-pen_inst_prf-user_upd', '{{%k9_penilaian_institusi_profil}}', 'updated_by',
            '{{%user}}', 'id', 'cascade', 'cascade');

        //tabel kriteria

        $this->createTable('{{%k9_penilaian_institusi_kriteria}}', [
            'id' => $this->primaryKey(),
            'id_akreditasi_institusi' => $this->integer(),
            '_1_4_1' => $this->longText(),
            '_2_4_a_A' => $this->longText(),
            '_2_4_a_B' => $this->longText(),
            '_2_4_a_C' => $this->longText(),
            '_2_4_a_D' => $this->longText(),
            '_2_4_a_E' => $this->longText(),
            '_2_4_b_A' => $this->longText(),
            '_2_4_b_B' => $this->longText(),
            '_2_4_b_C' => $this->longText(),
            '_2_4_c_A' => $this->longText(),
            '_2_4_c_B' => $this->longText(),
            '_2_4_c_C' => $this->longText(),
            '_2_4_c_D' => $this->longText(),
            '_2_4_d__1_A__1' => $this->longText(),
            '_2_4_d__1_B__1' => $this->longText(),
            '_2_4_d__1_A__2' => $this->longText(),
            '_2_4_d__1_B__2' => $this->longText(),
            '_2_4_d__1_1' => $this->longText(),
            '_2_4_d__1_2' => $this->longText(),
            '_2_4_d__2_A' => $this->longText(),
            '_2_4_d__2_B' => $this->longText(),
            '_2_4_d__2_C' => $this->longText(),
            '_2_4_d__2_D' => $this->longText(),
            '_2_4_d__2_1' => $this->longText(),
            '_2_5_1' => $this->longText(),
            '_2_6_1' => $this->longText(),
            '_2_7_1' => $this->longText(),
            '_2_8_1' => $this->longText(),
            '_3_4_a_1' => $this->longText(),
            '_3_4_a_2' => $this->longText(),
            '_3_4_a_3' => $this->longText(),
            '_3_4_b_1' => $this->longText(),
            '_4_4_a_1' => $this->longText(),
            '_4_4_a_2' => $this->longText(),
            '_4_4_a_3' => $this->longText(),
            '_4_4_a_4' => $this->longText(),
            '_4_4_a_5' => $this->longText(),
            '_4_4_b_1' => $this->longText(),
            '_4_4_b_2' => $this->longText(),
            '_4_4_b_3' => $this->longText(),
            '_4_4_c_1' => $this->longText(),
            '_5_4_a_1' => $this->longText(),
            '_5_4_a_2' => $this->longText(),
            '_5_4_a_3' => $this->longText(),
            '_5_4_a_4' => $this->longText(),
            '_5_4_a_5' => $this->longText(),
            '_5_4_a_6' => $this->longText(),
            '_5_4_a_7' => $this->longText(),
            '_5_4_b_A' => $this->longText(),
            '_5_4_b_B' => $this->longText(),
            '_5_4_b_C' => $this->longText(),
            '_6_4_a_A' => $this->longText(),
            '_6_4_a_B' => $this->longText(),
            '_6_4_a_C' => $this->longText(),
            '_6_4_b_A' => $this->longText(),
            '_6_4_b_B' => $this->longText(),
            '_6_4_b_C' => $this->longText(),
            '_6_4_c_A' => $this->longText(),
            '_6_4_c_B' => $this->longText(),
            '_6_4_c_C' => $this->longText(),
            '_6_4_d_A' => $this->longText(),
            '_6_4_d_B' => $this->longText(),
            '_6_4_d_C' => $this->longText(),
            '_7_4_a_A' => $this->longText(),
            '_7_4_a_B' => $this->longText(),
            '_7_4_a_C' => $this->longText(),
            '_7_4_a_D' => $this->longText(),
            '_7_4_b_1' => $this->longText(),
            '_8_4_a__1_A' => $this->longText(),
            '_8_4_a__1_B' => $this->longText(),
            '_8_4_a__1_C' => $this->longText(),
            '_8_4_a__1_D' => $this->longText(),
            '_8_4_a__2_1' => $this->longText(),
            '_9_4_a_1' => $this->longText(),
            '_9_4_a_2' => $this->longText(),
            '_9_4_a_3' => $this->longText(),
            '_9_4_a_4' => $this->longText(),
            '_9_4_a_5' => $this->longText(),
            '_9_4_a_6' => $this->longText(),
            '_9_4_a_7' => $this->longText(),
            '_9_4_a_8' => $this->longText(),
            '_9_4_a_9' => $this->longText(),
            '_9_4_a_10' => $this->longText(),
            '_9_4_b_1' => $this->longText(),
            '_9_4_b_2' => $this->longText(),
            '_9_4_b_3' => $this->longText(),
            '_9_4_b_4' => $this->longText(),
            'total' => $this->integer(),
            'status' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer()
        ], $tableOptions);
        $this->addForeignKey('fk-pen_inst_krt-akre_inst', '{{%k9_penilaian_institusi_kriteria}}',
            'id_akreditasi_institusi', '{{%k9_akreditasi_institusi}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk-pen_inst_krt-user_crd', '{{%k9_penilaian_institusi_kriteria}}', 'created_by',
            '{{%user}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk-pen_inst_krt-user_upd', '{{%k9_penilaian_institusi_kriteria}}', 'updated_by',
            '{{%user}}', 'id', 'cascade', 'cascade');

        //tabel analisis

        $this->createTable('{{%k9_penilaian_institusi_analisis}}', [
            'id' => $this->primaryKey(),
            'id_akreditasi_institusi' => $this->integer(),
            '_1_1' => $this->longText(),
            '_2_1' => $this->longText(),
            '_3_1' => $this->longText(),
            '_4_1' => $this->longText(),
            'total' => $this->integer(),
            'status' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer()
        ], $tableOptions);

        $this->addForeignKey('fk-pen_inst_anl-akre_inst', '{{%k9_penilaian_institusi_analisis}}',
            'id_akreditasi_institusi', '{{%k9_akreditasi_institusi}}', 'id', 'cascade', 'cascade');

        $this->addForeignKey('fk-pen_inst_anl-user_crd', '{{%k9_penilaian_institusi_analisis}}', 'created_by',
            '{{%user}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk-pen_inst_anl-user_upd', '{{%k9_penilaian_institusi_analisis}}', 'updated_by',
            '{{%user}}', 'id', 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%k9_penilaian_institusi_eksternal}}');
//        $this->dropTable('{{%k9_penilaian_institusi_profil}}');
//        $this->dropTable('{{%k9_penilaian_institusi_kriteria}}');
//        $this->dropTable('{{%k9_penilaian_institusi_analisis}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201224_105323_create_penilaians_institusi_tables cannot be reverted.\n";

        return false;
    }
    */
}
