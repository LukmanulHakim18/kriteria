<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%k9_led_prodi_narasi_analisis}}`.
 */
class m200918_065108_create_k9_led_prodi_narasi_analisis_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%k9_led_prodi_narasi_analisis}}', [
            'id' => $this->primaryKey(),
            'id_led_prodi'=>$this->integer(),
            '_1'=>$this->text(),
            '_2'=>$this->text(),
            '_3'=>$this->text(),
            '_4'=>$this->text(),
            'created_at'=>$this->integer(),
            'updated_at'=>$this->integer()
        ]);
        $this->addForeignKey('{{%k9_led_prd-k9_led-prd-na}}', '{{%k9_led_prodi_narasi_analisis}}', 'id_led_prodi', '{{%k9_led_prodi}}', 'id', 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%k9_led_prd-k9_led-prd-na}}', '{{%k9_led_prodi_narasi_analisis}}');
        $this->dropTable('{{%k9_led_prodi_narasi_analisis}}');
    }
}
