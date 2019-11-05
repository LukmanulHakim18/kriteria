<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-akreditasi',
    'name' => $params['nama_sistem'],
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'akreditasi\controllers',
    'modules' => [
        'profile' => [
            'class' => 'common\modules\profile\Profile'
        ],
        'kriteria9' => [
            'class' => 'akreditasi\modules\kriteria9\Kriteria9',
            'modules' => [
                'k9-institusi' => [
                    'class' => 'akreditasi\modules\kriteria9\modules\institusi\K9Institusi',
                ],
                'k9-fakultas' => [
                    'class' => 'akreditasi\modules\kriteria9\modules\fakultas\K9Fakultas',
                ],
                'k9-prodi' => [
                    'class' => 'akreditasi\modules\kriteria9\modules\prodi\K9Prodi',
                ],
            ]
        ],
        'unit' => [
            'class' => 'akreditasi\modules\unit\Unit',
        ]
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-akreditasi',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-akreditasi', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-akreditasi',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
            'rules' => [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap4\BootstrapAsset' => [
                    'sourcePath' => '@common/assets/metronic/assets',

                    'css' => ['css/demo1/style.bundle.css']
                ]
            ]
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/login',
            'site/error',
            'site/logout',
//            'admin/*',
//            'debug/*',
//            'sertifikat/*',
//            'sertifikat-perguruan-tinggi/*',
//            'sertifikat/*',
//            'sertifikat-prodi/*'
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],
    'params' => $params,
];
