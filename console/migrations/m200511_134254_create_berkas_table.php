<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%berkas}}`.
 */
class m200511_134254_create_berkas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%berkas}}', [
            'id' => $this->primaryKey(),
            'external_id'=>$this->integer(),
            'type'=>$this->string(),
            'nama_berkas'=>$this->string(),
            'created_at'=>$this->integer(),
            'updated_at'=>$this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%berkas}}');
    }
}
