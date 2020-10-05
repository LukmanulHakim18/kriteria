<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%k9_led_prodi_narasi_kondisi_eksternal}}`.
 */
class m200918_065019_create_k9_led_prodi_narasi_kondisi_eksternal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%k9_led_prodi_narasi_kondisi_eksternal}}', [
            'id' => $this->primaryKey(),
            'id_led_prodi'=>$this->integer(),
            'isi'=>$this->text(),
            'created_at'=>$this->integer(),
            'updated_at'=>$this->integer()
        ]);
        $this->addForeignKey('fk-k9_led_prd-k9_led_prd_n_ke', '{{%k9_led_prodi_narasi_kondisi_eksternal}}', 'id_led_prodi', '{{%k9_led_prodi}}', 'id', 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-k9_led_prd-k9_led_prd_n_ke', '{{%k9_led_prodi_narasi_kondisi_eksternal}}');
        $this->dropTable('{{%k9_led_prodi_narasi_kondisi_eksternal}}');
    }
}
