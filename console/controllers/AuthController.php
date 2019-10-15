<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class AuthController extends Controller
{

    public function actionUp()
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

        $auth->assign($superadmin, 1);

        $su = $auth->getRole('superadmin');
        $permissions = ['@app-admin/*', '@app-akreditasi/*', '@app-monitoring/*'];

        foreach ($permissions as $permission) {
            $permission = $auth->createPermission($permission);
            $auth->add($permission);
            $auth->addChild($su, $permission);

        }


        return true;
    }

    public function actionDown()
    {
        $auth = Yii::$app->getAuthManager();

        $su = $auth->getRole('superadmin');
        $permissions = ['@app-admin/*', '@app-akreditasi/*', '@app-monitoring/*'];

        foreach ($permissions as $permission) {
            $item = $auth->getPermission($permission);
            $auth->removeChildren($item);
            $auth->remove($item);
        }
    }
}