<?php

namespace console\controllers;
use mdm\admin\models\AuthItem;
use mdm\admin\models\Route;
use Yii;
use yii\console\Controller;

class AuthController extends Controller
{

    public function actionUp(){
        $auth = Yii::$app->getAuthManager();

        $su = $auth->getRole('superadmin');
        $permissions = ['@app-admin/*','@app-akreditasi/*','@app-monitoring/*'];

        foreach ($permissions as $permission){
            $permission = $auth->createPermission($permission);
            $auth->add($permission);
            $auth->addChild($su,$permission);

        }


        return true;
    }

    public function actionDown(){
        $auth = Yii::$app->getAuthManager();

        $su = $auth->getRole('superadmin');
        $permissions = ['@app-admin/*','@app-akreditasi/*','@app-monitoring/*'];

        foreach ($permissions as $permission){
            $item = $auth->getPermission($permission);
            $auth->removeChildren($item);
            $auth->remove($item);
        }
    }
}