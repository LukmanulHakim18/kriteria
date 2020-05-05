<?php

use yii\db\Migration;

/**
 * Class m190908_160035_insert_k9_lk_template_table
 */
class m190908_160035_insert_k9_lk_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $data = [
            [1,'1','tabel_1.xlsx','prodi',1567958900,1567958900],
            [2,'2.a','tabel_2.a.xlsx','prodi',1567958900,1567958900],
            [3,'2.b','tabel_2.b.xlsx','prodi',1567958900,1567958900],
            [4,'3.a.1','tabel_3.a.1.xlsx','prodi',1567958900,1567958900],
            [5,'3.a.2','tabel_3.a.2.xlsx','prodi',1567958900,1567958900],
            [6,'3.a.3','tabel_3.a.3.xlsx','prodi',1567958900,1567958900],
            [7,'3.a.4','tabel_3.a.4.xlsx','prodi',1567958900,1567958900],
            [8,'3.a.5','tabel_3.a.5.xlsx','prodi',1567958900,1567958900],
            [9,'3.b.1','tabel_3.b.1.xlsx','prodi',1567958900,1567958900],
            [10,'3.b.2','tabel_3.b.2.xlsx','prodi',1567958900,1567958900],
            [11,'3.b.3','tabel_3.b.3.xlsx','prodi',1567958900,1567958900],
            [12,'3.b.4','tabel_3.b.4.xlsx','prodi',1567958900,1567958900],
            [13,'3.b.5.1','tabel_3.b.5.xlsx','prodi',1567958900,1567958900],
            [14,'3.b.5.2','tabel_3.b.5.xlsx','prodi',1567958900,1567958900],
            [15,'3.b.5.3','tabel_3.b.5.xlsx','prodi',1567958900,1567958900],
            [16,'3.b.5.4','tabel_3.b.5.xlsx','prodi',1567958900,1567958900],
            [17,'3.b.6','tabel_3.b.6.xlsx','prodi',1567958900,1567958900],
            [18,'3.b.7','tabel_3.b.7.xlsx','prodi',1567958900,1567958900],
            [19,'4.b','tabel_4.xlsx','prodi',1567958900,1567958900],
            [20,'5.a','tabel_5.a.xlsx','prodi',1567958900,1567958900],
            [21,'5.b','tabel_5.b.xlsx','prodi',1567958900,1567958900],
            [22,'5.c','tabel_5.c.xlsx','prodi',1567958900,1567958900],
            [23,'6.a','tabel_6.a.xlsx','prodi',1567958900,1567958900],
            [24,'6.b','tabel_6.b.xlsx','prodi',1567958900,1567958900],
            [25,'7','tabel_7.xlsx','prodi',1567958900,1567958900],
            [26,'8.a','tabel_8.a.xlsx','prodi',1567958900,1567958900],
            [27,'8.b.1','tabel_8.b.1.xlsx','prodi',1567958900,1567958900],
            [28,'8.b.2','tabel_8.b.2.xlsx','prodi',1567958900,1567958900],
            [29,'8.c','tabel_8.c.xlsx','prodi',1567958900,1567958900],
            [30,'8.d.1','tabel_8.d.1.xlsx','prodi',1567958900,1567958900],
            [31,'8.d.2','tabel_8.d.2.xlsx','prodi',1567958900,1567958900],
            [32,'8.e.1','tabel_8.e.1.xlsx','prodi',1567958900,1567958900],
            [33,'8.e.2','tabel_8.e.2.xlsx','prodi',1567958900,1567958900],
            [34,'8.f.1','tabel_8.f.1.xlsx','prodi',1567958900,1567958900],
            [35,'8.f.2','tabel_8.f.2.xlsx','prodi',1567958900,1567958900],
            [36,'8.f.3','tabel_8.f.3.xlsx','prodi',1567958900,1567958900],
            [37,'8.f.4.1','tabel_8.f.4.xlsx','prodi',1567958900,1567958900],
            [38,'8.f.4.2','tabel_8.f.4.xlsx','prodi',1567958900,1567958900],
            [39,'8.f.4.3','tabel_8.f.4.xlsx','prodi',1567958900,1567958900],
            [40,'8.f.4.4','tabel_8.f.4.xlsx','prodi',1567958900,1567958900],
            [41,'1.a','tabel_1.a.xlsx','institusi',1567958900,1567958900],
            [42,'1.b','tabel_1.b.xlsx','institusi',1567958900,1567958900],
            [43,'1.c','tabel_1.c.xlsx','institusi',1567958900,1567958900],
            [44,'2.a','tabel_2.a.xlsx','institusi',1567958900,1567958900],
            [45,'2.b','tabel_2.b.xlsx','institusi',1567958900,1567958900],
            [46,'2.c','tabel_2.c.xlsx','institusi',1567958900,1567958900],
            [47,'3.a.1','tabel_3.a.1.xlsx','institusi',1567958900,1567958900],
            [48,'3.a.2','tabel_3.a.2.xlsx','institusi',1567958900,1567958900],
            [49,'3.a.3','tabel_3.a.3.xlsx','institusi',1567958900,1567958900],
            [50,'3.a.4','tabel_3.a.4.xlsx','institusi',1567958900,1567958900],
            [51,'3.b','tabel_3.b.xlsx','institusi',1567958900,1567958900],
            [52,'3.c.1','tabel_3.c.1.xlsx','institusi',1567958900,1567958900],
            [53,'3.c.2','tabel_3.c.2.xlsx','institusi',1567958900,1567958900],
            [54,'3.d','tabel_3.d.xlsx','institusi',1567958900,1567958900],
            [55,'4.a','tabel_4.a.xlsx','institusi',1567958900,1567958900],
            [56,'4.b','tabel_4.b.xlsx','institusi',1567958900,1567958900],
            [57,'5.a.1','tabel_5.a.1.xlsx','institusi',1567958900,1567958900],
            [58,'5.a.2','tabel_5.a.2.xlsx','institusi',1567958900,1567958900],
            [59,'5.b.1','tabel_5.b.1.xlsx','institusi',1567958900,1567958900],
            [60,'5.b.2','tabel_5.b.2.xlsx','institusi',1567958900,1567958900],
            [61,'5.c.1','tabel_5.c.1.xlsx','institusi',1567958900,1567958900],
            [62,'5.c.2.a','tabel_5.c.2.a.xlsx','institusi',1567958900,1567958900],
            [63,'5.c.2.b','tabel_5.c.2.b.xlsx','institusi',1567958900,1567958900],
            [64,'5.c.2.c1','tabel_5.c.2.c1.xlsx','institusi',1567958900,1567958900],
            [65,'5.c.2.c2','tabel_5.c.2.c2.xlsx','institusi',1567958900,1567958900],
            [66,'5.c.2.d','tabel_5.c.2.d.xlsx','institusi',1567958900,1567958900],
            [67,'5.c.2.e','tabel_5.c.2.e.xlsx','institusi',1567958900,1567958900],
            [68,'5.c.2.f','tabel_5.c.2.f.xlsx','institusi',1567958900,1567958900],
            [69,'5.c.2.g','tabel_5.c.2.g.xlsx','institusi',1567958900,1567958900],
            [70,'5.d.1','tabel_5.d.1.xlsx','institusi',1567958900,1567958900],
            [71,'5.d.2','tabel_5.d.2.xlsx','institusi',1567958900,1567958900],
            [72,'5.e.1','tabel_5.e.1.xlsx','institusi',1567958900,1567958900],
            [73,'5.e.2','tabel_5.e.2.xlsx','institusi',1567958900,1567958900],
            [74,'5.f','tabel_5.f.xlsx','institusi',1567958900,1567958900],
            [75,'5.g.1','tabel_5.g.1.xlsx','institusi',1567958900,1567958900],
            [76,'5.g.2','tabel_5.g.2.xlsx','institusi',1567958900,1567958900],
            [77,'5.h','tabel_5.h.xlsx','institusi',1567958900,1567958900],
        ];

        $this->batchInsert('{{%k9_lk_template}}',['id','nomor_tabel','nama_file','untuk','created_at','updated_at'],$data);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('{{%k9_lk_template}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190908_160035_insert_k9_lk_template_table cannot be reverted.\n";

        return false;
    }
    */
}
