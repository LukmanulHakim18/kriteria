<?php

use yii\db\Migration;

/**
 * Class m201208_081357_alter_lkprodi_narasi_table
 */
class m201208_081357_alter_lkprodi_narasi_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        //1.1 - 1.3

        //3.7-1 -- 3.7-4

        //8.e.2-ref

        //8.f.4-1 - 8.f.4-4

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201208_081357_alter_lkprodi_narasi_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201208_081357_alter_lkprodi_narasi_table cannot be reverted.\n";

        return false;
    }
    */
}
