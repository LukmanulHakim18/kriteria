<?php

namespace console\controllers;

use common\auth\rbac\rules\AccessOwnFakultas;
use common\auth\rbac\rules\AccessOwnProdi;
use common\auth\rbac\rules\AccessOwnUnit;
use common\auth\rbac\rules\AccessProdiAsesor;
use common\auth\rbac\rules\AccessPtAsesor;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class AuthController extends Controller
{

    public function actionUp()
    {
        $auth = Yii::$app->authManager;

        printf("Creating Roles\n");
        $superadmin = $auth->createRole('superadmin');
        $lpm = $auth->createRole('lpm');
        $rektorat = $auth->createRole('rektorat');
        $unit = $auth->createRole('unit');
        $fakultas = $auth->createRole('fakultas');
        $dekanat = $auth->createRole('dekanat');
        $prodi = $auth->createRole('prodi');
        $kaprodi = $auth->createRole('kaprodi');
        $asesor = $auth->createRole('asesor');

        $auth->add($superadmin);
        $auth->add($lpm);
        $auth->add($rektorat);
        $auth->add($unit);
        $auth->add($fakultas);
        $auth->add($dekanat);
        $auth->add($prodi);
        $auth->add($kaprodi);
        $auth->add($asesor);

        printf("Assigning SuperAdmin\n");
        $auth->assign($superadmin, 1);

        $su = $auth->getRole('superadmin');
        $suPermission = ['@app-admin/*', '@app-akreditasi/*', '@app-monitoring/*'];

        foreach ($suPermission as $permission) {
            printf("Creating Permission: " . $permission . "\n");
            $permission = $auth->createPermission($permission);
            $auth->add($permission);
            printf("Assigning Permission to Roles \n");
            $auth->addChild($su, $permission);
            $auth->addChild($lpm, $permission);

        }
        $commonPermission = [
            '@app-akreditasi/site/*',
            '@app-akreditasi/profile/*',
            '@app-akreditasi/kriteria9/default/*'
        ];

        $unitPermission = [
            '@app-akreditasi/unit/arsip/*',
            '@app-akreditasi/unit/kegiatan/*',
            '@app-akreditasi/unit/default/*',
            '@app-akreditasi/unit/profil/*'
        ];
        $isiLedProdiPermission = ['@app-akreditasi/kriteria9/prodi/*', '@app-akreditasi/kriteria9/k9-prodi/*'];
        $fakultasPermission = ['@app-akreditasi/kriteria9/fakultas/*', '@app-akreditasi/fakultas/*'];
        $isiLedInstitusiPermission = ['@app-akreditasi/kriteria9/k9-institusi/*'];
        $asesorPermission = ['@app-akreditasi/asesor/*'];

        $commonMonitoring = [
            '@app-monitoring/site/*',
            '@app-monitoring/profile/*',
        ];
        $kaprodiPermission = [
            '@app-monitoring/eksekutif/arsip/prodi',
            '@app-monitoring/eksekutif/eksekutif-prodi/*'
        ];
        $dekanatPermission = [
            '@app-monitoring/eksekutif/arsip/fakultas',
            '@app-monitoring/eksekutif/eksekutif-fakultas/*'
        ];

        //common permission
        foreach ($commonPermission as $permission) {
            printf("Creating Permission: " . $permission . "\n");
            $permission = $auth->createPermission($permission);
            $auth->add($permission);
            printf("Assigning Permission to Roles \n");
            $auth->addChild($unit, $permission);
            $auth->addChild($prodi, $permission);
            $auth->addChild($asesor, $permission);
        }

        //common permission
        foreach ($commonMonitoring as $permission) {
            printf("Creating Permission: " . $permission . "\n");
            $permission = $auth->createPermission($permission);
            $auth->add($permission);
            printf("Assigning Permission to Roles \n");
            $auth->addChild($kaprodi, $permission);
            $auth->addChild($dekanat, $permission);
            $auth->addChild($rektorat, $permission);
        }

        //kaprodi permission
        foreach ($kaprodiPermission as $permission) {
            printf("Creating Permission: " . $permission . "\n");
            $permission = $auth->createPermission($permission);
            $auth->add($permission);
            printf("Assigning Permission to Roles \n");
            $auth->addChild($kaprodi, $permission);
        }

        //kaprodi permission
        foreach ($dekanatPermission as $permission) {
            printf("Creating Permission: " . $permission . "\n");
            $permission = $auth->createPermission($permission);
            $auth->add($permission);
            printf("Assigning Permission to Roles \n");
            $auth->addChild($dekanat, $permission);
        }

        //unit permission
        foreach ($unitPermission as $permission) {
            printf("Creating Permission: " . $permission . "\n");
            $permission = $auth->createPermission($permission);
            $auth->add($permission);
            printf("Assigning Permission to Roles \n");
            $auth->addChild($unit, $permission);
        }

        //prodi permissions
        foreach ($isiLedProdiPermission as $permission) {
            printf("Creating Permission: " . $permission . "\n");
            $permission = $auth->createPermission($permission);
            $auth->add($permission);
            printf("Assigning Permission to Roles \n");
            $auth->addChild($prodi, $permission);
        }
        $auth->addChild($kaprodi, $prodi);


        //fakultas permissions
        foreach ($fakultasPermission as $permission) {
            printf("Creating Permission: " . $permission . "\n");
            $permission = $auth->createPermission($permission);
            $auth->add($permission);
            printf("Assigning Permission to Roles \n");
            $auth->addChild($fakultas, $permission);
        }

        printf("Add Prodi Permission to Fakultas and Dekanat\n");
        $auth->addChild($fakultas, $prodi);
        $auth->addChild($dekanat, $fakultas);

        //asesor permissions
        foreach ($isiLedInstitusiPermission as $permission) {
            printf("Creating Permission: " . $permission . "\n");
            $permission = $auth->createPermission($permission);
            $auth->add($permission);
        }
        //asesor permissions
        foreach ($asesorPermission as $permission) {
            printf("Creating Permission: " . $permission . "\n");
            $permission = $auth->createPermission($permission);
            $auth->add($permission);
            printf("Assigning Permission to Roles \n");
            $auth->addChild($asesor, $permission);
        }


        printf("create asesor rule");
        $accessProdiAsesor = new AccessProdiAsesor();
        $accessPtAsesor = new AccessPtAsesor();

        $auth->add($accessProdiAsesor);
        $auth->add($accessPtAsesor);

        print("create izin asesor permission");
        $izinProdiAsesor = $auth->createPermission('izinProdiAsesor');
        $izinProdiAsesor->description = "Access ke dalam pengisian prodi sebagai asesor";
        $izinProdiAsesor->ruleName = $accessProdiAsesor->name;
        $auth->add($izinProdiAsesor);

        $izinPtAsesor = $auth->createPermission('izinPtAsesor');
        $izinPtAsesor->description = "Akses ke dalam pengisian pt sebagai asesor";
        $izinPtAsesor->ruleName = $accessPtAsesor->name;
        $auth->add($izinPtAsesor);


        //prodi rules
        printf("Create AccessOwnProdi Rule \n");
        $accessOwnProdi = new AccessOwnProdi;
        $auth->add($accessOwnProdi);
        printf("Create izinProdi Permission\n");
        $izinProdi = $auth->createPermission('izinProdi');
        $izinProdi->description = "Access kedalaman pengisian borang prodi";
        $izinProdi->ruleName = $accessOwnProdi->name;
        $auth->add($izinProdi);

        $prodiRoute = $auth->getPermission('@app-akreditasi/kriteria9/k9-prodi/*');
        $prodiRoute2 = $auth->getPermission('@app-akreditasi/kriteria9/prodi/*');
        printf("Adding izinProdi to Appropriate Roles\n");
        $auth->addChild($izinProdi, $prodiRoute);
        $auth->addChild($prodi, $izinProdi);

        printf("adding izinProdiAsesor to prodi permission");
        $auth->addChild($izinProdiAsesor, $prodiRoute);
        $auth->addChild($asesor, $izinProdiAsesor);
        $auth->addChild($izinProdiAsesor, $prodiRoute2);


        $institusiLed = $auth->getPermission('@app-akreditasi/kriteria9/k9-institusi/*');
        printf("adding izinPtAsesor to pt permission");
        $auth->addChild($izinPtAsesor, $institusiLed);
        $auth->addChild($asesor, $izinPtAsesor);

        //unit rules
        printf("Create AccessOwnUnit Rule \n");
        $accessOwnUnit = new AccessOwnUnit;
        $auth->add($accessOwnUnit);
        printf("Create izinUnit Permission\n");
        $izinUnit = $auth->createPermission('izinUnit');
        $izinUnit->description = "Access kedalaman pengisian unit";
        $izinUnit->ruleName = $accessOwnUnit->name;
        $auth->add($izinUnit);

        $unitRoute1 = $auth->getPermission('@app-akreditasi/unit/default/*');
        printf("Adding izinUnit to Appropriate Roles\n");
        $auth->addChild($izinUnit, $unitRoute1);
        $unitRoute2 = $auth->getPermission('@app-akreditasi/unit/kegiatan/*');
        $auth->addChild($izinUnit, $unitRoute2);
        $unitRoute3 = $auth->getPermission('@app-akreditasi/unit/profil/*');
        $auth->addChild($izinUnit, $unitRoute3);

        $auth->addChild($unit, $izinUnit);

        //Fakultas Rules.

        printf("Create AccessOwnFakultas Rule \n");
        $accessOwnFakultas = new AccessOwnFakultas;
        $auth->add($accessOwnFakultas);
        printf("Create izinFakultas Permission\n");
        $izinFakultas = $auth->createPermission('izinFakultas');
        $izinFakultas->description = "Access kedalaman pengisian fakultas";
        $izinFakultas->ruleName = $accessOwnFakultas->name;
        $auth->add($izinFakultas);

        $fakultasRoute1 = $auth->getPermission('@app-akreditasi/fakultas/*');
        printf("Adding izinFakultas to Appropriate Roles\n");
        $auth->addChild($izinFakultas, $fakultasRoute1);
        $auth->addChild($fakultas, $izinFakultas);

        $auth->addChild($rektorat, $lpm);
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
