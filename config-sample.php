<?php
if (!defined('WEBROOT_DIR')) die();

/**
 * Local site config.
 * Copy this file to config.php and edit.
 */

// uncomment the following two lines for enable development tool and debug info.
//define('YII_DEBUG', true);
//define('YII_ENV', 'dev');

return [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - 
            // this is required by cookie validation
            'cookieValidationKey' => '',
        ],
        // Database configuration.
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2basic',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
    ],
    // Configure your modules here:
    'modules' => [
    //    'debug' => [
    //        'allowedIPs' => ['192.168.1.*'],
    //    ],
    //    'gii' => [
    //        'allowedIPs' => ['192.168.1.*'],
    //    ],
    ],
    'params' => [
        // Application parameters.
    ],
];
