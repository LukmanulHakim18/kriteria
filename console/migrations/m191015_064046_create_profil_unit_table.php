<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%profil_unit}}`.
 */
class m191015_064046_create_profil_unit_table extends Migration
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

        $this->createTable('{{%profil_unit}}', [
            'id' => $this->primaryKey(),
            'id_unit' => $this->integer(),
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

        $this->addForeignKey('fk-profil_unit-unit', '{{%profil_unit}}', 'id_unit', '{{%unit}}', 'id', 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-profil_unit-unit', '{{%profil_unit}}');
        $this->dropTable('{{%profil_unit}}');
    }
}
