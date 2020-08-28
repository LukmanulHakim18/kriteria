<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%lk_institusi_kriteria}}`.
 */
class m200828_044632_create_lk_institusi_kriteria_table extends Migration
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
        $this->createTable('{{%k9_lk_institusi_kriteria1}}', [
            'id' => $this->primaryKey(),
            'id_lk_institusi'=>$this->integer(),
            'progress_narasi'=>$this->float(),
            'progress_dokumen'=>$this->float(),
            'created_at'=>$this->integer(),
            'updated_at'=>$this->integer()
        ],$tableOptions);
        $this->createTable('{{%k9_lk_institusi_kriteria2}}', [
            'id' => $this->primaryKey(),
            'id_lk_institusi'=>$this->integer(),
            'progress_narasi'=>$this->float(),
            'progress_dokumen'=>$this->float(),
            'created_at'=>$this->integer(),
            'updated_at'=>$this->integer()
        ],$tableOptions);
        $this->createTable('{{%k9_lk_institusi_kriteria3}}', [
            'id' => $this->primaryKey(),
            'id_lk_institusi'=>$this->integer(),
            'progress_narasi'=>$this->float(),
            'progress_dokumen'=>$this->float(),
            'created_at'=>$this->integer(),
            'updated_at'=>$this->integer()
        ],$tableOptions);
        $this->createTable('{{%k9_lk_institusi_kriteria4}}', [
            'id' => $this->primaryKey(),
            'id_lk_institusi'=>$this->integer(),
            'progress_narasi'=>$this->float(),
            'progress_dokumen'=>$this->float(),
            'created_at'=>$this->integer(),
            'updated_at'=>$this->integer()
        ],$tableOptions);
        $this->createTable('{{%k9_lk_institusi_kriteria5}}', [
            'id' => $this->primaryKey(),
            'id_lk_institusi'=>$this->integer(),
            'progress_narasi'=>$this->float(),
            'progress_dokumen'=>$this->float(),
            'created_at'=>$this->integer(),
            'updated_at'=>$this->integer()
        ],$tableOptions);


        $this->addForeignKey('fk-k9_lk_ins_k_1-lk_ins','{{%k9_lk_institusi_kriteria1}}','id_lk_institusi','{{%k9_lk_institusi}}','id','cascade','cascade');
        $this->addForeignKey('fk-k9_lk_ins_k_2-lk_ins','{{%k9_lk_institusi_kriteria2}}','id_lk_institusi','{{%k9_lk_institusi}}','id','cascade','cascade');
        $this->addForeignKey('fk-k9_lk_ins_k_3-lk_ins','{{%k9_lk_institusi_kriteria3}}','id_lk_institusi','{{%k9_lk_institusi}}','id','cascade','cascade');
        $this->addForeignKey('fk-k9_lk_ins_k_4-lk_ins','{{%k9_lk_institusi_kriteria4}}','id_lk_institusi','{{%k9_lk_institusi}}','id','cascade','cascade');
        $this->addForeignKey('fk-k9_lk_ins_k_5-lk_ins','{{%k9_lk_institusi_kriteria5}}','id_lk_institusi','{{%k9_lk_institusi}}','id','cascade','cascade');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-k9_lk_ins_k_1-lk_ins','{{%k9_lk_institusi_kriteria1}}');
        $this->dropForeignKey('fk-k9_lk_ins_k_2-lk_ins','{{%k9_lk_institusi_kriteria2}}');
        $this->dropForeignKey('fk-k9_lk_ins_k_3-lk_ins','{{%k9_lk_institusi_kriteria3}}');
        $this->dropForeignKey('fk-k9_lk_ins_k_4-lk_ins','{{%k9_lk_institusi_kriteria4}}');
        $this->dropForeignKey('fk-k9_lk_ins_k_5-lk_ins','{{%k9_lk_institusi_kriteria5}}');

        $this->dropTable('{{%k9_lk_institusi_kriteria1}}');
        $this->dropTable('{{%k9_lk_institusi_kriteria2}}');
        $this->dropTable('{{%k9_lk_institusi_kriteria3}}');
        $this->dropTable('{{%k9_lk_institusi_kriteria4}}');
        $this->dropTable('{{%k9_lk_institusi_kriteria5}}');

    }
}
