<?php

use yii\db\Migration;

/**
 * Class m190819_125708_init_rbac_role
 */
class m190819_125708_init_rbac_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $superadmin = $auth->createRole('superadmin');
        $admin = $auth->createRole('admin');
        $lpm = $auth->createRole('lpm');
        $rektorat = $auth->createRole('rektorat');
        $unit = $auth->createRole('unit');
        $fakultas = $auth->createRole('fakultas');
        $dekanat = $auth->createRole('dekanat');
        $prodi = $auth->createRole('prodi');
        $kaprodi = $auth->createRole('kaprodi');

        $auth->add($superadmin);
        $auth->add($admin);
        $auth->add($lpm);
        $auth->add($rektorat);
        $auth->add($unit);
        $auth->add($fakultas);
        $auth->add($dekanat);
        $auth->add($prodi);
        $auth->add($kaprodi);

        $auth->assign($superadmin,1);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190819_125708_init_rbac_role cannot be reverted.\n";

        return false;
    }
    */
}
