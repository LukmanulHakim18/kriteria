<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%profil_institusi}}`.
 */
class m200511_133610_create_profil_institusi_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%profil_institusi}}', [
            'id' => $this->primaryKey(),
            'nama'=>$this->string(),
            'isi'=>$this->text(),
            'created_at'=>$this->integer(),
            'updated_at'=>$this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%profil_institusi}}');
    }
}
