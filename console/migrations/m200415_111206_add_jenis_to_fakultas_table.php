<?php

use yii\db\Migration;

/**
 * Class m200415_111206_add_jenis_to_fakultas_table
 */
class m200415_111206_add_jenis_to_fakultas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('{{%fakultas_akademi}}','jenis',$this->tinyInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('{{%fakultas_akademi}}','jenis');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200415_111206_add_jenis_to_fakultas_table cannot be reverted.\n";

        return false;
    }
    */
}
