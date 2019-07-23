<?php
$ini = parse_ini_file(__DIR__.'/../../system-configuration.ini');

return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'instansi'=>$ini['instansi'],
    'nama_sistem'=>$ini['nama_sistem'],
];
