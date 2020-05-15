<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%detail_berkas}}`.
 */
class m200511_134302_create_detail_berkas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%detail_berkas}}', [
            'id' => $this->primaryKey(),
            'id_berkas'=>$this->integer(),
            'isi_berkas'=>$this->string(),
            'bentuk_berkas'=>$this->string(),
            'created_at'=>$this->integer(),
            'updated_at'=>$this->integer()
        ]);
        $this->addForeignKey('fk-detail_berkas-berkas','{{%detail_berkas}}','id_berkas','{{%berkas}}','id','cascade','cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-detail_berkas-berkas','{{%detail_berkas}}');
        $this->dropTable('{{%detail_berkas}}');
    }
}
