<?php

use yii\db\Migration;

/**
 * Class m190908_115535_add_k9_lk_template_table
 */
class m190908_115535_add_k9_lk_template_table extends Migration
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

        $this->createTable('{{%k9_lk_template}}',[
            'id' => $this->primaryKey(),
            'nomor_tabel' => $this->string(),
            'nama_file' => $this->string(),
            'untuk' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ], $tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%k9_lk_template}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190908_115535_add_k9_lk_template_table cannot be reverted.\n";

        return false;
    }
    */
}
