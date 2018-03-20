<?php
use \kartik\datecontrol\Module;

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

//debug(Yii::$app->controller->id);
//debug($params['explController']);die;

$config = [
    'language' => 'ru',
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'site/redirect',
    'bootstrap' => ['log'],
    'on beforeRequest' => function () {
        $user = Yii::$app->user->identity;
        if ($user && $user->timezone) {
            Yii::$app->setTimeZone($user->timezone);
        }
    },
    'modules' => [
        'gridview' => [
            'class' => 'kartik\grid\Module'
        ],
        'api' => [
            'class' => 'app\modules\api\api',
        ],
            'admin' => [
//            'class' => 'mdm\admin\Module',
            'class' => 'app\modules\admin\Module',
            'defaultRoute' => 'userm/index',
            'layout' => '@app/views/layouts/admin.php',
            ],
            'transport' => [
                'class' => 'app\modules\transport\Module',
//                to see breadcrumbs
                'layout' => '@app/views/layouts/transportDicts.php',
            ],
        'rbac' => [
            'class' => 'mdm\admin\Module',
            'controllerMap' => [
                 'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    /* 'userClassName' => 'app\models\User', */
                    'idField' => 'id',
                    'usernameField' => 'username',
                            ],
                ],
            'layout' => 'left-menu',
            'mainLayout' => '@app/views/layouts/admin.php',
//            'mainLayout' => '@app/views/layouts/admin.php',
            'menus' => [
                'assignment' => [
                    'label' => 'Grant Access' // change label
                ],
                'route' => null, // disable menu
            ],
        ],
        'datecontrol' =>  [
            'class' => '\kartik\datecontrol\Module',
            // format settings for displaying each date attribute (ICU format example)
            'displaySettings' => [
                Module::FORMAT_DATE => 'dd-MM-yyyy',
                Module::FORMAT_TIME => 'hh:mm:ss a',
                Module::FORMAT_DATETIME => 'dd-MM-yyyy hh:mm:ss a',
            ],

            // format settings for saving each date attribute (PHP format example)
            'saveSettings' => [
                Module::FORMAT_DATE => 'php:U', // saves as unix timestamp
                Module::FORMAT_TIME => 'php:H:i:s',
                Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
            ],

            // set your display timezone
            'displayTimezone' => 'Europe/Moscow',

            // set your timezone for date saved to db
            'saveTimezone' => 'UTC',

            // automatically use kartik\widgets for each of the above formats
            'autoWidget' => true,

            // default settings for each widget from kartik\widgets used when autoWidget is true
            'autoWidgetSettings' => [
                Module::FORMAT_DATE => ['type'=>2, 'pluginOptions'=>['autoclose'=>true]], // example
                Module::FORMAT_DATETIME => [], // setup if needed
                Module::FORMAT_TIME => [], // setup if needed
            ],

            // custom widget settings that will be used to render the date input instead of kartik\widgets,
            // this will be used when autoWidget is set to false at module or widget level.
            'widgetSettings' => [
                Module::FORMAT_DATE => [
                    'class' => 'yii\jui\DatePicker', // example
                    'options' => [
                        'dateFormat' => 'php:d-M-Y',
                        'options' => ['class'=>'form-control'],
                    ]
                ]
            ]
        ],
        ],
        
    'components' => [
        'session' => [
            'class' => 'yii\web\DbSession',

            // Set the following if you want to use DB component other than default 'db'.
            // 'db' => 'mydb',

            // To override default session table, set the following
            // 'sessionTable' => 'my_session',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
//            'loginUrl' => null,
            'loginUrl' => ['site/login'],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'VOicrntZ1A0xyK4Zg9qQKcOh8PHxjvWo',
            'baseUrl'=> '',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'formatter' => [
            'dateFormat' => 'dd-MM-Y',
            'datetimeFormat' => 'dd-MM-Y HH:mm:ss',
            'timeFormat' => 'HH:mm:ss',
            'locale' => 'ru-RU', //your language locale
            'defaultTimeZone' => 'Europe/Moscow', // time zone
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        // 'user' => [
        //     'identityClass' => 'app\models\User',
        //     'enableAutoLogin' => true,
        // ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // RestApi
                ['class' => 'yii\rest\UrlRule', 'controller' => 'app\modules\api\RequestsController', 'pluralize'=>false], // 'pluralize'=>false for working at CURL
                // Fix for datetimepicker
                'POST datecontrol/parse/convert' => 'datecontrol/parse/convert',
            ],
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
//            'api/*',
            'gridview/*',
            'datecontrol/*',
            'transport/*',
            // 'rbac/*',
            // 'requests/index',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],
    'params' => $params,
];

 if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
         'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
 }

return $config;
