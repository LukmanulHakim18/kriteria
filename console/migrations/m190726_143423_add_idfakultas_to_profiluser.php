<?php

use yii\db\Migration;

/**
 * Class m190726_143423_add_idfakultas_to_profiluser
 */
class m190726_143423_add_idfakultas_to_profiluser extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('{{%profil_user}}','id_fakultas',$this->integer());
        $this->addForeignKey('fk-profil_user-fakultas_akademi','{{%profil_user}}','id_fakultas','{{%fakultas_akademi}}','id','CASCADE','cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-profil_user-fakultas_akademi','{{%profil_user}}');
        $this->dropColumn('{{%profil_user}}','id_fakultas');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190726_143423_add_idfakultas_to_profiluser cannot be reverted.\n";

        return false;
    }
    */
}
