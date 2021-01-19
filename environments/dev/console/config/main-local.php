<?php
return [
    'bootstrap' => ['gii'],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '::1', '192.168.2.2', '192.168.10.1'], // adjust this to your needs

        ]
    ],
];
