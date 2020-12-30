<?php

use common\models\Constants;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'id-ID',
    'sourceLanguage' => 'id-ID',
    'timezone' => 'Asia/Jakarta',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => \yii\rbac\DbManager::class,
//            'ruleFile' => '@common/auth/rbac/rules.php',
//            'assignmentFile' => '@common/auth/rbac/assignments.php',
//            'itemFile' => '@common/auth/rbac/items.php',
        ],
        'queue' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db', // DB connection component or its config
            'tableName' => '{{%queue}}', // Table name
            'channel' => 'default', // Queue channel key
            'mutex' => \yii\mutex\MysqlMutex::class, // Mutex that used to sync queries
            'as jobMonitor' => \zhuravljov\yii\queue\monitor\JobMonitor::class,
            'as workerMonitor' => \zhuravljov\yii\queue\monitor\WorkerMonitor::class,
        ],
        'formatter' => [
            'locale' => 'id_ID',
            'decimalSeparator' => ',',
            'thousandSeparator' => '.',

        ],
    ],
    'container' => [
        'definitions' => [
            'dosamigos\tinymce\TinyMce' => [
                'options' => ['rows' => 8],
                'language' => 'id',
                'clientOptions' => [
                    'plugins' => [
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak ",
                        "searchreplace wordcount visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table directionality",
                        "emoticons template paste textpattern imagetools codesample toc noneditable",
                    ],
                    'toolbar' => "undo redo| styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | ltr rtl | link | image"

                ]
            ],
            'kartik\file\FileInput' => [
                'pluginOptions' => [
                    'theme' => 'explorer-fas',
                    'maxFileSize' => Constants::MAX_UPLOAD_SIZE(),
                    'showUpload' => false,
                    'previewFileType' => 'any',
                    'fileActionSettings' => [
                        'showZoom' => true,
                        'showRemove' => false,
                        'showUpload' => false,
                    ],
                ]
            ]
        ]
    ]
];
