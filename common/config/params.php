<?php
$ini = parse_ini_file(__DIR__ . '/../../system-configuration.ini');

return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'instansi' => $ini['instansi'],
    'nama_sistem' => $ini['nama_sistem'],
    'url_instansi' => $ini['url_instansi'],
    'author' => $ini['author'],
    'author_url' => $ini['author_url'],
    'bsVersion' => '4.x', // this will set globally `bsVersion` to Bootstrap 4.x for all Krajee Extensions
    'mdm.admin.configs' => [
        'advanced' => [
            'app-admin' => [
                '@common/config/main.php',
                '@common/config/main-local.php',
                '@admin/config/main.php',
                '@admin/config/main-local.php',
            ],
            'app-akreditasi' => [
                '@common/config/main.php',
                '@common/config/main-local.php',
                '@akreditasi/config/main.php',
                '@akreditasi/config/main-local.php',
            ],
            'app-monitoring' => [
                '@common/config/main.php',
                '@common/config/main-local.php',
                '@monitoring/config/main.php',
                '@monitoring/config/main-local.php',
            ],
        ],
    ],

    'uploadPath' => '{lembaga}/{jenis_akreditasi}/{tahun}/{level}/{id}'

];
