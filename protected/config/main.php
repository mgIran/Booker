<?php
return array(
    'onBeginRequest'=>create_function('$event', 'return ob_start("ob_gzhandler");'),
    'onEndRequest'=>create_function('$event', 'return ob_end_flush();'),
	'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'بوکر',
    'timeZone' => 'Asia/Tehran',
    'theme' => 'abound',
    'language' => 'fa_ir',
		// preloading 'log' component
	'preload'=>array('log','userCounter'),

	// autoloading model and component classes
	'import'=>array(
        'application.vendor.*',
        'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
        'admins',
        'users',
        'setting',
        'pages',
        'map',
	),

	// application components
	'components'=>array(
        'userCounter' => array(
            'class' => 'application.components.UserCounter',
            'tableUsers' => 'ym_counter_users',
            'tableSave' => 'ym_counter_save',
            'autoInstallTables' => true,
            'onlineTime' => 5, // min
        ),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
            'class' => 'WebUser',
			'loginUrl'=>array('/login'),
		),
        'authManager'=>array(
            'class'=>'CDbAuthManager',
            'connectionID'=>'db',
        ),
		// uncomment the following to enable URLs in path-format
        // @todo change rules in projects
		'urlManager'=>array(
			'urlFormat'=>'path',
            'showScriptName'=>false,
            'appendParams'=>true,
			'rules'=>array(
				'<action:(logout|login|register|dashboard)>' => 'users/public/<action>',
				'<action:(terms|help|privacy|contactUs|about)>' => 'site/<action>',
                '<module:\w+>/<controller:\w+>'=>'<module>/<controller>/index',
                '<controller:\w+>/<action:\w+>/<id:\d+>/<title:(.*)>'=>'<controller>/<action>',
                '<controller:\w+>/<id:\d+>/<title:(.*)>'=>'<controller>/view',
                '<module:\w+>/<controller:\w+>/<id:\d+>/<title:\w+>'=>'<module>/<controller>/view',
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<module>/<controller>/<action>/view',
                '<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<id:\d+>'=>'<module>/<controller>/view',
            ),
		),

		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels'=>'error, warning, trace, info',
                    'categories'=>'application.*',
                ),
                // uncomment the following to show log messages on web pages
                array(
                    'class' => 'CWebLogRoute',
                    'enabled' => YII_DEBUG,
                    'levels'=>'error, warning, trace, info',
                    'categories'=>'application.*',
                    'showInFireBug' => true,
                ),
			),
		),
        'clientScript'=>array(
            'class'=>'ext.minScript.components.ExtMinScript',
            'coreScriptPosition' => CClientScript::POS_HEAD,
            'defaultScriptFilePosition' => CClientScript::POS_END,
        ),
    ),
    'controllerMap' => array(
        'min' => array(
            'class' =>'ext.minScript.controllers.ExtMinScriptController',
        )
    ),
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// @todo change webmail of emails
		'adminEmail'=>'webmaster@booker.ir',
        'noReplyEmail' => 'no-reply@booker.ir',
        'mailTheme'=>
            '<h2 style="box-sizing:border-box;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;-o-box-sizing:border-box;border-radius:2px 2px 0 0;margin-bottom:0;box-sizing:border-box;display: block;width: 100%;background-color: rgb(239, 83, 80);line-height:60px;color:#fff;font-size: 24px;text-align: right;padding-right: 50px">بوکر<span style="font-size: 14px;color:#f0f0f0"> - مرجع انواع نرم افزار تلفن های هوشمند</span></h2>
             <div style="display: inline-block;width: 100%;font-family:tahoma;line-height: 28px;">
                <div style="direction:rtl;display:block;overflow:hidden;border:1px solid #dadada;border-radius: 0 0 2px 2px;text-align: center;padding:15px;">{MessageBody}</div>
             </div>
             <div style="font-size: 8pt;color: #bbb;text-align: right;font-family: tahoma;padding: 15px;">
                <a href="'.((strpos($_SERVER['SERVER_PROTOCOL'], 'https'))?'https://':'http://').$_SERVER['HTTP_HOST'].'/about">درباره</a> | <a href="'.((strpos($_SERVER['SERVER_PROTOCOL'], 'https'))?'https://':'http://').$_SERVER['HTTP_HOST'].'/help">راهنما</a>
                <span style="float: left;"> همهٔ حقوق برای بوکر محفوظ است. ©‏ 1395 </span>
             </div>',
	),
);
