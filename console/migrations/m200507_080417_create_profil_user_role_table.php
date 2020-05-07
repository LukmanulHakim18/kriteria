<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_role}}`.
 */
class m200507_080417_create_profil_user_role_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%profil_user_role}}', [
            'id' => $this->primaryKey(),
            'id_profil'=>$this->integer(),
            'external_id'=>$this->integer(),
            'type'=>$this->string(10)
        ]);

        $this->addForeignKey('fk-profil_user_role-user','{{%profil_user_role}}','id_profil','{{%profil_user}}','id','cascade','cascade');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-user_role-user','{{%user_role}}');
        $this->dropTable('{{%user_role}}');
    }
}
