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
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%detail_berkas}}');
    }
}
