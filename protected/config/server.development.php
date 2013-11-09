<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    // application components
    'components' => array(
        'facebook' => array(
            'appId' => '473003326096962', // needed for JS SDK, Social Plugins and PHP SDK
            'secret' => '1d0ee4026fcef85c1eb2ebfda5792aac', // needed for the PHP SDK 
        ),
        
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=CDA',
            'username' => 'root',
            'password' => '',
            // Enable profiling
            // 'enableProfiling' => true,
            // 'enableParamLogging' => true,
        ),
    ),
);