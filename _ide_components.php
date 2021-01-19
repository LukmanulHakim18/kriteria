<?php
/*
 * Yii2 IDE Autocomplete Helper
 *
 * @author  Vitaliy IIIFX Khomenko (c) 2019
 * @license MIT
 *
 * @link    https://github.com/iiifx-production/yii2-autocomplete-helper
 */

class Yii extends \yii\BaseYii
{
    /**
     * @var BaseApplication|WebApplication|ConsoleApplication
     */
    public static $app;
}

/**
 * @property yii\caching\FileCache $cache
 * @property yii\rbac\DbManager $authManager
 * @property yii\db\Connection $db
 * @property yii\swiftmailer\Mailer $mailer
 * @property yii\web\UrlManager $urlManager
 * @property yii\queue\db\Queue $queue
 * @property iiifx\Yii2\Autocomplete\Component $autocomplete
 */
abstract class BaseApplication extends \yii\base\Application {}

/**
 * @property yii\caching\FileCache $cache
 * @property yii\rbac\DbManager $authManager
 * @property yii\db\Connection $db
 * @property yii\swiftmailer\Mailer $mailer
 * @property yii\web\UrlManager $urlManager
 * @property yii\queue\db\Queue $queue
 * @property iiifx\Yii2\Autocomplete\Component $autocomplete
 */
class WebApplication extends \yii\web\Application {}

/**
 * @property yii\caching\FileCache $cache
 * @property yii\rbac\DbManager $authManager
 * @property yii\db\Connection $db
 * @property yii\swiftmailer\Mailer $mailer
 * @property yii\web\UrlManager $urlManager
 * @property yii\queue\db\Queue $queue
 * @property iiifx\Yii2\Autocomplete\Component $autocomplete
 */
class ConsoleApplication extends \yii\console\Application {}
