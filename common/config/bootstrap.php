<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@akreditasi', dirname(__DIR__, 2) . '/akreditasi');
Yii::setAlias('@monitoring', dirname(__DIR__, 2) . '/monitoring');
Yii::setAlias('@admin', dirname(__DIR__, 2) . '/admin');
Yii::setAlias('@console', dirname(__DIR__, 2) . '/console');
Yii::setAlias('@uploadAkreditasi', '@akreditasi/web/upload');
Yii::setAlias('@uploadAdmin', '@admin/web/upload');
Yii::setAlias('@required', '@common/required');

Yii::setAlias('@.akreditasi','http://kriteria.test');
Yii::setAlias('@.monitoring','http://monitoring.kriteria.test');
Yii::setAlias('@.admin','http://admin.kriteria.test');
Yii::setAlias('@.uploadAkreditasi','@.akreditasi/upload');
Yii::setAlias('@.uploadAdmin','@.admin/upload');
