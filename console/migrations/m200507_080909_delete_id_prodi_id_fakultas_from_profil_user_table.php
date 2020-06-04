<?php

use yii\db\Migration;

/**
 * Class m200507_080909_delete_id_prodi_id_fakultas_from_profil_user_table
 */
class m200507_080909_delete_id_prodi_id_fakultas_from_profil_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-profil_user-program_studi','{{%profil_user}}');
        $this->dropColumn('{{%profil_user}}','id_prodi');
        $this->dropForeignKey('fk-profil_user-fakultas_akademi','{{%profil_user}}');
        $this->dropColumn('{{%profil_user}}','id_fakultas');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->addColumn('{{%profil_user}}','id_prodi',$this->integer());
        $this->addForeignKey('fk-profil_user-program_studi','{{%profil_user}}','id_prodi', 'program_studi','id','cascade','cascade');

        $this->addColumn('{{%profil_user}}','id_fakultas',$this->integer());
        $this->addForeignKey('fk-profil_user-fakultas_akademi','{{%profil_user}}','id_fakultas','{{%fakultas_akademi}}','id','CASCADE','cascade');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200507_080909_delete_id_prodi_id_fakultas_from_profil_user_table cannot be reverted.\n";

        return false;
    }
    */
}
