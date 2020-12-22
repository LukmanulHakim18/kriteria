<?php

use yii\db\Migration;

/**
 * Class m201222_093331_create_led_institusi_narasi_non_kriteria_tables
 */
class m201222_093331_create_led_institusi_narasi_non_kriteria_tables extends Migration
{
    use \common\helpers\TextTypesTrait;

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

        //tabel narasi kondisi external (A)
        $this->createTable('{{%k9_led_institusi_narasi_kondisi_eksternal}}', [
            'id' => $this->primaryKey(),
            'id_led_institusi' => $this->integer(),
            '_A' => $this->longText(),
            "progress" => $this->float(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ], $tableOptions);
        $this->addForeignKey('fk-led_inst_n_eks-led_inst', '{{%k9_led_institusi_narasi_kondisi_eksternal}}',
            'id_led_institusi', '{{%k9_led_institusi}}', 'id', 'cascade', 'cascade');

        //tabel nrasi profil institusi (1-8)
        $this->createTable('{{%k9_led_institusi_narasi_profil_institusi}}', [
            'id' => $this->primaryKey(),
            'id_led_institusi' => $this->integer(),
            '_1' => $this->longText(),
            '_2' => $this->longText(),
            '_3' => $this->longText(),
            '_4' => $this->longText(),
            '_5' => $this->longText(),
            '_6' => $this->longText(),
            '_7' => $this->longText(),
            '_8' => $this->longText(),
            'progress' => $this->float(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ], $tableOptions);
        $this->addForeignKey('fk-led_inst_n_prof-led_inst', '{{%k9_led_institusi_narasi_profil_institusi}}',
            'id_led_institusi', '{{%k9_led_institusi}}', 'id', 'cascade', 'cascade');
        //tabel narasi analisis (1-4)
        $this->createTable('{{%k9_led_institusi_narasi_analisis}}', [
            'id' => $this->primaryKey(),
            'id_led_institusi' => $this->integer(),
            '_1' => $this->longText(),
            '_2' => $this->longText(),
            '_3' => $this->longText(),
            '_4' => $this->longText(),
            'progress' => $this->float(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ], $tableOptions);
        $this->addForeignKey('fk-led_inst_n_anl-led_inst', '{{%k9_led_institusi_narasi_analisis}}', 'id_led_institusi',
            '{{%k9_led_institusi}}', 'id', 'cascade', 'cascade');

        //tabel dokumen non kriteria

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%k9_led_institusi_narasi_analisis}}');
        $this->dropTable('{{%k9_led_institusi_narasi_profil_institusi}}');
        $this->dropTable('{{%k9_led_institusi_narasi_kondisi_eksternal}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201222_093331_create_led_institusi_narasi_non_kriteria_tables cannot be reverted.\n";

        return false;
    }
    */
}
