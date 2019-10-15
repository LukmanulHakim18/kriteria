<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%profil_fakultas}}`.
 */
class m191013_080615_create_profil_fakultas_table extends Migration
{
    /**
     * {@inheritdoc}
     * @throws \yii\base\Exception
     */
    public function safeUp()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%profil_fakultas}}', [
            'id' => $this->primaryKey(),
            'id_fakultas' => $this->integer(),
            'visi' => $this->string(),
            'misi' => $this->string(),
            'tujuan' => $this->string(),
            'sasaran' => $this->string(),
            'motto' => $this->string(),
            'struktur_organisasi' => $this->json(),
            'sambutan' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()

        ], $tableOptions);

        $this->addForeignKey('fk-profil_fakultas-fakultas', '{{%profil_fakultas}}', 'id_fakultas', '{{%fakultas_akademi}}', 'id', 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-profil_fakultas-fakultas', '{{%profil_fakultas}}');
        $this->dropTable('{{%profil_fakultas}}');
    }
}
