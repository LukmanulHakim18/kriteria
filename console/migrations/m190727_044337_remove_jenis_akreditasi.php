<?php

use yii\db\Migration;

/**
 * Class m190727_044337_remove_jenis_akreditasi
 */
class m190727_044337_remove_jenis_akreditasi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-k9_akreditasi-jenis_akreditasi','{{%k9_akreditasi}}');
        $this->dropTable('{{%jenis_akreditasi}}');

        $this->alterColumn('{{%k9_akreditasi}}','id_jenis_akreditasi',$this->string(10));

        $this->renameColumn('{{%k9_akreditasi}}','id_jenis_akreditasi','jenis_akreditasi');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%jenis_akreditasi}}',[
            'id'=>$this->primaryKey(),
            'nama'=>$this->string(),
            'created_at'=>$this->integer(),
            'updated_at'=>$this->integer()
        ],$tableOptions);
        $this->alterColumn('{{%k9_akreditasi}}','jenis_akreditasi',$this->integer());
        $this->addForeignKey('fk-k9_akreditasi-jenis_akreditasi','{{%k9_akreditasi}}','jenis_akreditasi','{{%jenis_akreditasi}}','id','cascade','cascade');
        $this->renameColumn('{{%k9_akreditasi}}','jenis_akreditasi','id_jenis_akreditasi');




    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190727_044337_remove_jenis_akreditasi cannot be reverted.\n";

        return false;
    }
    */
}
