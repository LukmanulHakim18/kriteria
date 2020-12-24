<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%k9_institusi_non_kriteria_dokumen}}`.
 */
class m201224_061317_create_k9_led_institusi_non_kriteria_dokumen_table extends Migration
{
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

        $this->createTable('{{%k9_led_institusi_non_kriteria_dokumen}}', [
            'id' => $this->primaryKey(),
            'id_led_institusi' => $this->integer(),
            'kode_dokumen' => $this->string(),
            'nama_dokumen' => $this->string(),
            'isi_dokumen' => $this->text(),
            'bentuk_dokumen' => $this->string(),
            'jenis_dokumen' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer()
        ], $tableOptions);

        $this->addForeignKey('fk-inst_non_k_dok-led_inst', '{{%k9_led_institusi_non_kriteria_dokumen}}',
            'id_led_institusi',
            '{{%k9_led_institusi}}', 'id', 'cascade', 'cascade');

        $this->addForeignKey('fk-inst_non_k_dok-user_crd', '{{%k9_led_institusi_non_kriteria_dokumen}}', 'created_at',
            '{{%user}}', 'id', 'cascade', 'cascade');

        $this->addForeignKey('fk-inst_non_k_dok-user_upd', '{{%k9_led_institusi_non_kriteria_dokumen}}', 'updated_at',
            '{{%user}}', 'id', 'cascade', 'cascade');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%k9_led_institusi_non_kriteria_dokumen}}');
    }
}
