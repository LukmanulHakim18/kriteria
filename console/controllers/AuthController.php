<?php

namespace console\controllers;

use common\auth\rbac\rules\AccessOwnProdi;
use common\auth\rbac\rules\AccessOwnUnit;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\console\Response;

class AuthController extends Controller
{

    public function actionUp()
    {
        $auth = Yii::$app->authManager;

        printf("Creating Roles\n");
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

        printf("Assigning SuperAdmin\n");
        $auth->assign($superadmin, 1);

        $su = $auth->getRole('superadmin');
        $suPermission = ['@app-admin/*', '@app-akreditasi/*', '@app-monitoring/*'];

        foreach ($suPermission as $permission) {
            printf("Creating Permission: ". $permission. "\n");
            $permission = $auth->createPermission($permission);
            $auth->add($permission);
            printf("Assigning Permission to Roles \n");
            $auth->addChild($su, $permission);
            $auth->addChild($lpm, $permission);

        }
        $commonPermission = ['@app-akreditasi/site/*','@app-akreditasi/profile/*'];

        $unitPermission = ['@app-akreditasi/unit/arsip/*'];
        $prodiPermission = ['@app-akreditasi/kriteria9/prodi/*'];
        $fakultasPermission = ['@app-akreditasi/fakultas/*'];

        //common permission
        foreach ($commonPermission as $permission){
            printf("Creating Permission: ". $permission. "\n");
            $permission = $auth->createPermission($permission);
            $auth->add($permission);
            printf("Assigning Permission to Roles \n");
            $auth->addChild($unit,$permission);
            $auth->addChild($prodi,$permission);
            $auth->addChild($kaprodi,$permission);
            $auth->addChild($dekanat,$permission);
            $auth->addChild($fakultas,$permission);
        }

        //unit permission
        foreach ($unitPermission as $permission){
            printf("Creating Permission: ". $permission. "\n");
            $permission = $auth->createPermission($permission);
            $auth->add($permission);
            printf("Assigning Permission to Roles \n");
            $auth->addChild($unit,$permission);
        }

        //prodi permissions
        foreach ($prodiPermission as $permission) {
            printf("Creating Permission: ". $permission. "\n");
            $permission = $auth->createPermission($permission);
            $auth->add($permission);
            printf("Assigning Permission to Roles \n");
            $auth->addChild($prodi,$permission);
            $auth->addChild($kaprodi,$permission);
        }

        //fakultas permissions
        foreach ($fakultasPermission as $permission){
            printf("Creating Permission: ". $permission. "\n");
            $permission = $auth->createPermission($permission);
            $auth->add($permission);
            printf("Assigning Permission to Roles \n");
            $auth->addChild($fakultas,$permission);
            $auth->addChild($dekanat,$permission);
        }
        printf("Add Prodi Permission to Fakultas and Dekanat\n");
        $auth->addChild($fakultas,$prodi);
        $auth->addChild($dekanat,$kaprodi);

        //prodi rules
        printf("Create AccessOwnProdi Rule \n");
        $accessOwnProdi = new AccessOwnProdi;
        $auth->add($accessOwnProdi);
        printf("Create izinProdi Permission\n");
        $izinProdi = $auth->createPermission('izinProdi');
        $izinProdi->description = "Access kedalaman pengisian borang prodi";
        $izinProdi->ruleName = $accessOwnProdi->name;
        $auth->add($izinProdi);

        $prodiRoute = $auth->createPermission('@app-akreditasi/kriteria9/k9-prodi/*');
        printf("Adding izinProdi to Appropriate Roles\n");
        $auth->add($prodiRoute);
        $auth->addChild($izinProdi,$prodiRoute);
        $auth->addChild($prodi,$izinProdi);
        $auth->addChild($kaprodi,$izinProdi);

        //unit rules
        printf("Create AccessOwnUnit Rule \n");
        $accessOwnUnit = new AccessOwnUnit;
        $auth->add($accessOwnUnit);
        printf("Create izinUnit Permission\n");
        $izinUnit = $auth->createPermission('izinUnit');
        $izinUnit->description = "Access kedalaman pengisian unit";
        $izinUnit->ruleName = $accessOwnUnit->name;
        $auth->add($izinUnit);

        $unitRoute1 = $auth->createPermission('@app-akreditasi/unit/default/*');
        printf("Adding izinUnit to Appropriate Roles\n");
        $auth->add($unitRoute1);
        $auth->addChild($izinUnit,$unitRoute1);
        $unitRoute2 = $auth->createPermission('@app-akreditasi/unit/kegiatan/*');
        $auth->add($unitRoute2);
        $auth->addChild($izinUnit,$unitRoute2);
        $unitRoute3 = $auth->createPermission('@app-akreditasi/unit/profil/*');
        $auth->add($unitRoute3);
        $auth->addChild($izinUnit,$unitRoute3);

        $auth->addChild($unit,$izinUnit);

        return ExitCode::OK;
    }

    public function actionDown()
    {
        $auth = Yii::$app->getAuthManager();
        printf("Removing all rbac authorization\n");
        $auth->removeAll();

        return ExitCode::OK;
    }
}