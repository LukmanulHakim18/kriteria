<?php

use yii\db\Migration;

/**
 * Class m201227_051537_change_dokumen_led_institusi_to_ekspor_dokumen
 */
class m201227_051537_change_dokumen_led_institusi_to_ekspor_dokumen extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameTable('{{%k9_dokumen_led_institusi}}', '{{%k9_institusi_ekspor_dokumen}}');
        $this->addColumn('{{%k9_institusi_ekspor_dokumen}}', 'kode_dokumen', $this->string());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%k9_institusi_ekspor_dokumen}}', 'kode_dokumen');
        $this->renameTable('{{%k9_institusi_ekspor_dokumen}}', '{{%k9_dokumen_led_institusi}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201227_051537_change_dokumen_led_institusi_to_ekspor_dokumen cannot be reverted.\n";

        return false;
    }
    */
}
